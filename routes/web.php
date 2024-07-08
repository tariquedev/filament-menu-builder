<?php

use Illuminate\Support\Facades\Route;
use Tarique\MenuBuilder\Http\Controllers\MenuItemController;

Route::post('/admin/menu-items/reorder', [MenuItemController::class, 'reorder']);