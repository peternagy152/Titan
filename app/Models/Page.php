<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Page extends Model
{
    use HasFactory;
    use HasTranslations;

    protected $guarded = [];

    public array $translatable = [
        'title', 'content', 'seo', 'extra_fields',
    ];

    protected $casts = [
        'seo' => 'array',
        'extra_fields' => 'array',
    ];
}
