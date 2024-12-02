<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class FaqCategory extends Model
{
    use HasFactory;
    use HasTranslations;
    protected  $guarded = [] ;

    protected $translatable = ["name"] ;

    public function faq(){
        return $this->belongsToMany(Faq::class , "category_faq" , "category_id" , "faq_id");
    }


}
