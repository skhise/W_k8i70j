<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreProductCategory extends Model
{
    use HasFactory;
    
    protected $table = 'master_store_product_category';
   protected $fillable = [
       'name',
       'image'
    ];

}