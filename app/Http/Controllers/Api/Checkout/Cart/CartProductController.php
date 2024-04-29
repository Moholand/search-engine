<?php

namespace App\Http\Controllers\Api\Checkout\Cart;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Checkout\CartProductRequest;
use App\Models\Product;
use App\Models\User\Cart;
use App\Services\Api\Checkout\Cart\CartProductService;
use App\Tools\Constant;
use Illuminate\Http\JsonResponse;

class CartProductController extends Controller
{
    public function __construct(private CartProductService $cartProductService)
    {}

    /**
     * Route:: PATCH:/api/carts/{cart}/products/{product}/change-count
     *
     * @param CartProductRequest $request
     * @param Cart $cart
     * @param Product $product
     * @return JsonResponse
     */
    public function changeCount(CartProductRequest $request, Cart $cart, Product $product)
    {
        $this->cartProductService->changeCount($request->get('type'), $cart, $product->id);

        return response()->json(
            ['response_message' => 'successful request'],
            Constant::HTTP_STATUS_OK
        );
    }
}
