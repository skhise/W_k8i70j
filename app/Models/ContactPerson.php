<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Customer;

class ContactPerson extends Model
{
    use HasFactory;

    protected $table = 'contact_person';
    protected $fillable = [
        'CNT_ID',
        'CST_ID',
        'CNT_Name',
        'CNT_Mobile',
        'CNT_Department',
        'CNT_Email',
        'CNT_Phone1',
        'CNT_Phone2'

    ];
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}