<?php

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('main');
});

// auth
Route::get('login', [AuthController::class, 'index'])->name('login');
Route::post('post-login', [AuthController::class, 'postLogin'])->name('login.post'); 
Route::get('registration', [AuthController::class, 'registration'])->name('register');
Route::post('post-registration', [AuthController::class, 'postRegistration'])->name('register.post'); 
Route::get('dashboard', [AuthController::class, 'dashboard'])->name('dashboard'); 
Route::get('logout', [AuthController::class, 'logout'])->name('logout');

// vimerson health
Route::prefix('vimerson')->group(function () {
    Route::post('create/user', 'VimersonHealthController@storeUser');
});

// vimerson admin
Route::prefix('admin')->group(function () {
    // free bottle
    Route::get('bottle', 'AdminVimersonHealthController@index')->name('bottle_list');
    Route::get('bottle/create', 'AdminVimersonHealthController@create');
    Route::post('bottle/store', 'AdminVimersonHealthController@store');
    Route::get('bottle/edit/{bottle_id}', 'AdminVimersonHealthController@edit')->name('edit_bottle');
    Route::patch('bottle/update/{bottle_id}', 'AdminVimersonHealthController@update');
    Route::delete('bottle/delete/{bottle_id}', 'AdminVimersonHealthController@deleteBottle')->name('delete_bottle');

    // free bottle
    Route::get('asin', 'AdminVimersonHealthController@listAsin');
    Route::get('asin/create', 'AdminVimersonHealthController@createAsinForm');
    Route::post('asin/store', 'AdminVimersonHealthController@storeAsin');
    Route::get('asin/edit/{bottle_id}', 'AdminVimersonHealthController@editAsinForm')->name('edit_asin');
    Route::patch('asin/update/{bottle_id}', 'AdminVimersonHealthController@updateAsin');

    // product bottle
    Route::get('product', 'ProductController@listProduct')->name('product_list');;
    Route::get('product/create', 'ProductController@createProductForm');
    Route::post('product/store', 'ProductController@storeProduct');
    Route::get('product/edit/{bottle_id}', 'ProductController@editProductForm')->name('edit_product');
    Route::patch('product/update/{bottle_id}', 'ProductController@updateProduct');
    Route::delete('product/delete/{bottle_id}', 'ProductController@deleteProduct')->name('delete_product');

    // questionnaire
    Route::get('questionnaire', 'AdminVimersonHealthController@questionList')->name('questionnaire_list');
    Route::get('questionnaire/create', 'AdminVimersonHealthController@questionCreateForm');
    Route::post('questionnaire/store', 'AdminVimersonHealthController@questionStore');
    Route::get('questionnaire/{question_id}/edit', 'AdminVimersonHealthController@questionEditForm')->name('edit_question');
    Route::patch('questionnaire/update/{bottle_id}', 'AdminVimersonHealthController@questionUpdate');

    // time tracker
    Route::get('timetracker', 'AdminVimersonHealthController@timeTrackerList')->name('timetracker_list');

    // users
    Route::get('users', 'AdminVimersonHealthController@userList')->name('user_list');

    // export user
    Route::get('export/users', 'AdminVimersonHealthController@exportUsers')->name('export');
});

// retrieve free bottle image
Route::get('/bottle/{filename}', function ($filename)
{
    $base_path = storage_path() . '/app/media/bottle/images/';
    $path = $base_path . $filename;

    if(!File::exists($path)) $path = $base_path . 'placeholder.png';

    $file = File::get($path);
    $type = File::mimeType($path);

    $response = Response::make($file, 200);
    $response->header('Content-Type', $type);
    return $response;
})->name('bottle');

// retrieve product image
Route::get('/product/{filename}', function ($filename)
{
    $base_path = storage_path() . '/app/media/';
    $path = $base_path . $filename;

    if(!File::exists($path)) $path = $base_path . 'placeholder.png';
    
    $file = File::get($path);
    $type = File::mimeType($path);

    $response = Response::make($file, 200);
    $response->header('Content-Type', $type);
    return $response;
})->name('product_image');

// retrieve email image
Route::get('/email/images/{filename}', function ($filename)
{
    $base_path = storage_path() . '/app/media/email/';
    $path = $base_path . $filename;
    
    if(!File::exists($path)) $path = $base_path . 'placeholder.png';
    
    $file = File::get($path);
    $type = File::mimeType($path);
    
    $response = Response::make($file, 200);
    $response->header('Content-Type', $type);
    return $response;
})->name('email_image');