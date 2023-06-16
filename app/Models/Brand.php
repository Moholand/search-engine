<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Brand
 *
 * @package App\Models
 *
 * @property int $id
 * @property string $name
 * @property string $name_farsi
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class Brand extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'name_farsi'
    ];
}
