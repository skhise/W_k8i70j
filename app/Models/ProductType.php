<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class ProductType extends Model
{
    use HasFactory;
    
    protected $table = 'master_product_type';
   protected $fillable = [
       'id',
       'type_name',
    ];

    
}