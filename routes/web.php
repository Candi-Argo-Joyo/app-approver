<?php

use App\Http\Controllers\ApprovalMemo;
use App\Http\Controllers\Approver1;
use App\Http\Controllers\Approver2;
use App\Http\Controllers\Approver3;
use App\Http\Controllers\Auth\LoginAdmin;
use App\Http\Controllers\Auth\LoginUser;
use App\Http\Controllers\FormBuilder;
use App\Http\Controllers\CreateMemo;
use App\Http\Controllers\Dashboard;
use App\Http\Controllers\DataKredit;
use App\Http\Controllers\DataMemo;
use App\Http\Controllers\DataMenu;
use App\Http\Controllers\Jabatan;
use App\Http\Controllers\DigitalAsign;
use App\Http\Controllers\Divisi;
use App\Http\Controllers\EntryKredit;
use App\Http\Controllers\Knowledge;
use App\Http\Controllers\Level;
use App\Http\Controllers\MemoTemplate;
use App\Http\Controllers\MappingUsers;
use App\Http\Controllers\SettingWeb;
use App\Http\Controllers\Users;
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

Route::controller(LoginAdmin::class)->group(function () {
    Route::get('/login-admin', 'index')->name('loginAdmin');
});

Route::controller(LoginUser::class)->group(function () {
    Route::get('/login', 'index')->name('login');
});

Route::controller(Dashboard::class)->group(function () {
    Route::get('/', 'index')->name('dashboard');
});

Route::controller(Jabatan::class)->group(function () {
    Route::get('/poistion', 'index')->name('poistion');
});

Route::controller(Divisi::class)->group(function () {
    Route::get('/division', 'index')->name('division');
});

Route::controller(MappingUsers::class)->group(function () {
    Route::get('/mapping-users', 'index')->name('mappingusers');
});

Route::controller(MemoTemplate::class)->group(function () {
    Route::get('/memo-template', 'index')->name('memoTemplate');
    Route::get('/memo-template/add', 'add')->name('memoTemplate.add');
    Route::get('/memo-template/add/more', 'moreTemplate')->name('memoTemplate.add.more');
});

Route::controller(DigitalAsign::class)->group(function () {
    Route::get('/digital-asign', 'index')->name('digitalAsign');
});

Route::controller(FormBuilder::class)->group(function () {
    Route::get('/form-builder', 'index')->name('formBuilder');
    Route::get('/form-builder/add', 'add')->name('formBuilder.add');
    Route::post('/form-builder/update-html-form', 'updateFormHtml')->name('formBuilder.updateformhtml');
    Route::post('/form-builder/create-layout', 'createForm')->name('formBuilder.createform');
    Route::post('/form-builder/get-layout', 'getLayout')->name('formBuilder.getlayout');
    Route::post('/form-builder/del-layout', 'delLayout')->name('formBuilder.dellayout');
    Route::post('/form-builder/get-field', 'getField')->name('formBuilder.getfield');
    Route::post('/form-builder/rename-field', 'renameField')->name('formBuilder.renamefield');
    Route::post('/form-builder/delete-field', 'delField')->name('formBuilder.delfield');
    Route::get('/form-builder/del-form', 'delForm')->name('formBuilder.delform');
    Route::post('/form-builder/get-option', 'getOption')->name('formBuilder.getoption');
    Route::post('/form-builder/more-option', 'moreOption')->name('formBuilder.moreoption');
    Route::post('/form-builder/submit-option', 'submitOption')->name('formBuilder.submitOption');
    Route::post('/form-builder/del-option', 'delOption')->name('formBuilder.delOption');
    Route::post('/form-builder/get-radio', 'getRadio')->name('formBuilder.getRadio');
    Route::get('/form-builder/preview', 'preview')->name('formBuilder.preview');
});

Route::controller(EntryKredit::class)->group(function () {
    Route::get('/entry-kredit', 'index')->name('entryKredit');
    Route::get('/entry-kredit/add', 'add')->name('entryKredit.add');
});

Route::controller(Knowledge::class)->group(function () {
    Route::get('/knowledge', 'index')->name('knowledge');
});

Route::controller(Approver1::class)->group(function () {
    Route::get('/approver-1', 'index')->name('approver1');
});

Route::controller(Approver2::class)->group(function () {
    Route::get('/approver-2', 'index')->name('approver2');
});

Route::controller(Approver3::class)->group(function () {
    Route::get('/approver-3', 'index')->name('approver3');
});

Route::controller(DataKredit::class)->group(function () {
    Route::get('/data-kredit', 'index')->name('dataKredit');
    Route::get('/data-kredit/detail', 'detail')->name('dataKredit.detail');
});

Route::controller(CreateMemo::class)->group(function () {
    Route::get('/create-memo', 'index')->name('createMemo');
    Route::get('/create-memo/adda', 'add')->name('createMemo.add');
});

Route::controller(ApprovalMemo::class)->group(function () {
    Route::get('/approval-memo', 'index')->name('approvalMemo');
});

Route::controller(DataMemo::class)->group(function () {
    Route::get('/data-memo', 'index')->name('dataMemo');
});

Route::controller(Users::class)->group(function () {
    Route::get('/users', 'index')->name('users');
});

Route::controller(Level::class)->group(function () {
    Route::get('/level', 'index')->name('level');
});

Route::controller(SettingWeb::class)->group(function () {
    Route::get('/setting-web', 'index')->name('settingweb');
});

Route::controller(DataMenu::class)->group(function () {
    Route::get('/data-menu', 'index')->name('dataMenu');
    Route::get('/data-menu/get-group', 'getGroupAll')->name('dataMenu.getGroupAll');
    Route::post('/data-menu/save-group', 'saveGroup')->name('dataMenu.savegroup');
    Route::post('/data-menu/get-one-group', 'getOneGroup')->name('dataMenu.delonegroup');
    Route::post('/data-menu/delete-group', 'delGroup')->name('dataMenu.delgroup');
    Route::post('/data-menu/save-menu', 'saveMenu')->name('dataMenu.saveMenu');
    Route::get('/data-menu/get-all-menu', 'getAllMenu')->name('dataMenu.getAllMenu');
    Route::get('/data-menu/get-singgle-menu', 'getSinggleMenu')->name('dataMenu.getSinggleMenu');
    Route::post('/data-menu/get-parent-menu', 'getParentMenu')->name('dataMenu.getParentMenu');
    Route::get('/data-menu/get-sidebar', 'sidebar')->name('dataMenu.sidebar');
});
