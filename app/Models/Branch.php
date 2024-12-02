<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Branch extends Model
{
    use HasFactory;
    
    public function Area(): BelongsTo{
        return $this->belongsTo(Area::class);
    }
    
    // public function Orders(): BelongsTo{
    //     return $this->belongsTo(Order::class);
    // }
    
    public function Orders(): HasMany{
        return $this->hasMany(Order::class, 'area_id', 'area_id');
    }
    
    public function Products(): BelongsToMany{
        return $this->belongsToMany(Product::class,'branch_products','branch_id','product_id');
    }
}
