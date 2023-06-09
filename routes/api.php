<?php

use App\Http\Controllers\AgeController;
use App\Http\Controllers\AntemortemDailyRecordController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChannelConditioningController;
use App\Http\Controllers\ColorsController;
use App\Http\Controllers\DailyPayrollController;
use App\Http\Controllers\DailyRoutesController;
use App\Http\Controllers\FormatCodeController;
use App\Http\Controllers\FormBenefitOrderController;
use App\Http\Controllers\GendersController;
use App\Http\Controllers\GuideController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\MasterTableController;
use App\Http\Controllers\OutletController;
use App\Http\Controllers\PurposeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\PostmortemInspectionsController;
use App\Http\Controllers\RouteController;
use App\Http\Controllers\SeizureComparisonController;
use App\Http\Controllers\VisceraDispatchController;
use App\Http\Controllers\ZeroGutsToleranceController;
use App\Http\Controllers\ZeroToleranceInspectionController;

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
Route::resource('dailyPayroll', DailyPayrollController::class);
Route::resource('colors', ColorsController::class);
Route::resource('genders', GendersController::class);
Route::resource('guides', GuideController::class);
Route::resource('antemortemDailyRecord', AntemortemDailyRecordController::class);
Route::resource('routes', RouteController::class);
Route::resource('dailyRoutes', DailyRoutesController::class);
Route::resource('masterTable', MasterTableController::class);
Route::resource('formBenefitOrder', FormBenefitOrderController::class);
Route::resource('postmortemInspections', PostmortemInspectionsController::class);
Route::resource('zeroGutsTolerance', ZeroGutsToleranceController::class);
Route::resource('visceraDispatch', VisceraDispatchController::class);
Route::resource('seizureComparison', SeizureComparisonController::class);
Route::resource('zeroToleranceInspection', ZeroToleranceInspectionController::class);
Route::resource('channelConditioning', ChannelConditioningController::class);

Route::get('dailyMatrix', 'App\Http\Controllers\DailyMatrixController@index');

Route::post('ageBobinsFormat', 'App\Http\Controllers\AgeController@download');
Route::post('dailyPayrollFormat', 'App\Http\Controllers\DailyPayrollController@download');
Route::post('dailyMatrixFormat', 'App\Http\Controllers\DailyMatrixController@download');
Route::post('dailyRoutesFormat', 'App\Http\Controllers\DailyRoutesController@download');
Route::post('formBenefitOrderFormat', 'App\Http\Controllers\FormBenefitOrderController@download');
Route::post('postmortemInspectionsFormat', 'App\Http\Controllers\PostmortemInspectionsController@download');
Route::post('antemortemDailyRecordFormat', 'App\Http\Controllers\AntemortemDailyRecordController@download');
Route::post('zeroGutsToleranceFormat', 'App\Http\Controllers\ZeroGutsToleranceController@download');
Route::post('visceraDispatchFormat', 'App\Http\Controllers\VisceraDispatchController@download');
Route::post('seizureComparisonFormat', 'App\Http\Controllers\SeizureComparisonController@download');
Route::post('zeroToleranceInspectionFormat', 'App\Http\Controllers\ZeroToleranceInspectionController@download');
Route::post('channelConditioningFormat', 'App\Http\Controllers\ChannelConditioningController@download');

Route::get('antemortemDailyRecordPending', 'App\Http\Controllers\AntemortemDailyRecordController@pending');
Route::post('contractPDF/{nIdGuide}', 'App\Http\Controllers\GuideController@generatePDF');
Route::get('sltCharges', 'App\Http\Controllers\UserController@sltCharges');
Route::get('sltPersons', 'App\Http\Controllers\PersonController@sltPersons');
Route::get('sltAges', 'App\Http\Controllers\AgeController@sltAges');
Route::get('sltOutlets', 'App\Http\Controllers\OutletController@sltOutlets');
Route::get('sltPurposes', 'App\Http\Controllers\PurposeController@sltPurposes');
Route::get('sltCities', 'App\Http\Controllers\CityController@sltCities');
Route::get('sltDepartments', 'App\Http\Controllers\CityController@sltDepartments');
Route::get('sltGuides', 'App\Http\Controllers\GuideController@sltGuides');
Route::get('sltFormatCodes', 'App\Http\Controllers\FormatCodeController@sltFormatCodes');
Route::get('sltRoutes', 'App\Http\Controllers\RouteController@sltRoutes');
Route::get('sltDailyRoutes', 'App\Http\Controllers\DailyRoutesController@sltDailyRoutes');
Route::get('sltAntemoremOutlets', 'App\Http\Controllers\AntemortemDailyRecordController@sltAntemoremOutlet');
Route::get('sltAntemoremAnimals/{id_outlet}', 'App\Http\Controllers\AntemortemDailyRecordController@sltAntemoremAnimals');
Route::get('sltMaster/{type}', 'App\Http\Controllers\MasterTableController@sltMaster');
Route::get('sltMasterType', 'App\Http\Controllers\MasterTableController@sltMasterType');
Route::get('sltCauses', 'App\Http\Controllers\PostmortemInspectionsController@sltCauses');