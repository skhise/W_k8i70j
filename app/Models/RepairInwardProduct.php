<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RepairInwardProduct extends Model
{
    use HasFactory;

    protected $table = 'repair_inward_products';
    
    protected $fillable = [
        'repair_inward_id',
        'spare_type_id',
        'part_model_name',
        'alternate_sn',
        'spare_description',
        'remark',
        'current_product_location'
    ];

    public function repairInward()
    {
        return $this->belongsTo(RepairInward::class, 'repair_inward_id');
    }

    public function spareType()
    {
        return $this->belongsTo(ProductType::class, 'spare_type_id');
    }
}
