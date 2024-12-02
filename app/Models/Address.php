<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded = [];

    public function User(){
        return $this->belongsTo(User::class);
    }

    public function Country(){
        return $this->belongsTo(Country::class);
    }
    public function City(){
        return $this->belongsTo(City::class);
    }
    public function Area(){
        return $this->belongsTo(Area::class);
    }

}
