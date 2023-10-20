<?php

namespace App\Console\Commands;

use App\Actions\CreateProductAction;
use App\Models\User;
use Illuminate\Console\Command;

class ImportFromAmazonCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-from-amazon-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(CreateProductAction $action)
    {
        $data = \Http::get('https://api.amazon.com/products')->json();

        foreach ($data as $item) {
            $action->handle($item['title'], User::first());
        }
    }
}
