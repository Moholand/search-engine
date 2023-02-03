<?php

namespace App\Services\Search;

use Elastic\Elasticsearch\Client;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Arr;

class SearchService
{
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function search(?array $data, int $page, int $perPage): LengthAwarePaginator
    {
        $queryArray = $this->getQueryArray();

        if (isset($data['title'])) {
            $queryArray = $this->getTitleQuery($data['title'], $queryArray);
        }
        if (isset($data['category'])) {
            $queryArray = $this->getCategoryQuery($data['category'], $queryArray);
        }
        if (isset($data['price_from']) && isset($data['price_to'])) {
            $queryArray = $this->getPriceyQuery($data['price_from'], $data['price_to'], $queryArray);
        }

        $params = $this->getParams($queryArray, $perPage, $page);

        $result = $this->client->search($params);

        $products = new LengthAwarePaginator (
            $result['hits']['hits'],
            $result['hits']['total']['value'],
            $perPage,
            Paginator::resolveCurrentPage(),
            ['path' => Paginator::resolveCurrentPath()]
        );

        return $this->loadProducts($products->withQueryString());
    }

    public function recommendations(string $title): ?array
    {
        $queryArray = $this->getQueryArray();

        if ($title) {
            $queryArray = $this->getTitleQuery($title, $queryArray);
        }

        $params = $this->getParams($queryArray);

        $result = $this->client->search($params);
        $total = $result['hits']['total'];

        if (isset($result['hits']['hits'])) {
            return Arr::pluck($result['hits']['hits'], '_source');
        }
        return null;
    }

    public function getQueryArray(): array
    {
        return [
            'bool' => [
                'must' => [],
                'filter' => []
            ]
        ];
    }

    public function getParams(array $queryArray, ?int $perPage = null, ?int $page = null): array
    {
        $params = [
            'index' => 'products',
            'body' => [
                'query' => $queryArray
            ]
        ];

        if ($perPage && $page) {
            $params = array_merge($params, ['body' => [
                'query' => $queryArray,
                'size' => $perPage,
                'from' => ($page - 1) * $perPage
            ]]);
        }
        return $params;
    }

    public function getTitleQuery(string $title, array $queryArray): array
    {
        $queryArray['bool']['must'][] = [
            'match' => [
                'title' => [
                    'query' => $title,
                    'fuzziness' => 'AUTO'
                ]
            ]
        ];
        return $queryArray;
    }

    public function getCategoryQuery(string $category, array $queryArray): array
    {
        $queryArray['bool']['filter'][] = [
            'term' => [
                'category_id' => $category
            ]
        ];
        return $queryArray;
    }

    public function getPriceyQuery(string $priceFrom, string $priceTo, array $queryArray): array
    {
        $queryArray['bool']['filter'][] = [
            'range' => [
                'price' => [
                    'gte' => $priceFrom,
                    'lte' => $priceTo
                ]
            ]
        ];
        return $queryArray;
    }

    public function loadProducts($products): LengthAwarePaginator
    {
        foreach ($products as $key => $product) {
            $product_item['_score'] = $product['_score'];
            $product = $product['_source'];

            $product_item['id'] = $product['id'];
            $product_item['title'] = $product['title'];
            $product_item['price'] = $product['price'];
            $product_item['point'] = $product['point'];
            $product_item['image'] = $product['image'];
            $product_item['brand'] = [
                'name'       => $product['brand']['name'],
                'name_farsi' => $product['brand']['name_farsi']
            ];

            $products[$key] = $product_item;
        }

        return $products;
    }
}
