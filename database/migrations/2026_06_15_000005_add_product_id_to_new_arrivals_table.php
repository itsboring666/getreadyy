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
        if (Schema::hasTable('new_arrivals')) {
            if (!Schema::hasColumn('new_arrivals', 'product_id')) {
                Schema::table('new_arrivals', function (Blueprint $table) {
                    $table->unsignedBigInteger('product_id')->nullable()->after('status');
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('new_arrivals')) {
            if (Schema::hasColumn('new_arrivals', 'product_id')) {
                Schema::table('new_arrivals', function (Blueprint $table) {
                    $table->dropColumn('product_id');
                });
            }
        }
    }
};
