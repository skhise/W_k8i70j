<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LocationHistory extends Model
{
    use HasFactory;
    
    protected $table = 'employee_location_history';
   protected $fillable = [
       'User_ID',
       'last_long',
       'last_lang',
       'full_address',
       'area_code',
    ];
}