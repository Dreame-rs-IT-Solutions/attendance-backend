<?php

use App\Http\Resources\TeacherResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;

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

Route::group(['middleware' => 'forceJsonResponse'], function () {

    Route::group(['prefix' => 'v1'], function() {

        Route::post('/login', 'AuthController@login');

        // Route::get('/verification', 'VerificationController@verifyContactNumber');
        // Route::put('/forgot-password', 'VerificationController@sendCodeToContactNumber');
        // Route::put('/forgot-password/verify-code', 'VerificationController@verifyForgotPasswordCode');
        // Route::put('/forgot-password/change-password', 'VerificationController@forgotPasswordChangePassword');

        Route::group(['middleware' => 'auth:api'], function() {

            Route::post('/logout', 'AuthController@logout');

            // Route::get('/user', function() { return request()->user(); });
            // Route::put('/user/change-password', 'UserController@changePassword');

            /**
             * Administrator Routes
             */
            Route::group(['as' => 'admin.', 'prefix' => '/a'], function() {
                Route::apiResource('teachers', 'TeacherController');
            });

            /**
             * Teacher Routes
             */
            Route::group(['as' => 'teacher.', 'prefix' => '/t'], function() {
                Route::get('/', function(Request $request) {
                    $teacher = \App\Teacher::whereUserId(request()->user()->id)->first();
                    return new TeacherResource($teacher);
                });

                Route::put('/', function(Request $request) {
                    $validator = Validator::make($request->toArray(), [
                        'username' => 'required|string',
                        'name' => 'required|string',
                    ]);

                    $teacher = \App\Teacher::whereUserId(request()->user()->id)->first();
                    $teacher->update($validator->validated());

                    $teacherUser = \App\User::whereId($teacher->user_id)->first();
                    $teacherUser->update($validator->validated());

                    return new TeacherResource($teacher);
                });

                Route::apiResource('sections', 'SectionController');

                Route::apiResource('sections.students', 'SectionStudentController');

                Route::apiResource('sections.attendances', 'SectionAttendanceController')
                    ->only(['index', 'store']);

                Route::apiResource('students.attendances', 'StudentAttendanceController');
            });
        });
    });
});
