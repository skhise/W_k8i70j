<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function download()
    {
        // Retrieve the file path from the storage disk
        $filePath = Storage::disk('local')->path('custom_data.xlsx');

        // Check if the file exists
        if (Storage::disk('local')->exists('custom_data.xlsx')) {
            // Return the file as a download response
            return response()->download($filePath, 'custom_data.xlsx');
        } else {
            // File not found, return a 404 response
            abort(404);
        }
    }
}
