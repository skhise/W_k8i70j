<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checklist extends Model
{
    use HasFactory;

    protected $table = 'contract_checklist';
    protected $fillable = [
        'id',
        'description',
        'contractId',
        'created_at',
        'updated_at',


    ];
    public function contract()
    {
        return $this->belongsTo(Contract::class, 'contractId', 'CNRT_ID');
    }
}