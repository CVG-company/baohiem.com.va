<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Account\AccountController;
use App\Http\Controllers\Ajax\CompanyController;
use App\Http\Controllers\Ajax\ContractController;
use App\Http\Controllers\Ajax\AccountPackageController;
use App\Http\Controllers\Ajax\PeriodController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\System\SystemController;
use App\Http\Controllers\Contact\ContactController;
use App\Http\Controllers\Ajax\CustomerGroupController;
use App\Http\Controllers\Ajax\CustomerTypeController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PermissionsController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\SupervisorController;
use App\Http\Controllers\Revenue\RevenueController;
use App\Http\Controllers\Physical\PhysicalController;
use App\Http\Controllers\Hospital\HospitalController;
use App\Http\Controllers\Ajax\HospitalNameController;
use App\Http\Controllers\Diary\DiaryController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::group(['middleware' => ['is_user_admin', 'is_user_customer', 'is_user_employee', 'is_user_hospital']], function () {
// Routes Logout
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

// Routes Profile
Route::get('/profile', [ProfileController::class, 'index'])->name('profile.user');
Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
Route::get('/change-password', [ProfileController::class, 'changePasswordIndex'])->name('profile.changePassword');
Route::post('/change-password', [ProfileController::class, 'changePassword'])->name('change.password');
// });

// Route::middleware(['is_user_admin', 'permission'])->group(function () {

Route::get('/dashboard', [DashboardController::class, 'index'])->name('home');

// Routes for free design before
Route::group(['prefix' => 'ajax'], function () {
    // Hợp đồng
    Route::get('/contract/list', [ContractController::class, 'index'])->name('contract.index');
    Route::post('/contract/create', [ContractController::class, 'create'])->name('contract.create');
    Route::post('/contract/delete', [ContractController::class, 'delete'])->name('contract.delete');
    Route::put('/contract/update', [ContractController::class, 'update'])->name('contract.update');

    // Công ty
    Route::get('/company/list', [CompanyController::class, 'index'])->name('company.index');
    Route::post('/company/create', [CompanyController::class, 'create'])->name('company.create');
    Route::post('/company/delete', [CompanyController::class, 'delete'])->name('company.delete');
    Route::put('/company/update', [CompanyController::class, 'update'])->name('company.update');

    // Niên hạn
    Route::get('/period/list', [PeriodController::class, 'index'])->name('period.index');
    Route::post('/period/create', [PeriodController::class, 'create'])->name('period.create');
    Route::post('/period/delete', [PeriodController::class, 'delete'])->name('period.delete');
    Route::put('/period/update', [PeriodController::class, 'update'])->name('period.update');

    // Gói bảo hiểm
    Route::post('/account-package/create', [AccountPackageController::class, 'create'])->name('account-package.create');
    Route::post('/account-package/delete', [AccountPackageController::class, 'delete'])->name('account-package.delete');
    Route::put('/account-package/update', [AccountPackageController::class, 'update'])->name('account-package.update');

    // Phân nhóm khách hàng theo bệnh viện
    Route::post('/customer-group/create', [CustomerGroupController::class, 'create'])->name('customer-group.create');
    Route::post('/customer-group/delete', [CustomerGroupController::class, 'delete'])->name('customer-group.delete');
    Route::put('/customer-group/update', [CustomerGroupController::class, 'update'])->name('customer-group.update');

    // Phân loại khách hàng
    Route::post('/customer-type/create', [CustomerTypeController::class, 'create'])->name('customer-type.create');
    Route::post('/customer-type/delete', [CustomerTypeController::class, 'delete'])->name('customer-type.delete');
    Route::put('/customer-type/update', [CustomerTypeController::class, 'update'])->name('customer-type.update');

    //Bệnh viện
    Route::post('/hospital/create', [HospitalNameController::class, 'create'])->name('hospital-name.create');
    Route::post('/hospital/delete', [HospitalNameController::class, 'delete'])->name('hospital-name.delete');
    Route::put('/hospital/update', [HospitalNameController::class, 'update'])->name('hospital-name.update');
});

// Routes for free design before
Route::group(['prefix' => 'user'], function () {
    Route::get('/', [UserController::class, 'index'])->name('user.index');
    Route::get('/index', [UserController::class, 'index']);
    Route::get('/edit/{id}', [UserController::class, 'edit'])->name('user.edit');
    Route::post('/edit/{id}', [UserController::class, 'update'])->name('user.update');
    Route::get('/create', [UserController::class, 'create'])->name('user.create');
    Route::post('/create', [UserController::class, 'store'])->name('user.store');
    Route::delete('/delete/{id}', [UserController::class, 'delete'])->name('user.delete');
});

// Routes for system
Route::get('/system', [SystemController::class, 'index'])->name('system.index');
// Routes for contact
Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact', [ContactController::class, 'sendEmail'])->name('contact.form');
// Routes Account
Route::get('/account', [AccountController::class, 'index'])->name('account.index');
Route::get('/account/insurance', [AccountController::class, 'insurance'])->name('account.insurance');
Route::get('/account/insurance-expenses', [AccountController::class, 'expenses'])->name('account.expenses');
Route::get('/account/renewal', [AccountController::class, 'renewal'])->name('renewal.index');
Route::get('/account/create', [AccountController::class, 'create'])->name('account.create');
Route::post('/account/create', [AccountController::class, 'store'])->name('user.store');
Route::get('/account/edit/{id}', [AccountController::class, 'edit'])->name('account.edit');
Route::post('/account/edit/{id}', [AccountController::class, 'update'])->name('account.update');

Route::resource('role', RolesController::class);
Route::resource('permission', PermissionsController::class);

// Routes for Supervisor
Route::get('/supervisor/insurance-expenses', [SupervisorController::class, 'insuranceExpenses'])->name('supervisor.insuranceExpenses');
Route::get('/supervisor/account', [SupervisorController::class, 'account'])->name('supervisor.account');
Route::get('/supervisor/account-online', [SupervisorController::class, 'accountOnline'])->name('supervisor.accountOnline');

// Routes for Supervisor
Route::get('/supervisor', [SupervisorController::class, 'index'])->name('supervisor.index');

// Routes Physical
Route::get('/physical', [PhysicalController::class, 'index'])->name('physical.index');
Route::get('/physical-detail', [PhysicalController::class, 'detail'])->name('physical.detail');
Route::get('/physical-periodic', [PhysicalController::class, 'periodic'])->name('physical.periodic');

// Routes Department
Route::get('/department', [DepartmentController::class, 'index'])->name('department.index');
Route::post('/department/store', 'DepartmentController@store')->name('department.store');
Route::put('/department/update/{id}', 'DepartmentController@update')->name('department.update');
Route::delete('/department/delete/{id}', 'DepartmentController@destroy')->name('department.delete');

// Routes Hospital
Route::get('/hospital', [HospitalController::class, 'index'])->name('hospital.index');
Route::get('/health-report', [HospitalController::class, 'healthReport'])->name('healthReport.index');

// Routes Revenue
Route::get('/revenue', [RevenueController::class, 'index'])->name('revenue.index');

// Routes Diary
Route::get('/diary', [DiaryController::class, 'index'])->name('diary.index');
// });

// Route for login page
Route::get('/', [LoginController::class, 'showLoginForm']);
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');

// Route for forgot password page
Route::get('/forgot', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/forgot', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

// Routes for email verification
Route::get('/verify', [VerificationController::class, 'showVerifyForm'])->name('verify');
Route::post('/verify', [VerificationController::class, 'verify']);
Route::get('/verify/{id}/{hash}', [VerificationController::class, 'verify'])->name('verification.verify');
Route::get('/resend-verification', [VerificationController::class, 'resend'])->name('verification.resend');
