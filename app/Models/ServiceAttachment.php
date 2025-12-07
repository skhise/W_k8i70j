<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceAttachment extends Model
{
    use HasFactory;

    protected $table = 'service_attachments';
    
    protected $fillable = [
        'service_id',
        'file_name',
        'original_file_name',
        'file_type',
        'file_size',
        'google_drive_file_id',
        'google_drive_url',
        'description',
        'uploaded_by',
    ];

    /**
     * Get the service that owns the attachment.
     */
    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

    /**
     * Get the user who uploaded the attachment.
     */
    public function uploadedBy()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}

