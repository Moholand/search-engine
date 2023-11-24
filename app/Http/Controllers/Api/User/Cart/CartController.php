<?php

namespace App\Http\Controllers\Api\User\Cart;

use App\Http\Controllers\Controller;
use App\Services\Api\User\Cart\CartService;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function __construct(private CartService $cartService)
    {}

    public function itemsCount()
    {
        $count = $this->cartService->itemsCount(Auth::user());
    }
}

