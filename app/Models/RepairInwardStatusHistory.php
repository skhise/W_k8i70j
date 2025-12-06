<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class RepairInwardStatusHistory extends Model
{
    use HasFactory;

    protected $table = 'repair_inward_status_history';

    protected $fillable = [
        'repair_inward_id',
        'old_status_id',
        'new_status_id',
        'changed_by',
        'remarks',
    ];

    public function repairInward()
    {
        return $this->belongsTo(RepairInward::class, 'repair_inward_id');
    }

    public function oldStatus()
    {
        return $this->belongsTo(RepairStatus::class, 'old_status_id');
    }

    public function newStatus()
    {
        return $this->belongsTo(RepairStatus::class, 'new_status_id');
    }

    public function changedBy()
    {
        return $this->belongsTo(User::class, 'changed_by');
    }
}
