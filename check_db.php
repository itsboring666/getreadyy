<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
$product = App\Models\Product::orderBy('id', 'desc')->first();
echo "Latest product image path: " . $product->image . "\n";
echo "Storage URL: " . get_storage_url($product->image) . "\n";
