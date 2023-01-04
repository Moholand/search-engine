<?php

namespace App\Services\Search;

use App\Models\Product;
use Elastic\Elasticsearch\Client;
use Illuminate\Pagination\LengthAwarePaginator;
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
        $total = $result['hits']['total'];

        if (isset($result['hits']['hits'])) {
            $result_data = Arr::pluck($result['hits']['hits'], '_source');
        }

        $url = 'api/products/search?title=';
        $urlWithQu = isset($data['title']) ? $url . $data['title'] : $url;
        $urlWithCat = isset($data['category']) ? $urlWithQu . '&category=' . $data['category'] : $urlWithQu;
        $urlWithPrice = isset($data['price_from']) || isset($data['price_to'])
            ? $urlWithCat . '&price_from=' . $data['price_from'] . '&price_to=' . $data['price_to'] : $urlWithCat;

        return new LengthAwarePaginator (
            $result_data,
            $total['value'],
            $perPage,
            $page,
            ['path' => url($urlWithPrice)]
        );
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
                'query' => $queryArray,
                'sort' => [
                    'point' => [
                        'order' => 'desc'
                    ]
                ]
            ]
        ];

        if ($perPage && $page) {
            $params = array_merge($params, ['body' => [
                'query' => $queryArray,
                'size' => $perPage,
                'from' => ($page - 1) * $perPage,
                'sort' => [
                    'point' => [
                        'order' => 'desc'
                    ]
                ]
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
}
