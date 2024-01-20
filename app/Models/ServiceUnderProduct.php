<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceUnderProduct extends Model
{
    use HasFactory;
    
    protected $table = 'service_under_product';
   protected $fillable = [
       'serviceId',
       'contractId',
       'productId',
       'product_name',
       'product_type',
       'product_price',
       'product_description',
       'nrnumber',
       'other',
       'branch',
       'updated_by',

    ];
}