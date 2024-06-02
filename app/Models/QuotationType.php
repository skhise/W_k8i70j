<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuotationType extends Model
{

    protected $table = "master_quotation_type";

    protected $fillable = [
        "id",
        "quot_type_name"
    ];
}