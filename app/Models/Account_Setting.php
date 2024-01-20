<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account_Setting extends Model
{
    use HasFactory;
    
   protected $table = 'master_account_setting';
   protected $fillable = [
       'vat',
       'AgreementBody',
       'DefaultSignText',
       'DefaultSiignImgeUrl',
       'renewal_days',
       'termandconditions',
       'companyname',
       'companyAddress',
       'ContactInformation',
       'mail_signature',
       'company_display_name',
       'serviceno_ins',
       'contractno_ins',
    ];
 
}