<?php
namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class ProductSerialNumber extends Model
{


    protected $table = "product_serial_numbers";
    protected $fillable = [
        'id',
        'product_id',
        'sr_number',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

}