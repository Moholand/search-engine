<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Elastic\Elasticsearch\Client;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function index(Request $request)
    {
        $variables = [];

        if ($query = $request->query('query')) {
            $variables['query'] = $query;

            $params = [
                'index' => 'ecommerce',
                'type' => 'product',
                'body' => [
                    'query' => [
                        'match' => [
                            'name' => $query
                        ]
                    ]
                ]
            ];

            $result = $this->client->search($params);

            if (isset($result['hits']['hits'])) {
                $variables['hits'] = $result['hits']['hits'];
            }
        }

        return response()->json(Product::paginate(20),200);
    }

    public function search(Request $request)
    {
        $variables = [];

        if ($query = $request->query('query')) {
            $variables['query'] = $query;

            $params = [
                'index' => 'ecommerce',
                'type' => 'product',
                'body' => [
                    'query' => [
                        'match' => [
                            'name' => $query
                        ]
                    ]
                ]
            ];

            $result = $this->client->search($params);

            if (isset($result['hits']['hits'])) {
                $variables['hits'] = $result['hits']['hits'];
            }
        }

        return response()->json($variables,200);
    }
}
