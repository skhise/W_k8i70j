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
                "EMP_CPRNumber",
                "EMP_Email",
                "EMP_Qualification",
                "EMP_MobileNumber",
                "EMP_CompanyMobile",
                "EMP_Address",
                "EMP_TechnicalAbilities",
                "EMP_Created_By",
                'Access_Role'
       
       
    ];
    protected $primaryKey = 'EMP_ID';
}