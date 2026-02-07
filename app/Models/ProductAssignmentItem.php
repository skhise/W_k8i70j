<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductAssignmentItem extends Model
{
    protected $fillable = ['product_assignment_id', 'product_id', 'quantity'];

    public function assignment(): BelongsTo
    {
        return $this->belongsTo(ProductAssignment::class, 'product_assignment_id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'Product_ID');
    }
}
