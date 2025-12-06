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
        Schema::table('repair_inwards', function (Blueprint $table) {
            // Add status_id column (nullable first, then we'll migrate data)
            $table->unsignedBigInteger('status_id')->nullable()->after('ticket_no');
        });
        
        // Migrate existing status data to status_id
        // Only if there are existing records
        if (DB::table('repair_inwards')->count() > 0) {
            DB::statement("UPDATE repair_inwards SET status_id = 1 WHERE status = 'New Inward'");
            DB::statement("UPDATE repair_inwards SET status_id = 2 WHERE status = 'Repaired & Ready for Dispatch'");
            // Set default for any other statuses
            DB::statement("UPDATE repair_inwards SET status_id = 1 WHERE status_id IS NULL");
        }
        
        Schema::table('repair_inwards', function (Blueprint $table) {
            // Add foreign key constraint
            $table->foreign('status_id')->references('id')->on('master_repairstatus')->onDelete('restrict');
            
            // Drop the old status column
            $table->dropColumn('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('repair_inwards', function (Blueprint $table) {
            // Add back status column
            $table->string('status')->default('New Inward')->after('ticket_no');
            
            // Migrate status_id back to status
            DB::statement("UPDATE repair_inwards SET status = (SELECT status_name FROM master_repairstatus WHERE master_repairstatus.id = repair_inwards.status_id)");
            
            // Drop foreign key and status_id column
            $table->dropForeign(['status_id']);
            $table->dropColumn('status_id');
        });
    }
};
