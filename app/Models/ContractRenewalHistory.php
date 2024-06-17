<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Contract;

class ContractRenewalHistory extends Model
{
    use HasFactory;

    protected $table = 'contract_renewal_history';
    protected $fillable = [
        'id',
        'contract_id',
        'amount',
        'current_expiry_date',
        'new_start_date',
        'new_expiry_date',
        'renewal_note'
    ];
    public function contract()
    {
        return $this->belongsTo(Contract::class, 'contract_id', 'CNRT_ID');
    }
}