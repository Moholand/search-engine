<?php

namespace App\Http\Controllers;

use App\Http\Requests\Search\SearchRequest;
use App\Models\Product;
use App\Services\Search\SearchService;

class ProductController extends Controller
{
    const RESULT_PER_PAGE = 20;

    private SearchService $searchService;

    public function __construct(SearchService $searchService)
    {
        $this->searchService = $searchService;
    }

    // TODO: refactore this method. use elastic and write tests
    public function index()
    {
        return response()->json(Product::with('brand')->paginate(self::RESULT_PER_PAGE),200);
    }

    public function search(SearchRequest $request)
    {
        $result = $this->searchService->search($request->validated(), $request->query('page', 1), self::RESULT_PER_PAGE);

        return response()->json($result,200);
    }

    public function recommendations(SearchRequest $request)
    {
        $result = $this->searchService->recommendations($request->get('title'));

        return response()->json($result,200);
    }
}
