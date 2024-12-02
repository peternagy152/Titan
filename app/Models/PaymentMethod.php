<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class PaymentMethod extends Model
{
    use HasFactory;
    
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'status' => 'string',
    ];

    public function order(): BelongsToMany{
        return $this->belongsToMany(Order::class);
    }
}
