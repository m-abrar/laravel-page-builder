<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageBuilderController;

Route::get('/', function () {
    return view('welcome');
});




use App\Http\Controllers\PageController;

Route::get('/page/{id}', [PageController::class, 'show'])->name('page.show');





// Page Builder Routes
Route::get('/admin/page-builder/{id}/edit', [PageBuilderController::class, 'edit'])
    ->name('admin.page-builder.edit');

Route::post('/admin/page-builder/save/{id}', [PageBuilderController::class, 'save'])
    ->name('admin.page-builder.save');
