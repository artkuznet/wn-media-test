<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/** @var \Dingo\Api\Routing\Router $api */
$api = app(\Dingo\Api\Routing\Router::class);
$api->version('v1', function (\Dingo\Api\Routing\Router $api) {
    $api->get('books', [\App\Api\V1\Controllers\BookController::class, 'getBooks']);
    $api->get('books/{id}', [\App\Api\V1\Controllers\BookController::class, 'getBook']);
    $api->post('books', [\App\Api\V1\Controllers\BookController::class, 'addBook']);
    $api->post('books/{id}', [\App\Api\V1\Controllers\BookController::class, 'editBook']);
    $api->get('authors/{id}', [\App\Api\V1\Controllers\AuthorController::class, 'getAuthor']);
    $api->post('authors', [\App\Api\V1\Controllers\AuthorController::class, 'addAuthor']);
});