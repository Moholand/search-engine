<?php

namespace App\Http\Controllers\Api\Checkout\Cart;

use App\Http\Controllers\Controller;
use App\Services\Api\User\Cart\CartService;
use App\Tools\Constants;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function __construct(private CartService $cartService)
    {}

    public function index()
    {
        return null;
    }

    /**
     * Route:: GET:/api/carts/items-count
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function itemsCount()
    {
        return response()->json(['items_count' => $this->cartService->itemsCount(Auth::user())],Constants::HTTP_STATUS_OK);
    }
}
