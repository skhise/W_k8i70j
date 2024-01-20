<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceType extends Model
{
    use HasFactory;
    
    protected $table = 'master_service_type';
   protected $fillable = [
       'type_name',
    ];
}