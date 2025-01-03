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
     * @return JsonResponse
     */
    public function addToCart(Product $product): JsonResponse
    {
        $this->cartProductService->addToCart($product);

        return response()->json(
            ['response_message' => __('messages.added_successfully')],
            Response::HTTP_CREATED
        );
    }

    /**
     * Route:: DELETE:/api/carts/products/{product}
     *
     * @return JsonResponse
     */
    public function deleteFromCart(Product $product): JsonResponse
    {
        $this->cartProductService->deleteFromCart($product);

        return response()->json(
            ['response_message' => __('messages.removed_successfully')],
            Response::HTTP_OK
        );
    }

    /**
     * Route:: PATCH:/api/carts/products/{product}/change-count
     *
     * @param CartProductRequest $request
     * @param Product $product
     * @return JsonResponse
     */
    public function changeCount(CartProductRequest $request, Product $product)
    {
        $cart = $request->user('api')->carts()->where('status', Cart::STATUS_CREATED)->firstOrFail();
        $this->authorize('update', [$cart, $product]);

        $this->cartProductService->changeCount($request->get('type'), $cart, $product->id);

        return response()->json(
            ['response_message' => 'successful request'],
            Response::HTTP_OK
        );
    }
}
