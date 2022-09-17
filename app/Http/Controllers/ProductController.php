<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Elastic\Elasticsearch\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class ProductController extends Controller
{
    const RESULT_PER_PAGE = 20;

    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function index()
    {
        return response()->json(Product::paginate(self::RESULT_PER_PAGE),200);
    }

    public function search(Request $request)
    {
        $response = [];

        if ($query = $request->query('query')) {
            $page = $request->query('page', 1);
            $from = (($page - 1) * self::RESULT_PER_PAGE);

            $response['page'] = $page;
            $response['from'] = $from;

            $params = [
                'index' => 'products',
                'body' => [
                    'query' => [
                        'match' => [
                            'title' => $query
                        ]
                    ],
                    'size' => self::RESULT_PER_PAGE,
                    'from' => $from
                ]
            ];

            $result = $this->client->search($params);
            $total = $result['hits']['total'];
            $response['total'] = $total;

            $to = ($page * self::RESULT_PER_PAGE);
            $to = min($to, $total);
            $response['to'] = $to;

            if (isset($result['hits']['hits'])) {
                $response['hits'] = Arr::pluck($result['hits']['hits'], '_source');
            }

            return response()->json($response,200);
        }
    }
}
