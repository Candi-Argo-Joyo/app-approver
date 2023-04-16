<?php

// use App\Http\Controllers\ApprovalMemo;
// use App\Http\Controllers\Approver1;
// use App\Http\Controllers\Approver2;
// use App\Http\Controllers\Approver3;
use App\Http\Controllers\Auth\LoginAdmin;
// use App\Http\Controllers\Auth\LoginUser;
use App\Http\Controllers\FormBuilder;
// use App\Http\Controllers\CreateMemo;
use App\Http\Controllers\Dashboard;
// use App\Http\Controllers\DataKredit;
// use App\Http\Controllers\DataMemo;
use App\Http\Controllers\DataMenu;
use App\Http\Controllers\Datatables\DatatablesContoller;
use App\Http\Controllers\Jabatan;
use App\Http\Controllers\DigitalAsign;
use App\Http\Controllers\Divisi;
// use App\Http\Controllers\EntryKredit;
use App\Http\Controllers\Log;
// use App\Http\Controllers\Knowledge;
use App\Http\Controllers\Level;
use App\Http\Controllers\MailSetting;
// use App\Http\Controllers\MemoTemplate;
use App\Http\Controllers\MappingUsers;
use App\Http\Controllers\Pages;
use App\Http\Controllers\SettingWeb;
use App\Http\Controllers\Users;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Auth::routes();

Route::group(['middleware' => 'checkRole:administrator'], function () {
    // json datatables
    Route::controller(DatatablesContoller::class)->group(function () {
        Route::get('/datatables-users', 'datatablesUsers')->name('users.datatables');
        Route::get('/datatables-position', 'datatablesPosition')->name('poistion.datatables');
        Route::get('/datatables-division', 'datatablesDivision')->name('division.datatables');
        Route::get('/datatables-page-menu', 'datatablesPageMenu')->name('pagemenu.datatables');
        Route::get('/datatables-hast-mappig', 'datatablesHastMapping')->name('hastmapping.datatables');
        Route::get('/datatables-un-mappig', 'datatablesUnMapping')->name('untmapping.datatables');
        Route::get('/datatables-logs', 'datatablesLogs')->name('logs.datatables');
    });

    Route::controller(Jabatan::class)->group(function () {
        Route::get('/poistion', 'index')->name('poistion');
        Route::post('/poistion/save', 'save')->name('poistion.save');
        Route::post('/poistion/edit', 'edit')->name('poistion.edit');
        Route::post('/poistion/delete', 'delete')->name('poistion.delete');
    });

    Route::controller(Divisi::class)->group(function () {
        Route::get('/division', 'index')->name('division');
        Route::post('/division/save', 'save')->name('division.save');
        Route::post('/division/edit', 'edit')->name('division.edit');
        Route::post('/division/delete', 'delete')->name('division.delete');
    });

    Route::controller(MappingUsers::class)->group(function () {
        Route::get('/mapping-users', 'index')->name('mappingusers');
        Route::post('/mapping-users/save-mapping', 'saveMapping')->name('mappingusers.savemapping');
        Route::post('/mapping-users/rollback', 'rollback')->name('mappingusers.rollback');
    });

    // Route::controller(MemoTemplate::class)->group(function () {
    //     Route::get('/memo-template', 'index')->name('memoTemplate');
    //     Route::get('/memo-template/add', 'add')->name('memoTemplate.add');
    //     Route::get('/memo-template/add/more', 'moreTemplate')->name('memoTemplate.add.more');
    // });

    Route::controller(DigitalAsign::class)->group(function () {
        Route::get('/digital-asign', 'index')->name('digitalAsign');
    });

    Route::controller(Users::class)->group(function () {
        Route::get('/users', 'index')->name('users');
        Route::post('/users/save', 'save')->name('users.save');
        Route::post('/users/edit', 'edit')->name('users.edit');
        Route::post('/users/delete', 'delete')->name('users.delete');
    });

    Route::controller(Level::class)->group(function () {
        Route::get('/level', 'index')->name('level');
    });

    Route::controller(SettingWeb::class)->group(function () {
        Route::get('/setting-web', 'index')->name('settingweb');
        Route::post('/setting-web/save-ldap', 'saveLdap')->name('settingweb.saveldap');
    });

    Route::controller(MailSetting::class)->group(function () {
        Route::get('/setting-mail', 'index')->name('settingmail');
        Route::post('/setting-mail/save', 'save')->name('settingmail.save');
    });

    Route::controller(DataMenu::class)->group(function () {
        Route::get('/data-menu', 'index')->name('dataMenu');
        Route::get('/data-menu/get-group', 'getGroupAll')->name('dataMenu.getGroupAll');
        Route::post('/data-menu/save-group', 'saveGroup')->name('dataMenu.savegroup');
        Route::post('/data-menu/get-one-group', 'getOneGroup')->name('dataMenu.delonegroup');
        Route::post('/data-menu/delete-group', 'delGroup')->name('dataMenu.delgroup');
        Route::post('/data-menu/save-menu', 'saveMenu')->name('dataMenu.saveMenu');
        Route::post('/data-menu/edit-menu', 'editMenu')->name('dataMenu.editMenu');
        Route::post('/data-menu/delete-menu', 'deleteMenu')->name('dataMenu.deleteMenu');
        Route::get('/data-menu/get-all-menu', 'getAllMenu')->name('dataMenu.getAllMenu');
        Route::get('/data-menu/get-singgle-menu', 'getSinggleMenu')->name('dataMenu.getSinggleMenu');
        Route::post('/data-menu/get-parent-menu', 'getParentMenu')->name('dataMenu.getParentMenu');
        Route::post('/data-menu/page-parent-menu', 'pageParentMenu')->name('dataMenu.pageParentMenu');
        Route::post('/data-menu/save-page-menu', 'savePageMenu')->name('dataMenu.savePageMenu');
    });
});

Route::group(['middleware' => 'checkRole:administrator,manager'], function () {
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
        Route::post('/form-builder/more-approver', 'moreApprover')->name('formBuilder.moreapprover');
        Route::post('/form-builder/get-page-approver', 'getpageApprover')->name('formBuilder.getpageapprover');
        Route::post('/form-builder/setting-form/get-field', 'settingGetfield')->name('formBuilder.settinggetfield');
        Route::post('/form-builder/setting-form/save-field-approver', 'settingSaveApprover')->name('formBuilder.settingsaveapprover');
    });
});

Route::group(['middleware' => 'checkRole:administrator,user,manager'], function () {
    Route::controller(DatatablesContoller::class)->group(function () {
        Route::get('/datatables-entry-page', 'datatablesentry')->name('entrypage.datatables');
        Route::get('/datatables-approval-page', 'datatablesapproval')->name('approvalpage.datatables');
        Route::get('/datatables-data-page', 'datatablesData')->name('datapage.datatables');
    });

    Route::controller(Dashboard::class)->group(function () {
        Route::get('/', 'index')->name('dashboard');
    });

    Route::controller(DataMenu::class)->group(function () {
        Route::get('/data-menu/get-sidebar', 'sidebar')->name('dataMenu.sidebar');
    });

    Route::controller(Pages::class)->group(function () {
        Route::get('/pages', 'index')->name('pages');
        Route::post('/save-data', 'save')->name('pages.save');
        Route::post('/delete-data', 'deleteInsertForm')->name('pages.delete');
    });

    Route::controller(Log::class)->group(function () {
        Route::get('/logActivity', 'logActivity')->name('log');
    });
});
