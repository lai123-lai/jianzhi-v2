<?php

use Illuminate\Http\Request;

Route::namespace('Auth')->group(function () {
    Route::post('/register','AuthenticateController@register');
    Route::post('/login','AuthenticateController@login');
    Route::get('/refreshtoken','AuthenticateController@refreshToken');
    Route::post('/resetPassword','AuthenticateController@resetPassword');
    Route::post('/sendrandomcode','AuthenticateController@sendRandomCode');
    Route::post('/resetforgottenpassword','AuthenticateController@resetForgottenPassword');
});

Route::namespace('Common')->group(function () {
    Route::resource('/tags','TagsController');
    Route::resource('/skills','SkillController');
    Route::get('/employer/{id}/works','WorkController@getEmployerWorks');
    Route::resource('/works','WorkController');
    Route::resource('/work/{work_id}/applicant','ApplicantController');
    Route::post('/photos/avatar','PhotoController@updateUserAvatar');
    Route::post('/photos/cover','PhotoController@updateUserCover');
    Route::resource('/photos','PhotoController');
    Route::resource('/questions','QuestionController');
    Route::resource('/answers','AnswerController');
});

Route::namespace('User')->group(function () {
    Route::get('/users','UserController@index');
    Route::get('/users/{id}','UserController@show');
    Route::get('/user/reviews','ReviewController@index');
    Route::middleware('jwt.auth')->prefix('user')->group(function (){
        Route::resource('/','UserController',['except' => ['index','show']]);
        Route::get('/appliedstatus','ApplyWorkController@checkApplied');
        Route::resource('/works','ApplyWorkController');
        Route::get('/favoritestatus','FavoriteWorkController@checkFavorite');
        Route::resource('/favoriteworks','FavoriteWorkController');
        Route::get('/followers','FollowingController@getFollowers');
        Route::get('/followingcheck','FollowingController@checkFollowing');
        Route::resource('/followings','FollowingController');
        Route::resource('/report','ReportController');
        Route::resource('/advice','AdviceController');
        Route::get('/wantedcheck','WantAnswerController@checkwanted');
        Route::resource('/wantanswer','WantAnswerController');
        Route::get('/invitedcheck','InviteUserController@checkInvited');
        Route::resource('/inviteuser','InviteUserController');
        Route::post('/review/picture','ReviewController@storeReviewPicture');
        Route::get('/review/status','ReviewController@checkReviewed');
        Route::resource('/reviews','ReviewController',['except' => ['index']]);
    });
});

Route::namespace('Employer')->group(function () {
    Route::get('/employers','EmployerController@index');
    Route::get('/employers/{id}','EmployerController@show');
    Route::get('employer/reviews','ReviewController@index');
    Route::get('employer/review/reply','ReplyController@index');
    Route::middleware('jwt.auth')->prefix('employer')->group(function () {
        Route::resource('/','EmployerController',['except' => ['index','show']]);
        Route::resource('/works','WorkController');
        Route::post('/review/picture','ReviewController@storeReviewPicture');
        Route::get('/review/status','ReviewController@checkReviewed');
        Route::post('/review/useful','ReviewController@useful');
        Route::resource('/reviews','ReviewController',['except' => ['index']]);
        Route::resource('/review/reply','ReplyController',['except' => ['index','show']]);
    });
});

Route::namespace('Company')->prefix('company')->group(function () {
    Route::get('/','CompanyController@index');
    Route::get('/{id}','CompanyController@show');
    Route::middleware('jwt.auth')->group(function () {
        Route::resource('/','CompanyController',['except' => ['index','show']]);
    });
});