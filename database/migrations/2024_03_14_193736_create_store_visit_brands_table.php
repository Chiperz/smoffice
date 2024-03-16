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
        Schema::create('store_visit_brands', function (Blueprint $table) {
            $table->id();
            $table->integer('visit_header_id')->nullable();
            $table->integer('visit_detail_store_id')->nullable();
            $table->integer('brand_product_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('store_visit_brands');
    }
};
