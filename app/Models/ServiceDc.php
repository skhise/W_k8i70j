<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceDc extends Model
{

    protected $table = "service_dc";
    protected $fillable = [
        "service_id",
        "dc_type",
        "dc_status",
        'dc_remark',
        'dc_amount',
        "issue_date"
    ];
}