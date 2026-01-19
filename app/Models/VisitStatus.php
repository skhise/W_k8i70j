<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class VisitStatus extends Model
{
    use SoftDeletes, HasFactory;
    
    protected $table = 'master_visit_status';
   protected $fillable = [
       'status_name',
    ];
}