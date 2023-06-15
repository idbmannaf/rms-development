<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\IndexController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\UserRoleController;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\TowerController;
use App\Http\Controllers\Auth\AuthController;
use \App\Http\Controllers\Company\CompanyTowerController;
use \App\Http\Controllers\Company\CompanyInfoController;
use App\Http\Controllers\Company\CompanyIndexController;
use App\Http\Controllers\GridDataController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//Route::get('/', function () {
//    return view('welcome');
//});
Route::get(
    '/clear',
    function () {
        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        Artisan::call('route:clear');
        Artisan::call('view:clear');
        Artisan::call('optimize:clear');

        return redirect()->back();
    }
)->name('clear_cache');

//auth
Route::get('/', [AuthController::class, 'index'])->name('auth.home');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/login', [AuthController::class, 'index'])->name('auth.login');
Route::get('/logout', [AuthController::class, 'index'])->name('auth.logout');



Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::middleware(['userRole:admin', 'auth'])->prefix('admin')->group(function () {
    Route::post('/change-password', [AuthController::class, 'change_password'])->name('admin.change-password');
    Route::post('/change-password/{id}', [AuthController::class, 'change_user_password'])->name('admin.user.change-password');
    Route::get('/', [IndexController::class, 'index'])->name('admin.home');

    //Device
    Route::resource('device', \App\Http\Controllers\Admin\DeviceController::class);
    //Active Device
    Route::get('active/device/rms/{tower}', [\App\Http\Controllers\Admin\ActiveDeviceController::class,'index'])->name('admin.tower.active_device.index');
    Route::get('add/active/device/rms/{tower}', [\App\Http\Controllers\Admin\ActiveDeviceController::class,'create'])->name('admin.tower.active_device.create');
    Route::post('active/device/store/rms/{tower}', [\App\Http\Controllers\Admin\ActiveDeviceController::class,'store'])->name('admin.tower.active_device.store');
    Route::get('edit/active/device/{active_device}/rms/{tower}', [\App\Http\Controllers\Admin\ActiveDeviceController::class,'edit'])->name('admin.tower.active_device.edit');
    Route::patch('update/active/device/{active_device}/rms/{tower}', [\App\Http\Controllers\Admin\ActiveDeviceController::class,'update'])->name('admin.tower.active_device.update');
    Route::delete('delete/active/device/{active_device}/rms/{tower}', [\App\Http\Controllers\Admin\ActiveDeviceController::class,'destroy'])->name('admin.tower.active_device.delete');
//users
    Route::resource('users', UserController::class);

//user role
    Route::resource('user-roles', UserRoleController::class);

//Company
    Route::resource('companies', CompanyController::class);
    Route::match(['get','post'],'company/{company}/tenant', [CompanyController::class,'companyTenant'])->name('companyTenant');
    Route::put('company/{company}/tenant/{tenant}', [CompanyController::class,'companyTenantUpdate'])->name('companyTenant.update');
    Route::post('companies/active', [CompanyController::class, 'active'])->name('companies.active');

//tower

    //Zone Region Cluster Start
    Route::get('{company}/zone/region/cluster',[\App\Http\Controllers\Admin\ZoneRegionClusterController::class,'zoneRegionCluster'])->name('zoneRegionCluster');
    Route::post('{company}/add/region',[\App\Http\Controllers\Admin\ZoneRegionClusterController::class,'addregion'])->name('addregion');
    Route::get('{company}/edit/region/{region}',[\App\Http\Controllers\Admin\ZoneRegionClusterController::class,'ediitRegionDetails'])->name('editRegionDetails');
    Route::post('{company}/edit/region/{region}',[\App\Http\Controllers\Admin\ZoneRegionClusterController::class,'updateRegion'])->name('updateRegion');
    Route::get('{company}/update/region/{region}',[\App\Http\Controllers\Admin\ZoneRegionClusterController::class,'regionUpdate'])->name('regionUpdate');
    Route::post('{company}/add/zone',[\App\Http\Controllers\Admin\ZoneRegionClusterController::class,'addNewZone'])->name('addNewZone');
    Route::get('{company}/edit/zone/{zone}',[\App\Http\Controllers\Admin\ZoneRegionClusterController::class,'editZone'])->name('editZone');
    Route::post('{company}/update/zone/{zone}',[\App\Http\Controllers\Admin\ZoneRegionClusterController::class,'updateZone'])->name('updateZone');
    Route::post('{company}/add/sitecode',[\App\Http\Controllers\Admin\ZoneRegionClusterController::class,'addNewSiteCode'])->name('addNewSiteCode');
    Route::get('{company}/edit/sitecode/{scode}',[\App\Http\Controllers\Admin\ZoneRegionClusterController::class,'updateSiteCode'])->name('updateSiteCode');
    Route::post('{company}/update/sitecode/{scode}',[\App\Http\Controllers\Admin\ZoneRegionClusterController::class,'updatepostsiteCode'])->name('updatepostsiteCode');
    Route::post('{company}/add/cluster',[\App\Http\Controllers\Admin\ZoneRegionClusterController::class,'addCluster'])->name('addCluster');
    Route::get('{company}/add/cluster/{cluster}',[\App\Http\Controllers\Admin\ZoneRegionClusterController::class,'editClusterDetails'])->name('editClusterDetails');
    Route::post('{company}/update/cluster/{cluster}',[\App\Http\Controllers\Admin\ZoneRegionClusterController::class,'updateCluster'])->name('updateCluster');
    Route::post('{company}/add/vendor',[\App\Http\Controllers\Admin\ZoneRegionClusterController::class,'addVendor'])->name('addVendor');
    Route::get('{company}/add/vendor/{vendor}',[\App\Http\Controllers\Admin\ZoneRegionClusterController::class,'editVendorDetails'])->name('editVendorDetails');
    Route::post('{company}/update/vendor/{vendor}',[\App\Http\Controllers\Admin\ZoneRegionClusterController::class,'updateVendor'])->name('updateVendor');
    //Zone Region Cluster End


    Route::resource('towers', TowerController::class);
    Route::post('towers/active', [TowerController::class, 'active'])->name('towers.active');
//Grid Data
    Route::get('tms/data/{tower}',[\App\Http\Controllers\Admin\TowerDataController::class,'index'])->name('admin.tower_data');


    Route::resource('alarms',\App\Http\Controllers\Admin\AlarmInfoController::class);

});

Route::middleware(['auth'])->prefix('company')->group(function () {
    Route::get('/password-verify', [AuthController::class, 'password_verify'])->name('company.password-verify');
    Route::post('/change-password', [AuthController::class, 'change_password'])->name('company.change-password');
    Route::get('{company}', [CompanyIndexController::class, 'index'])->name('company.home');

    Route::get('company-infos/{id}', [CompanyInfoController::class, 'index'])->name('company-infos.index');
    Route::get('company-infos/{id}/edit', [CompanyInfoController::class, 'edit'])->name('company-infos.edit');
    Route::put('company-infos/{id}/update', [CompanyInfoController::class, 'update'])->name('company-infos.update');

    Route::match(['get','post'],'{company}/tenants', [\App\Http\Controllers\Company\CompanyTenantController::class,'index'])->name('company.tenant');
    Route::put('{company}/tenant/{tenant}/update', [\App\Http\Controllers\Company\CompanyTenantController::class,'update'])->name('company.tenant.update');

    //Activ

    //tower
    Route::get('{company}/rms/lists', [CompanyTowerController::class, 'lists'])->name('tower.lists');
    Route::get('{company}/rms/create', [CompanyTowerController::class, 'create'])->name('company.tower.create');
    Route::post('{company}/rms/store', [CompanyTowerController::class, 'store'])->name('company.tower.store');
    Route::get('{company}/rms/{tower}/edit', [CompanyTowerController::class, 'edit'])->name('company.tower.edit');
    Route::put('{company}/rms/{tower}/update', [CompanyTowerController::class, 'update'])->name('company.tower.update');
    Route::delete('{company}/rms/{id}/destroy', [CompanyTowerController::class, 'destroy'])->name('company.tower.destroy');
    Route::post('tower/active', [CompanyTowerController::class, 'active'])->name('company-towers.active');
    Route::get('{company}/rms/{tower}/data', [CompanyTowerController::class, 'towerWiseRmsData'])->name('company-towers.towerWiseRmsData');
    Route::get('{company}/rms/{tower}/alarms', [CompanyTowerController::class, 'towerWiseAlarmData'])->name('company-towers.towerWiseAlarmData');
    Route::get('{company}/rms/{tower}/smu-data', [CompanyTowerController::class, 'towerWiseSMUData'])->name('company-towers.towerWiseSMUData');
    Route::get('{company}/rms/{tower}/bms-data', [CompanyTowerController::class, 'towerWiseBMSData'])->name('company-towers.towerWiseBMSData');


    Route::get('{company}/rfid/users',[\App\Http\Controllers\Company\CompanyRfidEmployeeController::class,'index'])->name('company.rfid.users');
    Route::get('{company}/add/rfid/users',[\App\Http\Controllers\Company\CompanyRfidEmployeeController::class,'add'])->name('company.rfid.add');
    Route::post('{company}/add/rfid/users',[\App\Http\Controllers\Company\CompanyRfidEmployeeController::class,'store'])->name('company.rfid.store');
    Route::get('{company}/edit/rfid/{id}/users',[\App\Http\Controllers\Company\CompanyRfidEmployeeController::class,'edit'])->name('company.rfid.edit');
    Route::put('{company}/update/rfid/{id}/users',[\App\Http\Controllers\Company\CompanyRfidEmployeeController::class,'update'])->name('company.rfid.update');
    Route::get('{company}/rfid/{id}/users/userWiseSmuDetails',[\App\Http\Controllers\Company\CompanyRfidEmployeeController::class,'userWiseSmuDetails'])->name('company.rfid.userWiseSmuDetails');
    Route::get('{company}/tower/lock/unlock/data/{type}',[\App\Http\Controllers\Company\CompanyRfidEmployeeController::class,'towerLockUnlockData'])->name('company.rfid.towerLockUnlockData');
    Route::get('{company}/tower/{chipid}/lock/unlock/data/{type}',[\App\Http\Controllers\Company\CompanyRfidEmployeeController::class,'towerWiseLockUnlockData'])->name('company.rfid.towerWiseLockUnlockData');
    Route::post('{company}/tower/{chipid}/rfid-employees}',[\App\Http\Controllers\Company\CompanyRfidEmployeeController::class,'towerDetailsEntryExitHistoryLogCreateByChipIdPost'])->name('company.tower.towerDetailsEntryExitHistoryLogCreateByChipIdPost');

    Route::get('{company}/tower/alarms/',[\App\Http\Controllers\Company\CompanyTowerDataController::class, 'companyTowerAlarms'])->name('company.companyTowerAlarms');
    Route::get('{company}/tower/alarm/{alarm}/details',[\App\Http\Controllers\Company\CompanyTowerDataController::class, 'companyTowerAlarmDetails'])->name('company.companyTowerAlarmDetails');

    Route::get('{company}/tower/{tower}/{type}/row/{row}',[\App\Http\Controllers\Company\CompanyTowerDataController::class, 'rmsDataExport'])->name('company.rmsDataExport');
    Route::get('{company}/towers/status/export',[\App\Http\Controllers\Company\CompanyTowerDataController::class, 'companyTowerStatusExport'])->name('company.companyTowerStatusExport');


    Route::get('{company}/tower/{tower}/active/devices',[\App\Http\Controllers\Company\CompanyTowerDataController::class, 'activeDevices'])->name('company.activeDevices');
    Route::get('{company}/tower/{tower}/active/devices{active_device}/details',[\App\Http\Controllers\Company\CompanyTowerDataController::class, 'activeDeviceDetails'])->name('company.activeDevice.details');

    Route::get('{company}/reports',[\App\Http\Controllers\Company\CompanyReportController::class,'report'])->name('company.reports');
    Route::get('{company}/power/consumption/{short_type}',[\App\Http\Controllers\Company\CompanyIndexController::class, 'powerConsumptionChartAjax'])->name('company.powerConsumptionChartAjax');
    Route::get('{company}/ac/dc/availibiliuty/{short_type}',[\App\Http\Controllers\Company\CompanyIndexController::class, 'acDcChartAjax'])->name('company.acDcChartAjax');
    Route::get('{company}/power/slab/{short_type}',[\App\Http\Controllers\Company\CompanyIndexController::class, 'powerSlabChartAjax'])->name('company.powerSlabChartAjax');


});

//Public For EveryOne
Route::get('region/{region}/to/zone',[\App\Http\Controllers\PublicController::class,'getRegionToZones'])->name('getRegionToZones');
//Public For EveryOne






Route::any('rms',[\App\Http\Controllers\DevTestController::class,'DeviceData']);
Route::any('test',[\App\Http\Controllers\DevTestController::class,'test']);



