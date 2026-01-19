<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class VisitType extends Model
{
    use SoftDeletes, HasFactory;
    
    protected $table = 'master_visit_type';
   protected $fillable = [
       'type_name',
    ];
}