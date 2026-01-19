<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ActionReason extends Model
{
    use SoftDeletes, HasFactory;
    
   protected $table = 'master_service_action_reason';
   protected $fillable = [
       'reason_name',
    ];
 
}