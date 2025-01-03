<?php

namespace App\Services\Api\Checkout\Cart;

use App\Models\Checkout\Cart;
use App\Models\Product;
use App\Repositories\Api\Checkout\CartProductRepository;
use Illuminate\Http\Response;

class CartProductService
{
    public function __construct(private CartProductRepository $cartProductRepository)
    {}

    public function addToCart(Product $product): void
    {
        $cart = $this->cartProductRepository->firstOrCreateCart(request()->user('api'));
        
        $this->cartProductRepository->addProductToCart($cart, $product->id);
    }

    public function deleteFromCart(Product $product): void
    {
        $cart = $this->cartProductRepository->getCurrentCart(request()->user('api'));

        if (!$cart || !$cart->products()->where('product_id', $product->id)->exists()) {
            abort(Response::HTTP_NOT_FOUND);
        }

        $this->cartProductRepository->removeProductFromCart($cart, $product->id);
    }

    public function changeCount(string $type, Cart $cart, int $productId): void
    {
        $this->cartProductRepository->changeCount($type, $cart, $productId);
    }
}
