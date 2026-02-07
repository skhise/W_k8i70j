<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('service_dc_product', function (Blueprint $table) {
            if (!Schema::hasColumn('service_dc_product', 'quantity')) {
                $table->unsignedInteger('quantity')->default(1)->after('serial_no');
            }
        });
    }

    public function down(): void
    {
        Schema::table('service_dc_product', function (Blueprint $table) {
            if (Schema::hasColumn('service_dc_product', 'quantity')) {
                $table->dropColumn('quantity');
            }
        });
    }
};
