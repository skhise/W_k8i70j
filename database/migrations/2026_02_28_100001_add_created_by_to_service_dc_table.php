<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('service_dc', function (Blueprint $table) {
            if (!Schema::hasColumn('service_dc', 'created_by')) {
                $table->unsignedBigInteger('created_by')->nullable()->after('issue_date');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('service_dc', function (Blueprint $table) {
            if (Schema::hasColumn('service_dc', 'created_by')) {
                $table->dropColumn('created_by');
            }
        });
    }
};
