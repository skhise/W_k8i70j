<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Designation extends Model
{
    use SoftDeletes, HasFactory;
    
    protected $table = 'master_designation';
   protected $fillable = [
       'designation_name',
    ];
    
}