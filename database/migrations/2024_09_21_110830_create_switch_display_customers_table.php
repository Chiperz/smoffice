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
        Schema::create('switch_display_customers', function (Blueprint $table) {
            $table->id();
            $table->integer('header_visit_id')->nullable();
            $table->boolean('status_display_before')->nullable();
            $table->boolean('status_display_after')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('switch_display_customers');
    }
};
