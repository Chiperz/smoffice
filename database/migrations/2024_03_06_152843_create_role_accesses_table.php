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
        Schema::create('role_accesses', function (Blueprint $table) {
            $table->id();
            $table->integer('role_id')->nullable();
            $table->integer('main_menu_id')->nullable();
            $table->integer('menu_id')->nullable();
            $table->integer('sub_menu_id')->nullable();
            $table->boolean('view')->default(1);
            $table->boolean('detail')->default(1);
            $table->boolean('add')->default(1);
            $table->boolean('edit')->default(1);
            $table->boolean('delete')->default(1);
            $table->boolean('export')->default(1);
            $table->boolean('import')->default(1);
            $table->boolean('status')->default(1);
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
        Schema::dropIfExists('role_accesses');
    }
};
