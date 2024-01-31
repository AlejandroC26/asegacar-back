<?php

use App\Http\Controllers\AgeController;
use App\Http\Controllers\AntemoretemInspectionController;
use App\Http\Controllers\AntemortemDailyRecordController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChannelConditioningController;
use App\Http\Controllers\ColorsController;
use App\Http\Controllers\DailyPayrollController;
use App\Http\Controllers\DailyRoutesController;
use App\Http\Controllers\DispatchGuideController;
use App\Http\Controllers\EmergencyCoilEntryController;
use App\Http\Controllers\FormatCodeController;
use App\Http\Controllers\FormBenefitOrderController;
use App\Http\Controllers\GendersController;
use App\Http\Controllers\GeneralParamsController;
use App\Http\Controllers\GuideController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\IncomeFormController;
use App\Http\Controllers\InspectionSuspiciousAnimalController;
use App\Http\Controllers\MasterTableController;
use App\Http\Controllers\OutletController;
use App\Http\Controllers\ParturientFemalesController;
use App\Http\Controllers\PurposeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\PostmortemInspectionsController;
use App\Http\Controllers\RouteController;
use App\Http\Controllers\SeizureComparisonController;
use App\Http\Controllers\SuspiciousAnimalsController;
use App\Http\Controllers\VehicleController;
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

Route::middleware(['auth'])->group(function () {
    Route::resource('vehicles', VehicleController::class);
    Route::resource('persons', PersonController::class);
    Route::resource('users', UserController::class);
    Route::resource('purposes', PurposeController::class);
    Route::resource('outlets', OutletController::class);
    Route::resource('ages', AgeController::class);
    Route::resource('incomes', IncomeController::class);
    Route::resource('formatCodes', FormatCodeController::class);
    Route::resource('incomeForm', IncomeFormController::class);
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
    Route::resource('antemortemInspection', AntemoretemInspectionController::class);
    Route::resource('parturientFemales', ParturientFemalesController::class);
    Route::resource('suspiciousAnimals', SuspiciousAnimalsController::class);
    Route::resource('emergencyCoilEntry', EmergencyCoilEntryController::class);
    Route::resource('generalParams', GeneralParamsController::class);
    Route::resource('inspectionSuspiciousAnimals', InspectionSuspiciousAnimalController::class);
    Route::resource('dispatchGuides', DispatchGuideController::class);
    
    
    Route::get('/getpermissions', 'App\Http\Controllers\AuthController@getpermissions');
    
    Route::get('dailyMatrix', 'App\Http\Controllers\DailyMatrixController@index');
    Route::get('signature/{nIdPerson}', 'App\Http\Controllers\PersonController@onGetSignature');
    Route::get('authorization/{nIdPerson}', 'App\Http\Controllers\PersonController@onGetAuthorization');
    
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
    Route::post('antemortemInspectionFormat', 'App\Http\Controllers\AntemoretemInspectionController@download');
    Route::post('parturientFemalesFormat/{nId}', 'App\Http\Controllers\ParturientFemalesController@download');
    Route::post('suspiciousAnimalsFormat/{nId}', 'App\Http\Controllers\SuspiciousAnimalsController@download');
    Route::post('emergencyCoilEntryFormat/{nId}', 'App\Http\Controllers\EmergencyCoilEntryController@download');
    Route::post('dispatchGuidesFormat/{nId}', 'App\Http\Controllers\DispatchGuideController@download');
    
    Route::get('antemortemDailyRecordPending', 'App\Http\Controllers\AntemortemDailyRecordController@pending');
    Route::post('contractPDF/{nIdGuide}', 'App\Http\Controllers\GuideController@generatePDF');
    Route::post('guidePDF/{nIdGuide}', 'App\Http\Controllers\GuideController@downloadGuide');
    Route::get('sltUsers', 'App\Http\Controllers\UserController@sltUsers');
    Route::get('sltCharges', 'App\Http\Controllers\UserController@sltCharges');
    Route::get('sltPersons', 'App\Http\Controllers\PersonController@sltPersons');
    Route::get('sltAges', 'App\Http\Controllers\AgeController@sltAges');
    Route::get('sltOutlets', 'App\Http\Controllers\OutletController@sltOutlets');
    Route::get('sltPurposes', 'App\Http\Controllers\PurposeController@sltPurposes');
    Route::get('sltCities/{idDepartment}', 'App\Http\Controllers\CityController@sltCities');
    Route::get('sltDepartments', 'App\Http\Controllers\CityController@sltDepartments');
    Route::get('sltGuides', 'App\Http\Controllers\GuideController@sltGuides');
    Route::get('sltGuideForIncomeForm/{sDate}', 'App\Http\Controllers\GuideController@sltGuideForIncomeForm');
    Route::get('sltGuideForDailyPayroll/{sDate}', 'App\Http\Controllers\GuideController@sltGuideForDailyPayroll');
    
    Route::get('sltFormatCodes', 'App\Http\Controllers\FormatCodeController@sltFormatCodes');
    Route::get('sltRoutes', 'App\Http\Controllers\RouteController@sltRoutes');
    Route::get('sltVehicles', 'App\Http\Controllers\VehicleController@sltVehicles');
    Route::get('sltDailyRoutes', 'App\Http\Controllers\DailyRoutesController@sltDailyRoutes');
    
    Route::get('sltMaster/{type}', 'App\Http\Controllers\MasterTableController@sltMaster');
    Route::get('sltMasterType', 'App\Http\Controllers\MasterTableController@sltMasterType');
    Route::get('sltCauses', 'App\Http\Controllers\PostmortemInspectionsController@sltCauses');
    Route::get('sltSpecies', 'App\Http\Controllers\GuideController@sltSpecies');
    Route::get('sltDailyPayrolls', 'App\Http\Controllers\DailyPayrollController@sltDailyPayrolls');
    Route::get('sltAntemortemVeterinary', 'App\Http\Controllers\AntemoretemInspectionController@sltAntemortemVeterinary');
    
    Route::get('sltGuideThroughMaster/{table}/{sDate}', 'App\Http\Controllers\GuideController@sltGuideThroughMaster');
    Route::get('sltPayrrollsGuide/{relation}/{id_guide}', 'App\Http\Controllers\DailyPayrollController@sltPayrrollsGuide');
    
    Route::get('sltAntemoremOutlets/{relation}', 'App\Http\Controllers\AntemortemDailyRecordController@sltAntemoremOutlet');
    Route::get('sltAntemoremAnimals/{relation}/{id_outlet}', 'App\Http\Controllers\AntemortemDailyRecordController@sltAntemoremAnimals');
    
    Route::get('sltProductTypes', 'App\Http\Controllers\DailyPayrollController@sltProductTypes');
    Route::get('dailyPayrollGuides/{nIdGuide}', 'App\Http\Controllers\GuideController@dailyPayrollGuides');
    Route::get('dailyPayrollOutlets/{nIdOutlet}/{sDate}', 'App\Http\Controllers\OutletController@dailyPayrollOutlets');
    Route::get('sltDispatchGuideOutlets/{sDate}', 'App\Http\Controllers\OutletController@dispatchGuideOutlets');
    Route::get('sltUsersByCharge/{nIdCharge}', 'App\Http\Controllers\UserController@sltUsersByCharge');
    Route::get('sltUsersIdByCharge/{nIdCharge}', 'App\Http\Controllers\UserController@sltUsersIdByCharge');
});
