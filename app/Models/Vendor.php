<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'contact',
        'email',
        'phone',
    ];

    public function purchases()
    {
        return $this->hasMany(ProductPurchase::class, 'vendor_id');
    }
}
