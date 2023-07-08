<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DetailController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\GenreController;
use App\Models\Comment;

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

Route::get('/hello', function () {
    return 'Hello Next.js';
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post("/detailSave", [DetailController::class, "store"]);

Route::get("/detail", [DetailController::class, "index"]);

Route::get("getDetail", [DetailCOntroller::class, "show"]);

Route::get("/multipleDetail", [DetailController::class, "multipleIndex"]);

Route::post("/makeComment", [CommentController::class, "store"]);

Route::post('/incrementGoods', function(Request $request) {
    $Comment = Comment::find($request->id);
    $Comment->goods += 1;
    $Comment->save();
});

Route::get("/detailGenre", [GenreController::class, "detailGenre"]);

Route::get("/multipleGenreDetail", [GenreController::class, "MultipleDetailGenre"]);