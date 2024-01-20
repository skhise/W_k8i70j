<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContractStatus extends Model
{
    use HasFactory;
    
    protected $table = 'master_contract_status';
   protected $fillable = [
       'contract_status_name',
    ];
}