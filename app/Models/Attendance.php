<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;
    
    protected $table = 'attendance';
   protected $fillable = [
       'User_ID',
       'Att_Date',
       'Att_In',
       'Att_In_Location',
       'Att_Out',
       'Att_Out_Location',
    ];

}