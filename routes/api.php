<?php

use App\Http\Controllers\Subscribe\AuthController;
use App\Http\Controllers\Subscribe\Award\AwardController;
use App\Http\Controllers\Subscribe\Games\GameController;
use App\Http\Controllers\Subscribe\Levels\LevelController;
use App\Http\Controllers\Subscribe\Levels\LevelGamesController;
use App\Http\Controllers\Subscribe\Levels\QuestionsController;
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




Route::post('subscribe', [AuthController::class,'Subscribe']);
Route::post('verify-activate', [AuthController::class,'VerifyPinAndActivate']);
Route::post('resend-pin', [AuthController::class,'reSendPinDB']);
Route::post('resend-sdp-pin', [AuthController::class,'reSendPinSDP']);
Route::post('verify-pin', [AuthController::class,'VerifyPinLogin']);
Route::post('Profile', [AuthController::class,'Profile']);


Route::middleware(['auth:api', 'LanguageManager'])->group(function(){


    //Game Api's
    Route::get('Games', [GameController::class,'index']);
    Route::get('Game-Info/{gameId}', [GameController::class,'gameInfo']);


    //Level Api's
    Route::post('Levels', [LevelController::class,'index']);
    Route::post('Level-Info', [LevelController::class, 'levelInfo'])->middleware('CheckAvailableLevel');
    Route::post('unlock-Level', [LevelController::class, 'unlockLevel']);


    //Question Api's
    Route::post('Questions', [QuestionsController::class,'index']);


      //Question Api's
      Route::post('Award', [AwardController::class,'winAward']);


    Route::get('logout', [AuthController::class,'logout']);


});

