<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLeave extends Model
{
    use HasFactory;
    
    protected $table = 'user_leave';
   protected $fillable = [
       'User_ID',
       'From_Date',
       'To_Date',
       'Leave_Reason',
       'Leave_Status',
        'Update_By',
        'Leave_Type',
        'Update_Note',
    ];

}