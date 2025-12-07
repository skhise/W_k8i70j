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
        // Add user_id column first if it doesn't exist
        if (!Schema::hasColumn('profile_setup', 'user_id')) {
            Schema::table('profile_setup', function (Blueprint $table) {
                $table->unsignedBigInteger('user_id')->nullable()->after('id');
            });
        }

        // Add index first (needed for foreign key)
        if (Schema::hasColumn('profile_setup', 'user_id')) {
            try {
                Schema::table('profile_setup', function (Blueprint $table) {
                    $table->index('user_id');
                });
            } catch (\Exception $e) {
                // Index might already exist, ignore error
            }
        }

        // Add foreign key constraint separately (after column and index exist)
        // Only add if users table exists and has id column
        if (Schema::hasTable('users') && Schema::hasColumn('users', 'id') && Schema::hasColumn('profile_setup', 'user_id')) {
            try {
                // Check if foreign key already exists
                $constraints = DB::select("
                    SELECT CONSTRAINT_NAME 
                    FROM information_schema.KEY_COLUMN_USAGE 
                    WHERE TABLE_SCHEMA = DATABASE() 
                    AND TABLE_NAME = 'profile_setup' 
                    AND COLUMN_NAME = 'user_id' 
                    AND REFERENCED_TABLE_NAME = 'users'
                ");
                
                if (empty($constraints)) {
                    Schema::table('profile_setup', function (Blueprint $table) {
                        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
                    });
                }
            } catch (\Exception $e) {
                // If foreign key creation fails, log but don't stop migration
                // The column will still be added, just without foreign key constraint
                \Log::warning('Could not create foreign key for profile_setup.user_id: ' . $e->getMessage());
            }
        }

        // Add Google Drive credentials fields
        Schema::table('profile_setup', function (Blueprint $table) {
            if (!Schema::hasColumn('profile_setup', 'google_client_id')) {
                $table->string('google_client_id')->nullable()->after('u_token');
            }
            if (!Schema::hasColumn('profile_setup', 'google_client_secret')) {
                $table->text('google_client_secret')->nullable()->after('google_client_id');
            }
            if (!Schema::hasColumn('profile_setup', 'google_refresh_token')) {
                $table->text('google_refresh_token')->nullable()->after('google_client_secret');
            }
            if (!Schema::hasColumn('profile_setup', 'google_drive_folder_id')) {
                $table->string('google_drive_folder_id')->nullable()->after('google_refresh_token');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('profile_setup', function (Blueprint $table) {
            $table->dropColumn([
                'google_client_id',
                'google_client_secret',
                'google_refresh_token',
                'google_drive_folder_id'
            ]);
            
            // Note: We don't drop user_id in case it was added manually or exists for other purposes
        });
    }
};

