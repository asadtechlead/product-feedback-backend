<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FeedbackController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::group(['prefix' => config('app.apiVersion')], function () {
    Route::controller(AuthController::class)->group(function () {
        Route::post('/signup', 'register');
        Route::post('/login', 'login');
    });
    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::get('/user', function (Request $request) {
            $commentSettings = \App\Models\Setting::where('name', 'commentState')->first();
            $commentStatus = $commentSettings ? $commentSettings->value : "Enabled";
            return response(['status'=> true, 'message' => "Success", 'user' => $request->user(), 'commentState'=>$commentStatus], 200);
        });

        Route::get('/users', function (Request $request) {
            return response(['status'=> true, 'message' => "Success", 'users' => User::paginate(5)], 200);
        })->can('viewAny', User::class);

        Route::delete('/user/{user}', function (User $user) {
            $user->delete();
            return response(['status'=> true, 'message' => "Success"], 200);
        })->can('delete', User::class);


        Route::apiResource('feedback', FeedbackController::class);
        Route::put('feedback/{feedback}/vote', [FeedbackController::class, 'vote']);
        Route::apiResource('comment', CommentController::class);
        Route::post('comment-setting', [AuthController::class, 'commentSetting'])->can('disableComments', User::class);
        Route::post('logout', [AuthController::class, 'logout']);
    });
});

