<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLeaveStore extends Model
{
    use HasFactory;
    
    protected $table = 'employee_visits';
   protected $fillable = [
       'User_ID',
       'Visit_Source',
       'Visit_Destination',
       ' Visit_Source_Coordinate',
       'Visit_Note',
        'Visit_Destination_Coordinate',
        'Visit_Date'
    ];

}