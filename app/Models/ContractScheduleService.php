<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Contract;

class ContractScheduleService extends Model
{
    use HasFactory;

    protected $table = 'contract_schedule_service';
    protected $fillable = [
        'contractId',
        'product_Id',
        'Schedule_Date',
        'Schedule_Qty',
        'Service_Call_Id',
        'Schedule_Status',
        'price',
        'isManaged',
        'issueType',
        'serviceType',
        'description',
        'payment'
    ];

    public function contract()
    {
        return $this->belongsTo(Contract::class, "contractId", "CNRT_ID");
    }
    // public function issuetype()
    // {
    //     return $this->belongsTo(IssueType::class, "issueType", "id");
    // }
    // public function servicetype()
    // {
    //     return $this->belongsTo(ServiceType::class, "serviceType", "id");
    //}
    public function product()
    {
        return $this->belongsTo(ContractUnderProduct::class, "product_Id", "id");
    }
}