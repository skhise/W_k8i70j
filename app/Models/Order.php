<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    
    protected $table = 'orders';
   protected $fillable = [
       'Customer_Id',
       'Order_Delivery_Address',
       'Order_Billing_Address',
       'Order_Amount',
       'Order_Payment_Status',
       'Order_Payment_Mode',
       'Order_Status',
       'Order_ContactPerson',
       'Order_Contact',
       "AreaName",
       "AreaCode",
       "Vat",
       "SubTotal",
       "CustomerName",
       "payment_method",
       "payment_id",
       "payment_status",
       "payment_date",
    ];
}