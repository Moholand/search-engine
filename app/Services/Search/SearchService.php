<?php

namespace App\Services\Search;

class SearchService
{
    public function search(array $data, int $page, int $perPage)
    {
        $from = ($page - 1) * $perPage;

        $queryArray = [
            'bool' => [
                'must' => [],
                'filter' => []
            ]
        ];
    }
}
