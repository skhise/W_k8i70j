<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product_Accessory extends Model
{
    use HasFactory;
    
    protected $table = 'product_accessory';
   protected $fillable = [
       'PA_ID',
       'Product_ID',
       'PA_Name',
       'PA_Qty',
       'PA_Price'
    ];
    protected $primaryKey = 'PA_ID';
}