<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActionReason extends Model
{
    use HasFactory;
    
   protected $table = 'master_service_action_reason';
   protected $fillable = [
       'reason_name',
    ];
 
}