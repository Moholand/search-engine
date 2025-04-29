<?php

namespace App\Http\Controllers\Api\Checkout\Cart;

use App\Http\Controllers\Controller;
use App\Services\Api\Checkout\Cart\CartService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function __construct(private CartService $cartService)
    {}

    /**
     * Route:: GET:/api/carts
     */
    public function index(): JsonResponse
    {
        return response()->json(
            $this->cartService->index(Auth::user()), 
            Response::HTTP_OK
        );
    }

    /**
     * Route:: GET:/api/carts/items-count
     */
    public function itemsCount(): JsonResponse
    {
        return response()->json(
            $this->cartService->itemsCount(Auth::user()),
            Response::HTTP_OK
        );
    }
}
