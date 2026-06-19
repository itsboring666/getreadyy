<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Master migration: creates all core tables that were originally in outfit_818.sql
// This ensures the app works on fresh PostgreSQL deployments (e.g. Render.com)
return new class extends Migration
{
    public function up(): void
    {
        // USERS
        if (!Schema::hasTable('users')) {
            Schema::create('users', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('email')->unique();
                $table->timestamp('email_verified_at')->nullable();
                $table->string('password');
                $table->rememberToken();
                $table->timestamps();
                $table->string('otp_code', 6)->nullable();
                $table->boolean('is_verified')->default(false);
                $table->string('user_type', 20)->default('user');
                $table->string('phone', 20)->nullable()->unique();
                $table->string('profile_picture')->nullable();
                $table->text('address')->nullable();
                $table->date('dob')->nullable();
                $table->string('gender')->nullable();
            });
        }

        // CATEGORIES
        if (!Schema::hasTable('categories')) {
            Schema::create('categories', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('slug')->unique();
                $table->string('image')->nullable();
                $table->timestamps();
            });
        }

        // PRODUCTS
        if (!Schema::hasTable('products')) {
            Schema::create('products', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->text('description')->nullable();
                $table->decimal('price', 10, 2)->default(0);
                $table->decimal('compare_price', 10, 2)->nullable();
                $table->string('image')->nullable();
                $table->string('category')->nullable();
                $table->integer('stock')->default(0);
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        }

        // PRODUCT SIZES
        if (!Schema::hasTable('product_sizes')) {
            Schema::create('product_sizes', function (Blueprint $table) {
                $table->id();
                $table->foreignId('product_id')->constrained()->onDelete('cascade');
                $table->string('size');
                $table->integer('stock')->default(0);
                $table->timestamps();
            });
        }

        // CAROUSELS
        if (!Schema::hasTable('carousels')) {
            Schema::create('carousels', function (Blueprint $table) {
                $table->id();
                $table->string('title')->nullable();
                $table->string('subtitle')->nullable();
                $table->string('image_path');
                $table->string('link')->nullable();
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        }

        // NEW ARRIVALS
        if (!Schema::hasTable('new_arrivals')) {
            Schema::create('new_arrivals', function (Blueprint $table) {
                $table->id();
                $table->foreignId('product_id')->nullable()->constrained('products')->onDelete('set null');
                $table->string('name');
                $table->decimal('price', 10, 2)->default(0);
                $table->string('image')->nullable();
                $table->string('category')->nullable();
                $table->timestamps();
            });
        }

        // FEATURED PRODUCTS
        if (!Schema::hasTable('featured_products')) {
            Schema::create('featured_products', function (Blueprint $table) {
                $table->id();
                $table->foreignId('product_id')->nullable()->constrained('products')->onDelete('set null');
                $table->timestamps();
            });
        }

        // CART ITEMS
        if (!Schema::hasTable('cart_items')) {
            Schema::create('cart_items', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->foreignId('product_id')->constrained()->onDelete('cascade');
                $table->string('size')->nullable();
                $table->integer('quantity')->default(1);
                $table->timestamps();
            });
        }

        // ORDERS
        if (!Schema::hasTable('orders')) {
            Schema::create('orders', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->string('order_id')->unique();
                $table->string('status', 50)->default('pending');
                $table->string('tracking_number')->nullable();
                $table->string('carrier')->nullable();
                $table->timestamp('shipped_at')->nullable();
                $table->timestamp('delivered_at')->nullable();
                $table->decimal('subtotal', 10, 2)->nullable();
                $table->decimal('shipping', 10, 2)->nullable();
                $table->decimal('discount', 10, 2)->nullable()->default(0);
                $table->decimal('total_amount', 10, 2)->default(0);
                $table->string('payment_gateway')->nullable();
                $table->string('transaction_id')->nullable();
                $table->string('payment_status')->nullable()->default('pending');
                $table->text('shipping_address')->nullable();
                $table->string('razorpay_order_id')->nullable();
                $table->timestamps();
            });
        }

        // ORDER ITEMS
        if (!Schema::hasTable('order_items')) {
            Schema::create('order_items', function (Blueprint $table) {
                $table->id();
                $table->foreignId('order_id')->constrained()->onDelete('cascade');
                $table->string('product_name');
                $table->string('product_image')->nullable();
                $table->string('size')->nullable();
                $table->integer('quantity')->default(1);
                $table->decimal('price', 10, 2)->default(0);
                $table->timestamps();
            });
        }

        // EMAILS
        if (!Schema::hasTable('emails')) {
            Schema::create('emails', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->string('email')->unique();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
        Schema::dropIfExists('cart_items');
        Schema::dropIfExists('featured_products');
        Schema::dropIfExists('new_arrivals');
        Schema::dropIfExists('carousels');
        Schema::dropIfExists('product_sizes');
        Schema::dropIfExists('products');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('emails');
        Schema::dropIfExists('users');
    }
};
