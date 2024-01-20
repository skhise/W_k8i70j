<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreProduct extends Model
{
    use HasFactory;
    
    protected $table = 'storeproduct';
   protected $fillable = [
       'product_code',
       'product_name',
       'product_brand',
       'product_category',
       'product_qty',
        'product_price_mrp',
        'product_price_sell',
        'product_offer_price',
        'is_offer_active',
        'product_is_active',
        'product_description',
        'product_image_url'

    ];

}