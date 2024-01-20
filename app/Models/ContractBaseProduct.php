<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Contract;
class ContractBaseProduct extends Model
{
    use HasFactory;
    
    protected $table = 'contract_base_product';
   protected $fillable = [
       'ID',
       'CNRT_ID',
       'BaseProduct_ID',
       'BaseProduct_QTY',
    ];
    protected $primaryKey = 'ID';

    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }
}