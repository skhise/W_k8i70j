<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Contract;
class ContractBaseAccessory extends Model
{
    use HasFactory;
    
    protected $table = 'contract_base_accessory';
   protected $fillable = [
       'contractId',
       'productId',
       'accessoryId',
       'isBase',
       'serviceSchedule',
       'totalQty',
       'perServiceAllocatedQty',
       'usedQty',
       'balanceQty',
       'price',
       'serviceDay',
       'Is_Paid',
    ];
    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }
}