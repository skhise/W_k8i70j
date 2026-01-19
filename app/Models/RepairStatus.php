<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RepairStatus extends Model
{
    use SoftDeletes, HasFactory;

    protected $table = 'master_repairstatus';

    protected $fillable = [
        'status_name',
        'is_active',
    ];

    public function repairInwards()
    {
        return $this->hasMany(RepairInward::class, 'status_id');
    }
}
