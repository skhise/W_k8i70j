<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AreaName extends Model
{
    use SoftDeletes, HasFactory;
    
   protected $table = 'master_site_area';
   protected $fillable = [
       'SiteAreaName',
    ];
 
}