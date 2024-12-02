<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Blog extends Model
{
    use HasFactory;
    use HasTranslations;

    protected $guarded = [];

    public array $translatable = [
        "title",
        "content" ,
        "desc",
        "seo"
    ];

    protected $casts = [
        "featured_image" => "array",
        "seo" => "json" ,
        "extra_fields" => "json"
    ];
}
