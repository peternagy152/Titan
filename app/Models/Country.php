<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    protected $guarded = [] ;
    protected $casts = [
        'flag' => "array" ,
    ];

    public function City(){
        return $this->hasMany(City::class);
    }

    public function Address(){
        return $this->hasMany(Address::class);
    }

}
