<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewInquiry extends Model
{
    use HasFactory;
    
    protected $table = 'new_inquiry';
   protected $fillable = [
       'Customer_Id',
       'Name',
       'Email',
       'Phone',
       'VisitDate',
       'VisitTime',
       'Address',
       'Message',
       'status'
    ];
}