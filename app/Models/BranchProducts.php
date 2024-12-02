<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BranchProducts extends Model
{
    use HasFactory;

    protected $table = 'branch_products';

    protected $fillable = ['branch_id', 'product_id', 'is_available'];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
