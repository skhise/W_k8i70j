<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $table = 'employees';
    protected $fillable = [
        "EMP_ID",
        "EMP_Name",
        "EMP_CPRUpload",
        'Profile_Image',
        "EMP_Designation",
        "EMP_Status",
        "EMP_Code",
        "EMP_Email",
        "EMP_Qualification",
        "EMP_MobileNumber",
        "EMP_CompanyMobile",
        "EMP_Address",
        "EMP_TechnicalAbilities",
        "EMP_Created_By",
        'Access_Role',
        'password'


    ];
    protected $primaryKey = 'EMP_ID';

    public function scopeFilter($query, array $filters)
    {

        $query->when($filters['search'] ?? null, function ($query, $search) use ($filters) {

            $search_field = $filters['search_field'] ?? '';
            if (empty ($search_field)) {
                $query->where('EMP_Name', 'like', '%' . $search . '%')
                    ->orWhere('EMP_MobileNumber', 'like', '%' . $search . '%');
            }
            if ($search_field == "EMP_Name") {
                $query->where('EMP_Name', 'like', '%' . $search . '%');
            }
            if ($search_field == "EMP_MobileNumber") {
                $query->where('EMP_MobileNumber', 'like', '%' . $search . '%');
            }

        })->when($filters['trashed'] ?? null, function ($query, $trashed) {
            if ($trashed === 'with') {
                $query->withTrashed();
            } elseif ($trashed === 'only') {
                $query->onlyTrashed();
            }
        })->when($filters['filter_status'] ?? null, function ($query, $search) {
            $query->where('Access_Role', 'like', '%' . $search . '%');
        });
    }
}