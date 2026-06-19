<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('coupons')) {
            Schema::create('coupons', function (Blueprint $table) {
                $table->id();
                $table->string('code')->unique();
                $table->enum('type', ['percent', 'fixed']);
                $table->decimal('value', 10, 2);
                $table->decimal('min_order_value', 10, 2)->default(0.00);
                $table->boolean('is_active')->default(true);
                $table->timestamp('expires_at')->nullable();
                $table->timestamps();
            });

            // Seed some active coupon codes
            DB::table('coupons')->insert([
                [
                    'code' => 'GET20',
                    'type' => 'percent',
                    'value' => 20.00,
                    'min_order_value' => 500.00,
                    'is_active' => true,
                    'expires_at' => now()->addYear(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'code' => 'FLAT150',
                    'type' => 'fixed',
                    'value' => 150.00,
                    'min_order_value' => 1000.00,
                    'is_active' => true,
                    'expires_at' => now()->addYear(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
