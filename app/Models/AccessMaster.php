<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AccessMaster extends Model
{
    use SoftDeletes, HasFactory;
    
   protected $table = 'master_role_access';
   protected $fillable = [
       'access_role_name',
       'access_type',
    ];
 
}