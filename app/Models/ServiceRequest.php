<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceRequest extends Model
{
    use HasFactory;
    
    protected $table = 'newservicerequest';
    protected $fillable = [
       'Customer_Id',
       'ServiceType',
       'IssueType',
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