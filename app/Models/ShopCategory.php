<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class ShopCategory extends Model
{
    use HasFactory;
    use HasTranslations;
    protected $guarded = [];

    protected $casts = [
        "seo" => "json",
        "image" => "array",
    ];

    public $translatable = [
        "name",
        "description",
    ];

    public function Product()
    {
        return $this->BelongsToMany(Product::class, 'shop_category_products', 'shop_category_id', 'product_id');
    }

    public function Children()
    {
        return $this->hasMany(ShopCategory::class, 'parent_id');
    }

    public function Parent()
    {
        return $this->belongsTo(ShopCategory::class, 'parent_id');
    }
}
