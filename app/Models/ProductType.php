<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class ProductType extends Model
{
    use SoftDeletes, HasFactory;
    
    protected $table = 'master_product_type';
   protected $fillable = [
       'id',
       'type_name',
    ];

    
}