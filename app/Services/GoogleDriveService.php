<?php

namespace App\Services;

use Google_Client;
use Google_Service_Drive;

class GoogleDriveService
{
    protected $driveService;

    public function __construct()
    {
        $client = new Google_Client();
        $client->setClientId(config('services.google.client_id'));
        $client->setClientSecret(config('services.google.client_secret'));
        $client->refreshToken(config('services.google.refresh_token'));
        $client->setAccessType('offline');

        $this->driveService = new Google_Service_Drive($client);
    }

    public function uploadImage($filePath, $fileName)
    {
        $fileMetadata = new \Google_Service_Drive_DriveFile([
            'name' => $fileName
        ]);
        $content = file_get_contents($filePath);
        $file = $this->driveService->files->create($fileMetadata, [
            'data' => $content,
            'mimeType' => 'image/jpeg',
            'uploadType' => 'multipart',
            'fields' => 'id'
        ]);
        return $file->id;
    }
}
