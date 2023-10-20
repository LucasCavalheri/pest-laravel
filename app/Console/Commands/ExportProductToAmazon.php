<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class ExportProductToAmazon extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:export-product-to-amazon';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        Http::withToken(config('services.amazon.api_key'))
            ->post(
                'https://api.amazon.com/products',
                Product::all()->map(fn($p) => ['title' => $p->title])->toArray()
            );
    }
}
