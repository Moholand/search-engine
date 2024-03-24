<?php

namespace App\Http\Controllers\Api\Checkout\Cart;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\User\Cart;
use App\Services\Api\Checkout\Cart\CartProductService;
use App\Tools\Constants;

class CartProductController extends Controller
{
    public function __construct(private CartProductService $cartProductService)
    {}

    /**
     * Route:: PATCH:/api/carts/{cart}/products/{product}/change-count
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function changeCount(Cart $cart, Product $product)
    {
        $this->cartProductService->changeCount(request()->type, $cart, $product->id);

        return response()->json(
            ['response_message' => 'successful request'],
            Constants::HTTP_STATUS_OK
        );
    }
}
