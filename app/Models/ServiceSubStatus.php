<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceSubStatus extends Model
{
    use HasFactory;

    protected $table = 'master_service_sub_status';
    protected $fillable = [
        'Sub_Status_Name',
        'Sub_Status_Id',
        'status_id'
    ];
    protected $primaryKey = 'Status_Id';
}