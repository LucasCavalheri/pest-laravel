<?php


use App\Models\Product;
use App\Models\User;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;
use function Pest\Laravel\assertSoftDeleted;
use function Pest\Laravel\deleteJson;
use function Pest\Laravel\postJson;
use function Pest\Laravel\putJson;
use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

it('should be able o create a product', function () {
    $user = User::factory()->create();

    actingAs($user);

    postJson(
        route('product.store'),
        ['title' => 'Titulo qualquer']
    )->assertCreated();

    assertDatabaseHas('products', ['title' => 'Titulo qualquer']);

    assertTrue(
        Product::query()
            ->where(['title' => 'Titulo qualquer'])
            ->exists()
    );

    assertDatabaseCount('products', 1);
});

it('should be able to update a product', function () {
    $product = Product::factory()->create(['title' => 'Titulo qualquer']);

    putJson(
        route('product.update', $product),
        ['title' => 'Atualizando o titulo']
    )->assertOk();

    assertDatabaseHas('products', [
        'id' => $product->id,
        'title' => 'Atualizando o titulo'
    ]);

    expect($product)
        ->refresh()
        ->title->toBe('Atualizando o titulo');

    assertSame('Atualizando o titulo', $product->title);

    assertDatabaseCount('products', 1);
});

it('should be able to delete a product', function () {
    $product = Product::factory()->create();

    deleteJson(route('product.destroy', $product))
        ->assertOk();

    assertDatabaseMissing('products', [
        'id' => $product->id
    ]);

    assertDatabaseCount('products', 0);
});
it('should be able to soft-delete a product', function () {
    $product = Product::factory()->create();

    deleteJson(route('product.soft-delete', $product))
        ->assertOk();

    assertSoftDeleted('products', [
        'id' => $product->id
    ]);

    assertDatabaseCount('products', 1);
});
