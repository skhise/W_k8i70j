<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceDcProduct extends Model
{

    protected $table = "service_dc_product";
    protected $fillable = [
        "service_id",
        "issue_date",
        "type",
        "product_id",
        "serial_no",
        "amount",
        "description",
    ];
}