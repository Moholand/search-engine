<?php

namespace App\Models\Checkout;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Cart
 *
 * @property int $id
 * @property Collection|Product[] products
 */
class Cart extends Model
{
    use HasFactory;

    const STATUS_CREATED = 'created';

    const TYPE_INCREASE = 'increase';
    const TYPE_DECREASE = 'decrease';

    protected $fillable = [
        'user_id',
        'status'
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'rel_cart_product')->withPivot('count');
    }
}
