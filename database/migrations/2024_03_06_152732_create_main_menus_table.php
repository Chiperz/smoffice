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
        Schema::create('main_menus', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->text('icon')->nullable();
            $table->text('url')->nullable();
            $table->boolean('parent')->default(1);
            $table->boolean('show')->default(1);
            $table->integer('serial')->nullable();
            $table->integer('status')->default(1);
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('deleted_by')->nullable();
            $table->timestamps();
            $table->SoftDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('main_menus');
    }
};
