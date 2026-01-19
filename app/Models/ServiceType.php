<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceType extends Model
{
    use SoftDeletes, HasFactory;
    
    protected $table = 'master_service_type';
   protected $fillable = [
       'type_name',
    ];
}