<?php

namespace App\Services\Search;

use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Arr;

class SearchService
{
    public function __construct(private Client $client) {}

    /**
     * @param array|null $data
     * @param int $page
     * @param int $perPage
     * @return LengthAwarePaginator
     * @throws ClientResponseException
     * @throws ServerResponseException
     */
    public function search(?array $data, int $page, int $perPage): LengthAwarePaginator
    {
        $params = $this->buildSearchParams($data, $page, $perPage);

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

    /**
     * @param array|null $data
     * @param int $page
     * @param int $perPage
     * @return array
     */
    private function buildSearchParams(?array $data, int $page, int $perPage): array
    {
        $queryArray = $this->getQueryArray();

        $queryArray = $this->addTitleQuery($data, $queryArray);
        $queryArray = $this->addCategoryQuery($data, $queryArray);
        $queryArray = $this->addPriceQuery($data, $queryArray);
        $queryArray = $this->addBrandQuery($data, $queryArray);

        return $this->getParams($queryArray, $perPage, $page, $data['sort'] ?? null);
    }

    /**
     * @param array|null $data
     * @param array $queryArray
     * @return array
     */
    private function addTitleQuery(?array $data, array $queryArray): array
    {
        if (isset($data['title'])) {
            return $this->getTitleQuery($data['title'], $queryArray);
        }
        return $queryArray;
    }

    /**
     * @param array|null $data
     * @param array $queryArray
     * @return array
     */
    private function addCategoryQuery(?array $data, array $queryArray): array
    {
        if (isset($data['category'])) {
            return $this->getCategoryQuery($data['category'], $queryArray);
        }
        return $queryArray;
    }

    /**
     * @param array|null $data
     * @param array $queryArray
     * @return array
     */
    private function addPriceQuery(?array $data, array $queryArray): array
    {
        if (isset($data['price_from']) && isset($data['price_to'])) {
            return $this->getPriceyQuery($data['price_from'], $data['price_to'], $queryArray);
        }
        return $queryArray;
    }

    /**
     * @param array|null $data
     * @param array $queryArray
     * @return array
     */
    private function addBrandQuery(?array $data, array $queryArray): array
    {
        if (isset($data['brand'])) {
            return $this->getBrandQuery($data['brand'], $queryArray);
        }
        return $queryArray;
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
                'should' => [],
                'filter' => []
            ]
        ];
    }

    /**
     * @param array $queryArray
     * @param int|null $perPage
     * @param int|null $page
     * @param string|null $sort
     * @return array
     */
    public function getParams(array $queryArray, ?int $perPage = null, ?int $page = null, ?string $sort = null): array
    {
        $params = [
            'index' => 'products',
            'body' => [
                'query' => $queryArray,
            ]
        ];

        if ($perPage && $page) {
            $params['body']['size'] = $perPage;
            $params['body']['from'] = ($page - 1) * $perPage;
        }

        if ($sort) {
            [$sortField, $sortOrder] = explode(',', $sort);
            $params['body']['sort'] = [
                $sortField => [
                    'order' => $sortOrder
                ]
            ];
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

    public function getCategoryQuery(string $categories, array $queryArray): array
    {
        $categoryArray = explode(',', $categories);

        foreach ($categoryArray as $category) {
            $queryArray['bool']['should'][] = [
                'match' => [
                    'category.name' => $category
                ],
            ];
        }

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

    /**
     * @param string $brand
     * @param array $queryArray
     * @return array
     */
    public function getBrandQuery(string $brand, array $queryArray): array
    {
        $brandArray = explode(',', $brand);

        $shouldClauses = [];

        foreach ($brandArray as $brand) {
            $shouldClauses[] = [
                'match' => [
                    'brand.name' => $brand
                ],
            ];
        }

        $queryArray['bool']['must'][] = [
            'bool' => [
                'should' => $shouldClauses,
                'minimum_should_match' => 1
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
