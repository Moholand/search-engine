<?php

namespace App\Console\Commands;

use App\Jobs\IndexModelJob;
use App\Models\Product;
use Illuminate\Console\Command;

class IndexModelCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'elastic:index-model';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            Product::with('category', 'brand')
                ->chunk(100, function ($records) {
                    foreach ($records as $record) {
                        dispatch(new IndexModelJob($record->id, $record->toArray()));
                    }
                });
        } catch(\Exception $e) {
            $this->error($e->getMessage());
        }
    }
}
