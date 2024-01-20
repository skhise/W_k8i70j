<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Contract;
class ContractScheduleModel extends Model
{
    use HasFactory;
    
    protected $table = 'contract_schedule_service';
   protected $fillable = [
       'Contract_Id',
       'Accessory_Id',
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
        return $this->belongsTo(Contract::class);
    }
}