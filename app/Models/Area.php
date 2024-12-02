<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function City(){
        return $this->belongsTo(City::class);
    }

    public function Branch(){
        return $this->hasOne(Branch::class);
    }

}
