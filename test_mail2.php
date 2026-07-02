<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

config(['mail.mailers.smtp.port' => 465]);
config(['mail.mailers.smtp.encryption' => 'ssl']);

$start = microtime(true);
try {
    Mail::raw('Test email', function($msg) {
        $msg->to('kathirkim2006@gmail.com')->subject('Test 465');
    });
    $end = microtime(true);
    echo "Mail sent successfully via 465 in " . ($end - $start) . " seconds.\n";
} catch (\Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}
