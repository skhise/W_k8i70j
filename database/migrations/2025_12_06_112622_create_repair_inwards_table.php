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
        Schema::create('repair_inwards', function (Blueprint $table) {
            $table->id();
            $table->string('defective_no')->unique();
            $table->date('defective_date');
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->string('ticket_no')->nullable();
            $table->string('status')->default('New Inward'); // New Inward, Repaired & Ready for Dispatch, etc.
            $table->text('products')->nullable(); // JSON or comma-separated
            $table->text('remark')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->foreign('customer_id')->references('CST_ID')->on('clients')->onDelete('cascade');
        });
        
        Schema::create('repair_inward_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('repair_inward_id');
            $table->unsignedBigInteger('spare_type_id')->nullable();
            $table->string('part_model_name')->nullable();
            $table->string('alternate_sn')->nullable();
            $table->text('spare_description')->nullable();
            $table->text('remark')->nullable();
            $table->string('current_product_location')->nullable();
            $table->timestamps();
            
            $table->foreign('repair_inward_id')->references('id')->on('repair_inwards')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('repair_inward_products');
        Schema::dropIfExists('repair_inwards');
    }
};
