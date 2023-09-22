<?php

namespace App\Http\Controllers\Api\Product;

use App\Http\Controllers\Controller;
use App\Services\Api\Product\CategoryService;

class CategoryController extends Controller
{
    public function __construct(private CategoryService $categoryService)
    {}

    /**
     * Route(GET):: /api/categories
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json($this->categoryService->index(), 200);
    }
}
