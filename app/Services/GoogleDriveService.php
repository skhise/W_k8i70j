<?php

namespace App\Services;

use Google\Client;
use Google\Service\Drive;

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

        // Log credential info (without exposing secrets)
        \Log::info('Initializing Google Drive Service', [
            'client_id_prefix' => substr($this->clientId, 0, 20) . '...',
            'client_secret_length' => strlen($this->clientSecret),
            'refresh_token_length' => strlen($this->refreshToken),
            'refresh_token_prefix' => substr($this->refreshToken, 0, 20) . '...',
        ]);

        // Validate refresh token format (should start with '1//' or be a long string)
        if (strlen($this->refreshToken) < 50) {
            \Log::warning('Google Drive refresh token seems too short', [
                'length' => strlen($this->refreshToken),
            ]);
        }

        $client = new Client();
        $client->setClientId($this->clientId);
        $client->setClientSecret($this->clientSecret);
        $client->refreshToken($this->refreshToken);
        
        // Actually fetch a new access token using the refresh token
        try {
            $this->driveService = new Drive($client);
            
        }  catch (\Exception $e) {
            \Log::error('Google Drive authentication error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            throw new \Exception('Failed to authenticate with Google Drive: ' . $e->getMessage());
        }
    }

    public function uploadImage($filePath, $fileName)
    {
        $fileMetadata = new Drive\DriveFile([
            'name' => $fileName
        ]);
        $driveFile = $service->files->create(
            $fileMetadata,
            [
                'data' => file_get_contents($file),
                'mimeType' => $file->getMimeType(),
                'uploadType' => 'multipart'
            ]
        );
        $driveFile->id;
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

            $fileMetadata = new Drive\DriveFile([
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
