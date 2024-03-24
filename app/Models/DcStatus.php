<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DcStatus extends Model
{


    protected $table = "master_dc_status";
    protected $filable = ["id", "dc_status_name"];
}