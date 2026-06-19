<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (!Schema::hasColumn('products', 'image_2')) {
                $table->string('image_2')->nullable();
            }
            if (!Schema::hasColumn('products', 'image_3')) {
                $table->string('image_3')->nullable();
            }
            if (!Schema::hasColumn('products', 'image_4')) {
                $table->string('image_4')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['image_2', 'image_3', 'image_4']);
        });
    }
};
