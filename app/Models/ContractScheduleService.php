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
    public function scopeFilter($query, array $filters)
{
    // Apply search filter if 'search' is provided in filters
    $query->when($filters['search'] ?? null, function ($query, $search) use ($filters) {
        $search_field = $filters['search'] ?? '';
        
        if (!empty($search)) {
            $query->where(function ($query) use ($search) {
                // Use 'like' for case-insensitive search (matches CST_Name)
                $query->orWhere('clients.CST_Name', 'like', ['%' . $search . '%']);
                // Optionally, add more fields to search
                $query->orWhere('CNRT_Number', 'like', '%' . $search . '%');
            });
        }
    })
    // Handle trashed status filter
    ->when($filters['trashed'] ?? null, function ($query, $trashed) {
        if ($trashed === 'with') {
            $query->withTrashed(); // Include soft deleted records
        } elseif ($trashed === 'only') {
            $query->onlyTrashed(); // Only show soft deleted records
        }
    });
}

}