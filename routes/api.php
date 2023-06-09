<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;


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
    Route::post('variables_by_ids', 'variables_by_ids');
    Route::get('variables', 'index');
    Route::post('variable', 'store');
    Route::get('variable/{variable_id}', 'show');
    Route::put('variable/{variable_id}', 'update');
    Route::delete('variable/{variable_id}', 'destroy');
});

Route::controller(\App\Http\Controllers\PostController::class)->group(function () {
    Route::get('posts', 'index');
    Route::post('post', 'store');
    Route::post('post/search', 'search');
    Route::get('post/search_history', 'search_history');
    Route::post('post/clear_search_history', 'clear_search_history');
    Route::get('post/{post_id}', 'show');
    Route::put('post/{post_id}', 'update');
    Route::delete('post/{post_id}', 'destroy');

    Route::get('post_history/{post_history_id}', 'show_history');
    Route::post('post_revert', 'revert');

});

Route::controller(\App\Http\Controllers\ImageController::class)->group(function () {
    Route::get('images', 'index');
    Route::post('image', 'store');
    Route::get('image/{image_id}', 'show');
//    Route::put('variable/{variable_id}', 'update');
//    Route::delete('variable/{variable_id}', 'destroy');
});

Route::controller(\App\Http\Controllers\UserController::class)->group(function () {
    Route::post('users_by_ids', 'users_by_ids');
    Route::get('users', 'index');
});
