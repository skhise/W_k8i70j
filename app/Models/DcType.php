<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DcType extends Model
{

    protected $table = "dc_type";

    protected $fillable = [
        "id",
        "dc_type_name"
    ];
}