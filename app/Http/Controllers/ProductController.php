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
        $query = $request->query('query');
        $category = $request->query('category');
        $priceFrom = $request->query('priceFrom');
        $priceTo = $request->query('priceTo');

        if ($query || $category || $priceFrom || $priceTo) {
            $page = $request->query('page', 1);
            $from = (($page - 1) * self::RESULT_PER_PAGE);

            $queryArray = [
              'bool' => [
                  'must' => [],
                  'filter' => []
              ]
            ];

            if ($query) {
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
            }

            if ($category) {
                $queryArray['bool']['filter'][] = [
                    'term' => [
                        'category_id' => $category
                    ]
                ];
            }

            if ($priceFrom || $priceTo) {
                $queryArray['bool']['filter'][] = [
                    'range' => [
                        'price' => [
                            'gte' => $priceFrom ?? 0,
                            'lte' => $priceTo ?? Product::max('price')
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

            $url = 'api/products/search?query=';
            $urlWithQu = isset($query) ? $url . $query : $url;
            $urlWithCat = isset($category) ? $urlWithQu . '&category=' . $category : $urlWithQu;
            $urlWithPrice = isset($priceFrom) || isset($priceTo) ? $urlWithCat . '&priceFrom=' . $priceFrom . '&priceTo' . $priceTo : $urlWithCat;

            $pagination = new LengthAwarePaginator(
                $result_data,
                $total['value'],
                self::RESULT_PER_PAGE,
                $page,
                ['path' => url($urlWithPrice)]);

            return response()->json($pagination,200);
        }
    }

    public function recommendations(Request $request)
    {
        $query = $request->query('query');

        if ($query) {

            $queryArray = [
                'bool' => [
                    'must' => [],
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
                    'size' => 5,
                ]
            ];

            $result = $this->client->search($params);
            $total = $result['hits']['total'];

            if (isset($result['hits']['hits'])) {
                $result_data = Arr::pluck($result['hits']['hits'], '_source');
            }

            return response()->json($result_data,200);
        }
    }
}
