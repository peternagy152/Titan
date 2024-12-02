<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;
    protected $guarded = [] ;

    public function Country(){
        return $this->belongsTo(Country::class);
    }
    public function Area(){
        return $this->hasMany(Area::class);
    }



}
