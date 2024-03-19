<?php

namespace App\Http\Controllers\Api\Checkout\Cart;

use App\Http\Controllers\Controller;
use App\Services\Api\Checkout\Cart\CartProductService;
use App\Tools\Constants;
use Illuminate\Support\Facades\Auth;

class CartProductController extends Controller
{
    public function __construct(private CartProductService $cartProductService)
    {}

    /**
     * Route:: PATCH:/api/carts/{cart}/products/{product}/change-count
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function changeCount()
    {
        return response()->json(
            $this->cartProductService->changeCount(Auth::user()),
            Constants::HTTP_STATUS_OK
        );
    }
}
