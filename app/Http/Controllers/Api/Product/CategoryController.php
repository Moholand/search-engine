<?php

namespace App\Http\Controllers\Api\Product;

use App\Http\Controllers\Controller;
use App\Services\Api\Product\CategoryService;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    public function __construct(private CategoryService $categoryService)
    {}

    /**
     * Route(GET):: /api/categories
     *
     * @return JsonResponse
     */
    public function index()
    {
        return response()->json($this->categoryService->index(), 200);
    }
}
