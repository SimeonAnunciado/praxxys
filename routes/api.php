<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\VideoController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


    Route::post('/register', [AuthController::class,'register']);
    Route::post('/login', [AuthController::class,'login']);
    Route::get('/products/categories',[ProductController::class,'getCategory']);

// protected routes
Route::group(['middleware' => ['auth:sanctum']], function(){

    Route::post('/logout', [AuthController::class,'logout']);

    /* products */
    Route::get('/products/{id}',[ProductController::class,'show']);
    Route::post('/products/create',[ProductController::class,'store']);
    Route::get('/products',[ProductController::class,'index']);
    Route::get('/products/{id}/edit',[ProductController::class,'edit']);
    Route::post('/products/delete',[ProductController::class,'destroy']);
    Route::post('/products/{id}/update',[ProductController::class,'update']);
    Route::post('/videos',[VideoController::class,'index']);

    // filter and search
    Route::get('/products/search/{keyword}',[ProductController::class,'search']);
    Route::get('/products/filter/{category?}/{search?}',[ProductController::class,'filterCategory']);
});
