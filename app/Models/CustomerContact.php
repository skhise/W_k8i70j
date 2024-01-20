<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Customer;
class CustomerContact extends Model
{
    use HasFactory;
    
    protected $table = 'customer_contact';
   protected $fillable = [
       'CST_ID',
       'CNT_Name',
       'CNT_Mobile',
       'CNT_Department',
       'CNT_Email',
       'CNT_Phone1',
       'CNT_Phone2'

    ];
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}