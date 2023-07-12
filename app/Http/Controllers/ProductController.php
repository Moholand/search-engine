<?php

namespace App\Http\Controllers;

use App\Http\Requests\Search\SearchRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Services\Search\SearchService;

class ProductController extends Controller
{
    const RESULT_PER_PAGE = 20;

    public function __construct(private SearchService $searchService)
    {}

    /**
     * Route: GET::/api/products/{product}
     *
     * @param Product $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Product $product)
    {
        return response()->json(new ProductResource($product),200);
    }

    /**
     * @param SearchRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(SearchRequest $request)
    {
        $result = $this->searchService->search($request->validated(), $request->query('page', 1), self::RESULT_PER_PAGE);

        return response()->json($result,200);
    }

    /**
     * @param SearchRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function recommendations(SearchRequest $request)
    {
        $result = $this->searchService->recommendations($request->get('title'));

        return response()->json($result,200);
    }
}
