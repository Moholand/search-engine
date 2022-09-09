<?php

namespace App\Console\Commands;

use Elastic\Elasticsearch\Client;
use Illuminate\Console\Command;

class DeleteIndex extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'elastic:delete-index {index}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will delete index';

    private $client;

    /**
     * Create a new command instance.
     *
     * @param  Client  $client
     * @return void
     */
    public function __construct(Client $client)
    {
        parent::__construct();

        $this->client = $client;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            $this->info('start Deleting...');

            $deleteParams = [
                'index' => $this->argument('index')
            ];
            $response = $this->client->indices()->delete($deleteParams);

            $this->info($response);
        } catch(\Exception $e) {
            $this->error($e->getMessage());
        }
    }
}
