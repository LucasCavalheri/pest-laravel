<?php

namespace App\Console\Commands;

use App\Actions\CreateProductAction;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CreateProductCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-product-command {title?} {user?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(CreateProductAction $action): void
    {
        $title = $this->argument('title');
        $user = $this->argument('user');


        if (!$user) {
            $user = $this->components->ask('Please, provide a valid user id');
        }

        if (!$title) {
            $title = $this->components->ask('Please, provide a title for the product');
        }

        Validator::make(['title' => $title, 'user' => $user], [
            'title' => ['required', 'string', 'min:3'],
            'user' => ['required', Rule::exists('users', 'id')]
        ])->validate();

        $action
            ->handle(
                $title, User::findOrFail($user)
            );

        $this->components->info('Product created!!');
    }
}
