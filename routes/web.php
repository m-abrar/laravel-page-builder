
<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


use App\Http\Controllers\PageBuilderController;

Route::get('/admin/page-builder', [PageBuilderController::class, 'index'])->name('admin.page.builder');
Route::post('/admin/page-builder/save', [PageBuilderController::class, 'save'])->name('admin.page.save');
Route::get('/admin/page-builder/load/{id}', [PageBuilderController::class, 'load'])->name('admin.page.load');
