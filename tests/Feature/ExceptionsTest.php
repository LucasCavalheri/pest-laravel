<?php

use App\Console\Commands\CreateProductCommand;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use function Pest\Laravel\artisan;

it('should be able to guarantee that the user exists', function () {
    artisan(
        CreateProductCommand::class,
        ['title' => 'Jeremias', 'user' => 99]
    );
})->throws(\Illuminate\Validation\ValidationException::class);
