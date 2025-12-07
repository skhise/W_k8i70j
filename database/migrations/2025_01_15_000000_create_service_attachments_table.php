<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Create table without foreign keys first
        Schema::create('service_attachments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('service_id');
            $table->string('file_name');
            $table->string('original_file_name');
            $table->string('file_type')->nullable();
            $table->bigInteger('file_size')->nullable();
            $table->string('google_drive_file_id');
            $table->string('google_drive_url')->nullable();
            $table->text('description')->nullable();
            $table->unsignedBigInteger('uploaded_by')->nullable();
            $table->timestamps();

            // Index for faster queries (needed before foreign key)
            $table->index('service_id');
            $table->index('uploaded_by');
        });

        // Add foreign key constraints separately after table is created
        // Only add if the referenced tables exist and have the correct structure
        if (Schema::hasTable('services') && Schema::hasColumn('services', 'id')) {
            try {
                // Get the actual column type from services.id
                $columnInfo = DB::select("
                    SELECT COLUMN_TYPE, COLUMN_NAME 
                    FROM information_schema.COLUMNS 
                    WHERE TABLE_SCHEMA = DATABASE() 
                    AND TABLE_NAME = 'services' 
                    AND COLUMN_NAME = 'id'
                ");
                
                if (!empty($columnInfo)) {
                    // Check if foreign key already exists
                    $constraints = DB::select("
                        SELECT CONSTRAINT_NAME 
                        FROM information_schema.KEY_COLUMN_USAGE 
                        WHERE TABLE_SCHEMA = DATABASE() 
                        AND TABLE_NAME = 'service_attachments' 
                        AND COLUMN_NAME = 'service_id' 
                        AND REFERENCED_TABLE_NAME = 'services'
                    ");
                    
                    if (empty($constraints)) {
                        Schema::table('service_attachments', function (Blueprint $table) {
                            $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');
                        });
                    }
                }
            } catch (\Exception $e) {
                // If foreign key creation fails, log but don't stop migration
                // The table will still be created, just without foreign key constraint
                \Log::warning('Could not create foreign key for service_attachments.service_id: ' . $e->getMessage());
            }
        }

        if (Schema::hasTable('users') && Schema::hasColumn('users', 'id')) {
            try {
                // Get the actual column type from users.id
                $columnInfo = DB::select("
                    SELECT COLUMN_TYPE, COLUMN_NAME 
                    FROM information_schema.COLUMNS 
                    WHERE TABLE_SCHEMA = DATABASE() 
                    AND TABLE_NAME = 'users' 
                    AND COLUMN_NAME = 'id'
                ");
                
                if (!empty($columnInfo)) {
                    // Check if foreign key already exists
                    $constraints = DB::select("
                        SELECT CONSTRAINT_NAME 
                        FROM information_schema.KEY_COLUMN_USAGE 
                        WHERE TABLE_SCHEMA = DATABASE() 
                        AND TABLE_NAME = 'service_attachments' 
                        AND COLUMN_NAME = 'uploaded_by' 
                        AND REFERENCED_TABLE_NAME = 'users'
                    ");
                    
                    if (empty($constraints)) {
                        Schema::table('service_attachments', function (Blueprint $table) {
                            $table->foreign('uploaded_by')->references('id')->on('users')->onDelete('set null');
                        });
                    }
                }
            } catch (\Exception $e) {
                // If foreign key creation fails, log but don't stop migration
                // The table will still be created, just without foreign key constraint
                \Log::warning('Could not create foreign key for service_attachments.uploaded_by: ' . $e->getMessage());
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_attachments');
    }
};

