<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Customer;
class CustomerSites extends Model
{
    use HasFactory;
    
   protected $table = 'customer_sites';
   protected $fillable = [
       'CustomerId',
       'SiteNumber',
       'SiteName',
       'AreaName',
       'SiteOther',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}