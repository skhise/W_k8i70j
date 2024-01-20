<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceStatus extends Model {
    use HasFactory;
    
   protected $table = 'master_service_status';
   protected $fillable = [
       'Status_Name',
       'status_color',
    ];
    protected $primaryKey = 'Status_Id';
}