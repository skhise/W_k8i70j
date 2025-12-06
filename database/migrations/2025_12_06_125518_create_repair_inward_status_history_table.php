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
        Schema::create('repair_inward_status_history', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('repair_inward_id');
            $table->unsignedBigInteger('old_status_id')->nullable();
            $table->unsignedBigInteger('new_status_id');
            $table->unsignedBigInteger('changed_by')->nullable();
            $table->text('remarks')->nullable();
            $table->timestamps();
            
            $table->foreign('repair_inward_id')->references('id')->on('repair_inwards')->onDelete('cascade');
            $table->foreign('old_status_id')->references('id')->on('master_repairstatus')->onDelete('set null');
            $table->foreign('new_status_id')->references('id')->on('master_repairstatus')->onDelete('restrict');
            $table->foreign('changed_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('repair_inward_status_history');
    }
};
