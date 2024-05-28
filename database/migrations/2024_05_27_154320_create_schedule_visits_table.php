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
        Schema::create('schedule_visits', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->date('date_start')->nullable();
            $table->date('date_end')->nullable();
            $table->integer('looping')->nullable();
            $table->enum('looping_type', ['O', 'D', 'W', 'M', 'Y'])->default('O');
            $table->integer('user_id')->nullable();
            $table->timestamps();
        });

        /*
            O => One Time Only
            D => Daily Repeat
            W => Weekly Repeat
            M => Monthly Repeat
            Y => Yearly Repeat
        */
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedule_visits');
    }
};
