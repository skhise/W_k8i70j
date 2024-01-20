<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoginSessionHistory extends Model
{
    use HasFactory;
    
   protected $table = 'login_session_history';
   protected $fillable = [
       'Role',
       'User_Id',
       'Login_Token',
       'Ip_Address',
    ];
 
}