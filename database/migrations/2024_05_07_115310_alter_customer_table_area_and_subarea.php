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
        Schema::table('customers', function (Blueprint $table) {
            if (Schema::hasColumn('customers', 'area')) {
                Schema::table('customers', function (Blueprint $table) {
                    $table->dropColumn('area');
                });
            }
            if (Schema::hasColumn('customers', 'subarea')) {
                Schema::table('customers', function (Blueprint $table) {
                    $table->dropColumn('subarea');
                });
            }

            $table->integer('area_id')->nullable()->after('LO');
            $table->integer('sub_area_id')->nullable()->after('area_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn('area_id');
            $table->dropColumn('sub_area_id');
        });
    }
};
