<?php
$order = App\Models\Order::where('order_id', 'ORDER_6a350abfe93ca')->first(); 
if($order) { 
    $order->status='paid'; 
    $order->save(); 
    echo 'Marked as paid: ' . $order->order_id . "\n"; 
}
