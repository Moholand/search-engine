<?php

namespace App\Http\Controllers\Api\Checkout\Cart;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Checkout\CartProductRequest;
use App\Models\Checkout\Cart;
use App\Models\Product;
use App\Services\Api\Checkout\Cart\CartProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class CartProductController extends Controller
{
    public function __construct(private CartProductService $cartProductService)
    {}

    /**
     * Route:: POST:/api/carts/products/{product}
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function addToCart(Product $product)
    {
        $this->cartProductService->addToCart($product);

        return response()->json(
            ['response_message' => 'successful request'],
            Response::HTTP_CREATED
        );
    }

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
        $this->authorize('update', [$cart, $product]);

        $this->cartProductService->changeCount($request->get('type'), $cart, $product->id);

        return response()->json(
            ['response_message' => 'successful request'],
            Response::HTTP_OK
        );
    }
}
