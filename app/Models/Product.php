<?php

namespace App\Models;

use App\Policies\ProductPolicy;
use Illuminate\Database\Eloquent\Attributes\UsePolicy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[UsePolicy(ProductPolicy::class)]
class Product extends Model
{
    protected $fillable = [
        'category_id',
        'product_name',
        'product_description',
        'product_price',
        'product_image',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
}
