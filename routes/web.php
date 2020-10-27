<?php

use Illuminate\Support\Facades\Route;

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
Route::get('/', function () {
    return view('landing-page');
});

Route::get('/user-login', function () {
    return view('welcome');
})->middleware('checkAuth');

Route::get('/create-account', function () {
    return view('create-account');
})->middleware('checkAuth');
//Route::get('/working-tutorial', "DomainsController@tutorialWorking")->middleware('dashboard')->name('home')->middleware('dashboard');
//Route::get('add-password', "PasswordsController@addPassword")->middleware('dashboard');
//Route::post('add-password', "PasswordsController@savePassword")->middleware('dashboard');
//Route::post('/domain/update', "DomainsController@updateDomain")->middleware('dashboard');
//Route::post('/domain/delete', "DomainsController@deleteDomain")->middleware('dashboard');
//Route::get('edit/domain/{id}', "DomainsController@editDomain")->middleware('dashboard');
Auth::routes();
//Route::get('/admin', "AdminController@loginPage")->middleware('checkAuth');
//Route::post('/admin/login', "AdminController@login")->name('admin.login');
//Route::get('admin-dashboard', "AdminController@adminDashboard");
//Route::post('admin-logout', "AdminController@logout")->name('admin.logout');

//Route::get('fbx', function (){
//  return view('fbx');
//});

Route::get('logout-user', function (){
    \Illuminate\Support\Facades\Session::flush();
    \Illuminate\Support\Facades\Auth::logout();
    return redirect('/');
})->name('logout-user');


Route::post('login', "AdminController@login")->name('login');

Route::get('/home', "HomeController@showDashboard")->middleware('dashboard');
Route::get('/history', "HomeController@history")->middleware('dashboard');

Route::get('staff', 'StaffController@getStaffListView')->middleware('dashboard');
Route::get('add-staff', "StaffController@getAddStaffView")->middleware('dashboard');
Route::post('save-staff', "StaffController@saveStaff");
Route::get('delete-staff/{id}', "StaffController@deleteStaff")->middleware('dashboard');
Route::get('edit-staff/{id}', "StaffController@editStaff")->middleware('dashboard');
Route::post('save-edited-staff', "StaffController@saveEditedStaff");


Route::post('login-user', "AuthController@login");
Route::post('create-new-account', "AuthController@signup");
Route::post('send-email', "HomeController@sendMail");
Route::post('save-package', "HomeController@savePackage");
