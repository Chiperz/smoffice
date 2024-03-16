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
        Schema::create('store_visit_unproductive_reasons', function (Blueprint $table) {
            $table->id();
            $table->integer('header_visit_id')->nullable();
            $table->integer('detail_visit_store_id')->nullable();
            $table->integer('unproductive_reason_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('store_visit_unproductive_reasons');
    }
};
