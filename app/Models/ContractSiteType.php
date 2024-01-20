<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContractSiteType extends Model
{
    use HasFactory;
    
    protected $table = 'master_site_type';
   protected $fillable = [
       'site_type_name',
    ];
}