<?php

namespace App\Console\Commands;

use Elastic\Elasticsearch\Client;
use Exception;
use Illuminate\Console\Command;

class CreateIndexCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'elastic:create-index {index}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create product index command';

    private $client;

    /**
     * Create a new command instance.
     *
     * @param  Client $client
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
            $this->info('Start creating an index...');

            $response = $this->client->indices()->create($this->params());

            $this->info($response);
        } catch (Exception $e) {
            $this->error($e->getMessage());
        }
    }

    /**
     * Index params
     *
     * @return array
     */
    protected function params()
    {
        return [
            'index' => $this->argument('index'),
            'body' => [
                'settings' => [
                    'number_of_shards' => 2,
                    'number_of_replicas' => 0
                ]
            ]
        ];
    }
}
