<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Elastic\Elasticsearch\Client;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
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
        if ($query = $request->query('query')) {
            $page = $request->query('page', 1);
            $from = (($page - 1) * self::RESULT_PER_PAGE);

            $queryArray = [
              'bool' => [
                  'must' => []
              ]
            ];

            $tokens = explode(' ', $query);

            foreach ($tokens as $token) {
                $queryArray['bool']['must'][] = [
                    'match' => [
                        'title' => [
                            'query' => $token,
                            'fuzziness' => 'AUTO'
                        ]
                    ]
                ];
            }

            $params = [
                'index' => 'products',
                'body' => [
                    'query' => $queryArray,
                    'size' => self::RESULT_PER_PAGE,
                    'from' => $from
                ]
            ];

            $result = $this->client->search($params);
            $total = $result['hits']['total'];

            if (isset($result['hits']['hits'])) {
                $result_data = Arr::pluck($result['hits']['hits'], '_source');
            }

            $pagination = new LengthAwarePaginator(
                $result_data,
                $total['value'],
                self::RESULT_PER_PAGE,
                $page,
                ['path' => url('api/products/search?query=' . $query)]);

            return response()->json($pagination,200);
        }
    }

//    protected function getSearchFilterAggregations ()
//    {
//        $params = [
//            'index' => 'products',
//            'body' => [
//                'query' => [
//                    'match_all' => new \stdClass(),
//                ],
//                'size' => 0,
//                'aggs' =>
//            ]
//        ];
//    }
}
