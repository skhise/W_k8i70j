<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductAssignment extends Model
{
    protected $fillable = ['employee_id', 'notes'];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'EMP_ID');
    }

    public function items(): HasMany
    {
        return $this->hasMany(ProductAssignmentItem::class, 'product_assignment_id');
    }
}
