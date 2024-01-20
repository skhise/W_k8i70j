<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisitStatus extends Model
{
    use HasFactory;
    
    protected $table = 'master_visit_status';
   protected $fillable = [
       'status_name',
    ];
}