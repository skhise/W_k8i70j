<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Service;

class ServiceHistory extends Model
{
    use HasFactory;

    protected $table = 'service_action_history';
    protected $fillable = [
        'service_id',
        'status_id',
        'user_id',
        'sub_status_id',
        'action_description',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

}