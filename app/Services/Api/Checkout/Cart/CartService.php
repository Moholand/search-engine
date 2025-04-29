<?php

namespace App\Services\Api\Checkout\Cart;

use App\Models\User\User;
use App\Repositories\Api\Checkout\CartRepository;
use Illuminate\Database\Eloquent\Collection;

class CartService
{
    public function __construct(private CartRepository $cartRepository)
    {}

    public function index(User $user): Collection
    {
        return $this->cartRepository->index($user);
    }

    public function itemsCount(User $user): array
    {
        return [
            'items_count' => $this->cartRepository->itemsCount($user->id)
        ];
    }
}
