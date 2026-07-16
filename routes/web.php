

<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json([
        'success' => true,
        'message' => 'AgroCare Laravel API is running successfully!',
        'version' => '1.0'
    ]);
});