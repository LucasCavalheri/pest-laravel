<?php

use App\Http\Middleware\JeremiasMiddleware;
use App\Models\User;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;
use function Pest\Laravel\mock;

it('should block a request if the user does not have the following email: jeremias@pinguim.academy', function () {
    $user = User::factory()->create(['email' => 'email@qualquer.com']);
    $jeremias = User::factory()->create(['email' => 'jeremias@pinguim.academy']);

    actingAs($user);
    get(route('secure-route'))->assertForbidden();

    actingAs($jeremias);
    get(route('secure-route'))->assertOk();
});

test('check if is being called', function () {
    mock(JeremiasMiddleware::class)
        ->shouldReceive('handle')
        ->atLeast()->once();

    get(route('secure-route'));
});
