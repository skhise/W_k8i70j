<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MailLog extends Model
{
    use HasFactory;
    
   protected $table = 'mail_log';
   protected $fillable = [
       'sent_to',
       'subject',
       'message',
       'reason',
       'status',
    ];
 
}