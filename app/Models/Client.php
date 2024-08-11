<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CustomerContact;
use App\Models\CustomerSites;

class Client extends Model
{
    use HasFactory;

    protected $table = 'clients';
    protected $fillable = [
        'account_id',
        'CST_ID',
        'CST_Code',
        'userId',
        'CST_Name',
        'CST_Website',
        'CST_OfficeAddress',
        'CST_SiteAddress',
        'CST_Note',
        'CST_Status',
        'CCP_Name',
        'CCP_Mobile',
        'CCP_Department',
        'pan_no',
        "gst_no",
        'CCP_Email',
        'CCP_Phone1',
        'CCP_Phone2',
        'Ref_Employee',
        'CST_Created_By'

    ];
    protected $primaryKey = 'CST_ID';

    public static function rules()
    {
        return [
            'CST_Code' => "required|unique:customers,CST_Code,{$this->primaryKey}",
            'Customer_Name' => "required|unique:customers,CST_Name,{$this->primaryKey}",
            "CCP_Name" => "required",
            "CCP_Mobile" => "required",

        ];
    }
    public function sites()
    {
        return $this->hasMany(CustomerSites::class, 'CustomerId', 'CST_ID');
    }
    public function contact()
    {
        return $this->hasMany(ContactPerson::class, 'CST_ID', 'CST_ID');

    }
    public static function boot()
    {
        parent::boot();
        self::deleting(function ($customer) { // before delete() method call this
            if ($customer->sites()->count() > 0) {
                $customer->sites()->each(function ($site) {
                    $site->delete();
                });
            }
            if ($customer->contact()->count() > 0) {
                $customer->contact()->each(function ($contact) {
                    $contact->delete();
                });
            }
            if ($customer->quotations()->count() > 0) {
                $customer->quotations()->each(function ($quotations) {
                    $quotations->delete();
                });
            }

            // do the rest of the cleanup...
        });
    }
    public function contracts()
    {
        return $this->hasMany(Contract::class, 'CNRT_CustomerID', 'CST_ID');
    }
    public function quotations(){
        return $this->hasMany(Quotation::class, 'customer_id', 'CST_ID');
    }
    public function scopeFilter($query, array $filters)
    {

        $query->when($filters['search'] ?? null, function ($query, $search) use ($filters) {

            $search_field = $filters['search_field'] ?? '';
            if (empty ($search_field)) {
                $query->where('CST_Name', 'like', '%' . $search . '%')
                    ->orWhere('CST_Code', 'like', '%' . $search . '%');
            }
            if ($search_field == "CST_Name") {
                $query->where('CST_Name', 'like', '%' . $search . '%');
            }
            if ($search_field == "CST_Code") {
                $query->where('CST_Code', 'like', '%' . $search . '%');
            }

        })->when($filters['trashed'] ?? null, function ($query, $trashed) {
            if ($trashed === 'with') {
                $query->withTrashed();
            } elseif ($trashed === 'only') {
                $query->onlyTrashed();
            }
        })->when($filters['filter_status'] ?? null, function ($query, $search) {
            $query->where('CST_Status', 'like', '%' . $search . '%');
        });
    }
}