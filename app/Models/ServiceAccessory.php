<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Service;
class ServiceAccessory extends Model
{
    use HasFactory;
    
   protected $table = 'service_accessory';
   protected $fillable = [
       'service_id',
       'contract_id',
       'accessory_id',
       'given_qty',
       'price',
       'Is_Paid',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
 
}