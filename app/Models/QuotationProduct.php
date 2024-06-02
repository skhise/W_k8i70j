<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuotationProduct extends Model
{

    protected $table = "quotation_product";
    protected $fillable = [
        "quot_id",
        "product_id",
        "amount",
        "description",
    ];
}