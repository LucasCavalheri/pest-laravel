<?php

use App\Models\User;
use Illuminate\Http\UploadedFile;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\post;

it('should be able to upload an image', function () {
    Storage::fake('avatar');

    $user = User::factory()->create();

    actingAs($user);

    $file = UploadedFile::fake()->image('image.jpg');

    post(route('upload-avatar'), [
        'file' => $file
    ])->assertOk();

    Storage::disk('avatar')->assertExists($file->hashName());
});

it('should be to import a csv file', function () {
    $user = User::factory()->create();
    User::factory()->create();
    actingAs($user);

    $data = <<<txt
    Product 1,2
    Product 2,1
    txt;

    $file = UploadedFile::fake()->createWithContent('products.csv', $data);

    post(route('import-products'), ['file' => $file])->assertOk();

    assertDatabaseHas('products', ['title' => 'Product 1', 'owner_id' => 2]);
    assertDatabaseHas('products', ['title' => 'Product 2', 'owner_id' => 1]);
    assertDatabaseCount('products', 2);
});
