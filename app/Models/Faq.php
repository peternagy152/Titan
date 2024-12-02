<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Translatable\HasTranslations;

class Faq extends Model
{
    use HasFactory;
    use HasTranslations;

    protected $guarded = [];

    public array $translatable = [
        'question',
        'answer',
    ];

    public function faqCategory(): BelongsToMany
    {
        return $this->belongsToMany(FaqCategory::class, 'category_faq', 'faq_id', 'category_id');
    }
}
