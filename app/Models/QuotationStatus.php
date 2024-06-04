<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuotationStatus extends Model
{

    protected $table = "master_quotation_status";

    protected $fillable = [
        "id",
        "status_name"
    ];
}