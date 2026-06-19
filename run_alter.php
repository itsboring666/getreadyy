<?php
require 'vendor/autoload.php';
require 'bootstrap/app.php';
$app = app();
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();
try {
    \Illuminate\Support\Facades\DB::statement('ALTER TABLE orders ADD COLUMN tracking_number VARCHAR(255) NULL AFTER status');
    echo "Added tracking_number\n";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
