<?php

namespace App\Http\Controllers\Api\User\Cart;

use App\Http\Controllers\Controller;
use App\Services\Api\User\Cart\CartService;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function __construct(private CartService $cartService)
    {}

    /**
     * Route:: GET:/api/carts/items-count
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function itemsCount()
    {
        return response()->json($this->cartService->itemsCount(Auth::user()),200);
    }
}
