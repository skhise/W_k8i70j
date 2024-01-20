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
        return $this->hasMany(CustomerContact::class, 'CST_ID', 'CST_ID');

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

            // do the rest of the cleanup...
        });
    }
    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) use ($filters) {
            $search_field = $filters['search_field'] ?? '';
            if (empty($search_field)) {
                $query->where('client_name', 'like', '%' . $search . '%')
                    ->orWhere('phone', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhere('client_code', 'like', '%' . $search . '%')
                    ->orWhere('website', 'like', '%' . $search . '%');
            }
            if ($search_field == "client_name") {
                $query->where('client_name', 'like', '%' . $search . '%');
            }
            if ($search_field == "phone") {
                $query->where('phone', 'like', '%' . $search . '%');
            }
            if ($search_field == "email") {
                $query->where('email', 'like', '%' . $search . '%');
            }

        })->when($filters['trashed'] ?? null, function ($query, $trashed) {
            if ($trashed === 'with') {
                $query->withTrashed();
            } elseif ($trashed === 'only') {
                $query->onlyTrashed();
            }
        });
    }
}