<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    use HasFactory;
    
    protected $table = 'order_products';
   protected $fillable = [
       'Order_Id',
       'Product_Id',
       'Product_Name',
       'Product_Price',
       'Product_Qty',
    ];
}