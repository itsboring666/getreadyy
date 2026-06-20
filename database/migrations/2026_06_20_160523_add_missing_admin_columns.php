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
        Schema::table('new_arrivals', function (Blueprint $table) {
            if (!Schema::hasColumn('new_arrivals', 'description')) {
                $table->text('description')->nullable();
            }
        });

        Schema::table('carousels', function (Blueprint $table) {
            if (!Schema::hasColumn('carousels', 'description')) {
                $table->text('description')->nullable();
            }
            if (!Schema::hasColumn('carousels', 'button_text')) {
                $table->string('button_text')->nullable();
            }
            if (!Schema::hasColumn('carousels', 'button_link')) {
                $table->string('button_link')->nullable();
            }
        });

        Schema::table('featured_products', function (Blueprint $table) {
            if (!Schema::hasColumn('featured_products', 'title')) {
                $table->string('title')->nullable();
                $table->string('tagline')->nullable();
                $table->text('description')->nullable();
                $table->decimal('original_price', 10, 2)->default(0);
                $table->decimal('discounted_price', 10, 2)->default(0);
                $table->string('image_path')->nullable();
                $table->string('button_text')->nullable();
                $table->string('button_link')->nullable();
                $table->boolean('is_active')->default(true);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('new_arrivals', function (Blueprint $table) {
            $table->dropColumn('description');
        });

        Schema::table('carousels', function (Blueprint $table) {
            $table->dropColumn(['description', 'button_text', 'button_link']);
        });

        Schema::table('featured_products', function (Blueprint $table) {
            $table->dropColumn(['title', 'tagline', 'description', 'original_price', 'discounted_price', 'image_path', 'button_text', 'button_link', 'is_active']);
        });
    }
};
