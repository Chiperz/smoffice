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
        Schema::create('detail_switch_display_customers', function (Blueprint $table) {
            $table->id();
            $table->integer('switch_display_customer_id')->nullable();
            $table->text('display_before')->nullable();
            $table->text('display_after')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_switch_display_customers');
    }
};
