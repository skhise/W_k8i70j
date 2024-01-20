<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Contract;
class ProductImage extends Model
{
    use HasFactory;
    
    protected $table = 'contract_product_images';
   protected $fillable = [
       'Product_Id',
       'Contract_Id',
       'Image_Path',
    ];

    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }
    
}