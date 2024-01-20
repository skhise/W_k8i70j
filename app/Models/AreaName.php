<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AreaName extends Model
{
    use HasFactory;
    
   protected $table = 'master_site_area';
   protected $fillable = [
       'SiteAreaName',
    ];
 
}