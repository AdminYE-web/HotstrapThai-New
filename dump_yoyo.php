<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$products = \App\Models\Product::whereHas('category', function($q) { $q->where('slug', 'yoyo-badge-holders'); })->get();
echo json_encode($products);
