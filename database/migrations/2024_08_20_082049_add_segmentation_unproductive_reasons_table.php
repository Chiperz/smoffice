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
        Schema::table('unproductive_reasons', function (Blueprint $table) {
            $table->integer('segmentation_id')->nullable()->after('type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('unproductive_reasons', function (Blueprint $table) {
            if (Schema::hasColumn('unproductive_reasons', 'segmentation_id')) {
                Schema::table('unproductive_reasons', function (Blueprint $table) {
                    $table->dropColumn('segmentation_id');
                });
            }
        });
    }
};
