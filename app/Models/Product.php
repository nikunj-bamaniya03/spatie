<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    protected $fillable = [
        'category_id',
        'product_name',
        'product_description',
        'product_price',
        'product_image',
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
}
