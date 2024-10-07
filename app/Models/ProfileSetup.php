<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class ProfileSetup extends Model
{
    use HasFactory;
    
    protected $table = 'profile_setup';
   protected $fillable = [
       'id',
       'comapny_name',
       'address',
       'contact_number',
       'wp_api_key',
       'wp_user_name',
       'company_email',
       'u_token',
       'created_at',
       'updated_at'
    ];


    
}