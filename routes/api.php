<?php

//use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TodoController;


Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');

});

Route::controller(\App\Http\Controllers\CategoryController::class)->group(function () {
    Route::get('categories', 'index');
    Route::post('category', 'store');
    Route::get('category/{category_id}', 'show');
    Route::put('category/{category_id}', 'update');
    Route::delete('category/{category_id}', 'destroy');
});

Route::controller(\App\Http\Controllers\SubCategoryController::class)->group(function () {
    Route::get('sub_categories', 'index');
    Route::post('sub_category', 'store');
    Route::get('sub_category/{sub_category_id}', 'show');
    Route::put('sub_category/{sub_category_id}', 'update');
    Route::delete('sub_category/{sub_category_id}', 'destroy');
});

Route::controller(\App\Http\Controllers\VariableController::class)->group(function () {
    Route::get('hochu-peremennyie', 'hochu_peremennyie');
//    Route::get('sub_categories', 'index');
//    Route::post('sub_category', 'store');
//    Route::get('sub_category/{sub_category_id}', 'show');
//    Route::put('sub_category/{sub_category_id}', 'update');
//    Route::delete('sub_category/{sub_category_id}', 'destroy');
});
