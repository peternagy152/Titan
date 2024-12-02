<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

class Product extends Model
{
    use HasFactory, HasTranslations;
    protected $guarded = [];
    protected $casts = [
        "image" => "array",
        "gallery" => "array",
        "og_image" => "array",
        "facebook_image" => "array",
        "twitter_image" => "array",
    ];

    protected $translatable = [
        "name",
        "description",
        "short_description",
        "meta_title",
        "meta_description",
        "og_title",
        "og_description",
        "twitter_title",
        "twitter_description",
        "facebook_title",
        "facebook_description"
    ];


    public function ShopCategory()
    {
        return $this->belongsToMany(ShopCategory::class, 'shop_category_products', 'product_id', 'shop_category_id');
    }

    public function ProductImage()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function ProductReview()
    {
        return $this->hasMany(ProductReview::class);
    }

    public function orderItem(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function Branch(): BelongsToMany{
        return $this->belongsToMany(Branch::class,'branch_products','product_id','branch_id');
    }
}
