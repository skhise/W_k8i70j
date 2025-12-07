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
       'user_id',
       'comapny_name',
       'address',
       'contact_number',
       'wp_api_key',
       'wp_user_name',
       'company_email',
       'u_token',
       'google_client_id',
       'google_client_secret',
       'google_refresh_token',
       'google_drive_folder_id',
       'created_at',
       'updated_at'
    ];

    /**
     * Get the user that owns the profile setup.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


    
}