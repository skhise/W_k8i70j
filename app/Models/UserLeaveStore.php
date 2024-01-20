<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLeaveStore extends Model
{
    use HasFactory;
    
    protected $table = 'user_leave_store';
   protected $fillable = [
       'User_ID',
       'Sick_Leave',
       'Paid_Leave',
       'Forwarded_Leave',
       'Total_Leave',
        'Leave_Balance',
        'Year',
    ];

}