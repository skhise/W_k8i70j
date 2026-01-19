<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceSubStatus extends Model
{
    use SoftDeletes, HasFactory;

    protected $table = 'master_service_sub_status';
    protected $fillable = [
        'Sub_Status_Name',
        'Sub_Status_Id',
        'status_id'
    ];
    protected $primaryKey = 'Sub_Status_Id';
}