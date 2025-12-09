<?php

namespace App\Services;

use Google_Client;
use Google_Service_Drive;

class GoogleDriveService
{
    protected $driveService;
    protected $clientId;
    protected $clientSecret;
    protected $refreshToken;

    public function __construct($clientId = null, $clientSecret = null, $refreshToken = null)
    {
        // Use provided credentials or fall back to config
        $this->clientId = $clientId ?? config('services.google.client_id');
        $this->clientSecret = $clientSecret ?? config('services.google.client_secret');
        $this->refreshToken = $refreshToken ?? config('services.google.refresh_token');

        // Validate that we have all required credentials
        if (empty($this->clientId) || empty($this->clientSecret) || empty($this->refreshToken)) {
            throw new \Exception('Google Drive credentials are not configured. Please configure them in your profile settings.');
        }

        $client = new Google_Client();
        $client->setClientId($this->clientId);
        $client->setClientSecret($this->clientSecret);
        
        // Set the scope - default to drive scope if not configured
        $scope = config('services.google.drive_scope', 'https://www.googleapis.com/auth/drive');
        $client->setScopes([$scope]);
        $client->setAccessType('offline');
        $client->setApprovalPrompt('force');
        
        // Set the refresh token
        $client->refreshToken($this->refreshToken);
        
        // Actually fetch a new access token using the refresh token
        try {
            $accessToken = $client->fetchAccessTokenWithRefreshToken($this->refreshToken);
            
            if (isset($accessToken['error'])) {
                \Log::error('Google Drive token refresh failed', [
                    'error' => $accessToken['error'],
                    'error_description' => $accessToken['error_description'] ?? null,
                ]);
                throw new \Exception('Failed to refresh Google Drive access token: ' . ($accessToken['error_description'] ?? $accessToken['error']));
            }
            
            // Set the access token on the client
            $client->setAccessToken($accessToken);
            
        } catch (\Exception $e) {
            \Log::error('Google Drive authentication error: ' . $e->getMessage());
            throw new \Exception('Failed to authenticate with Google Drive: ' . $e->getMessage());
        }

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

    /**
     * Upload a file to Google Drive
     *
     * @param string $filePath Path to the file
     * @param string $fileName Name for the file in Google Drive
     * @param string|null $mimeType MIME type of the file (auto-detected if null)
     * @param string|null $folderId Optional folder ID to upload to
     * @return array Returns array with 'id' and 'webViewLink'
     */
    public function uploadFile($filePath, $fileName, $mimeType = null, $folderId = null)
    {
        try {
            // Auto-detect MIME type if not provided
            if (!$mimeType) {
                $mimeType = mime_content_type($filePath) ?: 'application/octet-stream';
            }

            $fileMetadata = new \Google_Service_Drive_DriveFile([
                'name' => $fileName
            ]);

            // If folder ID is provided, set parent folder
            if ($folderId) {
                $fileMetadata->setParents([$folderId]);
            }

            $content = file_get_contents($filePath);
            $file = $this->driveService->files->create($fileMetadata, [
                'data' => $content,
                'mimeType' => $mimeType,
                'uploadType' => 'multipart',
                'fields' => 'id, webViewLink, webContentLink'
            ]);

            return [
                'id' => $file->id,
                'webViewLink' => $file->webViewLink ?? null,
                'webContentLink' => $file->webContentLink ?? null
            ];
        } catch (\Exception $e) {
            \Log::error('Google Drive upload error: ' . $e->getMessage());
            throw new \Exception('Failed to upload file to Google Drive: ' . $e->getMessage());
        }
    }

    /**
     * Upload file from uploaded file object
     *
     * @param \Illuminate\Http\UploadedFile $uploadedFile
     * @param string|null $folderId Optional folder ID to upload to
     * @return array Returns array with 'id' and 'webViewLink'
     */
    public function uploadFileFromRequest($uploadedFile, $folderId = null)
    {
        $fileName = $uploadedFile->getClientOriginalName();
        $mimeType = $uploadedFile->getMimeType();
        $filePath = $uploadedFile->getRealPath();

        return $this->uploadFile($filePath, $fileName, $mimeType, $folderId);
    }
}
