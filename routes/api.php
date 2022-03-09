<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\StudentController;
use App\Http\Controllers\Api\ProjectController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post("register", [StudentController::class, "registerStudent"]);
Route::post("login", [StudentController::class, "loginStudent"]);  

Route::group(["middleware" => ["auth:sanctum"]], function(){
    Route::get("profile",[StudentController::class, "profileStudent"]);
    Route::get("logout", [StudentController::class, "logoutStudent"]);

    Route::post("create-project",[ProjectController::class, "createProject"]);
    Route::get("list-project", [ProjectController::class, "listProject"]);
    Route::get("single-project/{id}", [ProjectController::class, "singleProject"]);
    Route::delete("delete-project/{id}", [ProjectController::class, "deleteProject"]);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
