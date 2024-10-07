<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Contract;

class Schedule extends Model
{
    use HasFactory;
    
   protected $table = 'master_service_schedule';
   protected $fillable = [
       'scheduleName',
       'scheduleMonth',
    ];

    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }
 
}