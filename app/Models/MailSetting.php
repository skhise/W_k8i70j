<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MailSetting extends Model
{
    use HasFactory;
    
    protected $table = 'email_settings';
   protected $fillable = [
                "smtp_server",
                "smtp_port",
                "smtp_login_name",
                'smtp_password',
                "smtp_ssl",
                "smtp_mail_from",
                "test_email",
                "call_register_template",
                "call_register_mail_allowed",
                "call_forward_template",
                "call_forward_mail_allowed",
                "customer_add_template",
                "customer_add_mail_allowed",
                "employee_add_template",
                "employee_add_mail_allowed"
    ];
   
}