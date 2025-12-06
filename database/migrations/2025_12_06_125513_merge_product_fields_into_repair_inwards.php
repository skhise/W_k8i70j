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
        // Add product fields to repair_inwards table
        Schema::table('repair_inwards', function (Blueprint $table) {
            $table->unsignedBigInteger('spare_type_id')->nullable()->after('status_id');
            $table->string('part_model_name')->nullable()->after('spare_type_id');
            $table->string('alternate_sn')->nullable()->after('part_model_name');
            $table->text('spare_description')->nullable()->after('alternate_sn');
            $table->text('product_remark')->nullable()->after('spare_description');
            $table->string('current_product_location')->nullable()->after('product_remark');
        });

        // Migrate data from repair_inward_products to repair_inwards
        if (Schema::hasTable('repair_inward_products')) {
            $products = DB::table('repair_inward_products')->get();
            foreach ($products as $product) {
                DB::table('repair_inwards')
                    ->where('id', $product->repair_inward_id)
                    ->update([
                        'spare_type_id' => $product->spare_type_id,
                        'part_model_name' => $product->part_model_name,
                        'alternate_sn' => $product->alternate_sn,
                        'spare_description' => $product->spare_description,
                        'product_remark' => $product->remark,
                        'current_product_location' => $product->current_product_location,
                    ]);
            }
        }

        // Drop repair_inward_products table
        Schema::dropIfExists('repair_inward_products');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Recreate repair_inward_products table
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

        // Migrate data back
        $repairInwards = DB::table('repair_inwards')
            ->whereNotNull('spare_type_id')
            ->orWhereNotNull('part_model_name')
            ->orWhereNotNull('alternate_sn')
            ->get();
        
        foreach ($repairInwards as $inward) {
            DB::table('repair_inward_products')->insert([
                'repair_inward_id' => $inward->id,
                'spare_type_id' => $inward->spare_type_id,
                'part_model_name' => $inward->part_model_name,
                'alternate_sn' => $inward->alternate_sn,
                'spare_description' => $inward->spare_description,
                'remark' => $inward->product_remark,
                'current_product_location' => $inward->current_product_location,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Remove product fields from repair_inwards
        Schema::table('repair_inwards', function (Blueprint $table) {
            $table->dropColumn([
                'spare_type_id',
                'part_model_name',
                'alternate_sn',
                'spare_description',
                'product_remark',
                'current_product_location',
            ]);
        });
    }
};
