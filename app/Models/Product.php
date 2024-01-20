<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    
    protected $table = 'products';
   protected $fillable = [
       'Product_ID',
       'Product_Name',
       'Product_Description',
       'Product_Price',
       'Image_Path',
        'Status',
        'type'
    ];

    protected $primaryKey = 'Product_ID';
}