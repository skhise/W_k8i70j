<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RepairInward extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'repair_inwards';
    
    protected $fillable = [
        'defective_no',
        'defective_date',
        'customer_id',
        'ticket_no',
        'status_id',
        'spare_type_id',
        'part_model_name',
        'alternate_sn',
        'spare_description',
        'product_remark',
        'current_product_location',
        'remark',
        'created_by'
    ];

    protected $dates = ['defective_date', 'deleted_at'];

    public function customer()
    {
        return $this->belongsTo(Client::class, 'customer_id', 'CST_ID');
    }

    public function statusHistory()
    {
        return $this->hasMany(RepairInwardStatusHistory::class, 'repair_inward_id')->orderBy('created_at', 'desc');
    }

    public function spareType()
    {
        return $this->belongsTo(ProductType::class, 'spare_type_id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'ticket_no', 'service_no');
    }

    public function repairStatus()
    {
        return $this->belongsTo(RepairStatus::class, 'status_id');
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->where('defective_no', 'like', '%' . $search . '%')
                    ->orWhereHas('customer', function ($q) use ($search) {
                        $q->where('CST_Name', 'like', '%' . $search . '%');
                    })
                    ->orWhere('ticket_no', 'like', '%' . $search . '%');
            });
        });

        $query->when($filters['status'] ?? null, function ($query, $status) {
            if ($status != '' && $status != 'all') {
                $query->where('status_id', $status);
            }
        });
    }
}
