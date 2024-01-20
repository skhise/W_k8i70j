<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContractType extends Model
{
    use HasFactory;
    
    protected $table = 'master_contract_type';
   protected $fillable = [
       'contract_type_name',
    ];
}