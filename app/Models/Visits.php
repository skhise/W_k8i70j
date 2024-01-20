<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visits extends Model
{
    use HasFactory;
    
   protected $table = 'visits';
   protected $fillable = [
       'User_ID',
       'fromLocation',
       'fromLat',
       'fromLng',
       'toLocation',
       'toLat',
       'toLng',
       'totalKm',
       'visitDate',
       'visitType',
       'visitRemark',
       'otherInfo',
       'visitStatus',
       'visitCharges',
    ];
 
}