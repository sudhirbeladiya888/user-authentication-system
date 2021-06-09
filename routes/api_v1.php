<?php
/**
 * @Author: Sudhir Beladiya
 * @Last Modified by:   Sudhir
 */
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\InvitationController;

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

Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/invitation/send', [InvitationController::class, 'send']);

Route::post('/auth/login', [AuthController::class, 'login']);

Route::group(['middleware' => ['auth:api']], function () {
    Route::post('/auth/email/verification/resend', [AuthController::class, 'resendVerification']);
    Route::post('/auth/email/verify', [AuthController::class, 'verifyEmail']);
    Route::post('/auth/profile/update', [AuthController::class, 'updateProfile']);
    Route::get('/auth/logout', [AuthController::class, 'logout']);

    Route::get('/auth/me', function(Request $request) {
        return res_success(['success'=>true,'message'=>'Profile data shows successfully.',
            'data' => auth()->user()
        ]);
    });

});
