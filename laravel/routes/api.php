<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PollController;
use App\Http\Controllers\VoteController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


// Without JWT Middleware (Create Token)
Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
});

// With JWT Middleware (Verify Token)
Route::group([
    'middleware' => 'jwt.verify',
    'prefix' => 'auth'
], function () {

    // Auth
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/me', [AuthController::class, 'me']);
    Route::post('/reset_password', [AuthController::class, 'reset']);
});

// With JWT Middleware (Verify Token)
Route::group([
    'middleware' => 'jwt.verify',
    'prefix' => 'poll'
], function () {

    // Poll
    Route::post('/', [PollController::class, 'store']);
    Route::get('/', [PollController::class, 'showAll']);
    Route::get('/{poll_id}', [PollController::class, 'show']);

    // Vote
    // Route::post('/{poll_id}/vote/{choice_id}', [VoteController::class, 'vote']);
    Route::post('/vote', [VoteController::class, 'vote']);
});
