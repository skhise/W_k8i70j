<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Generate extends Model
{

    protected $table = "master_table";

    protected $fillable = [
        "id",
        "product_key"
    ];
}