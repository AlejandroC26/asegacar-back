<?php

use App\Http\Controllers\AgeController;
use App\Http\Controllers\AntemortemDailyRecordController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ColorsController;
use App\Http\Controllers\ContractsController;
use App\Http\Controllers\DailyPayrollController;
use App\Http\Controllers\FormatCodeController;
use App\Http\Controllers\GendersController;
use App\Http\Controllers\GuideController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\OutletController;
use App\Http\Controllers\PurposeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PersonController;

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

Route::controller(AuthController::class)->prefix('auth')->group(function () {
    Route::get('me', 'me');
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');
});

Route::resource('persons', PersonController::class);
Route::resource('users', UserController::class);
Route::resource('purposes', PurposeController::class);
Route::resource('outlets', OutletController::class);
Route::resource('ages', AgeController::class);
Route::resource('incomes', IncomeController::class);
Route::resource('formatCodes', FormatCodeController::class);
Route::resource('contracts', ContractsController::class);
Route::resource('dailyPayroll', DailyPayrollController::class);
Route::resource('colors', ColorsController::class);
Route::resource('genders', GendersController::class);
Route::resource('guides', GuideController::class);
Route::resource('antemortemDailyRecord', AntemortemDailyRecordController::class);
Route::get('dailyMatrix', 'App\Http\Controllers\DailyMatrixController@index');

Route::post('ageBobinsFormat', 'App\Http\Controllers\AgeController@download');
Route::post('dailyPayrollFormat', 'App\Http\Controllers\DailyPayrollController@download');
Route::get('antemortemDailyRecordPending', 'App\Http\Controllers\AntemortemDailyRecordController@pending');
Route::post('antemortemDailyRecordFormat', 'App\Http\Controllers\AntemortemDailyRecordController@download');


Route::get('contractSignature/{nIdContract}', 'App\Http\Controllers\ContractsController@onGetSignature');
Route::post('contractPDF/{nIdContract}', 'App\Http\Controllers\ContractsController@generatePDF');
Route::post('dailyMatrixFormat', 'App\Http\Controllers\DailyMatrixController@download');
Route::get('sltPersons', 'App\Http\Controllers\PersonController@sltPersons');
Route::get('sltAges', 'App\Http\Controllers\AgeController@sltAges');
Route::get('sltOutlets', 'App\Http\Controllers\OutletController@sltOutlets');
Route::get('sltPurposes', 'App\Http\Controllers\PurposeController@sltPurposes');
Route::get('sltCities', 'App\Http\Controllers\CityController@sltCities');
Route::get('sltDepartments', 'App\Http\Controllers\CityController@sltDepartments');
Route::get('sltGuides', 'App\Http\Controllers\GuideController@sltGuides');
Route::get('sltFormatCodes', 'App\Http\Controllers\FormatCodeController@sltFormatCodes');
