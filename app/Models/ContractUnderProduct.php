<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContractUnderProduct extends Model
{
    use HasFactory;

    protected $table = 'contract_under_product';
    protected $fillable = [
        'contractId',
        'product_name',
        'product_type',
        'product_price',
        'product_description',
        'other',
        'branch',
        'updated_by',
        'no_of_service',
        'serviceDay',
        'isScheduleAdded',
        'remark',
        'service_period'

    ];
}