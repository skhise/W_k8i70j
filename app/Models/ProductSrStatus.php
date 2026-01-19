<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductSrStatus extends Model
{
    use SoftDeletes, HasFactory;

    protected $table = 'master_product_sr_staus';
    protected $fillable = [
        'id',
        'sr_staus_name',
    ];


}