<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSrStatus extends Model
{
    use HasFactory;

    protected $table = 'master_product_sr_staus';
    protected $fillable = [
        'id',
        'sr_staus_name',
    ];


}