<?php

use App\Http\Controllers\ApprovalMemo;
use App\Http\Controllers\Approver1;
use App\Http\Controllers\Approver2;
use App\Http\Controllers\Approver3;
use App\Http\Controllers\CreateMemo;
use App\Http\Controllers\Dashboard;
use App\Http\Controllers\DataKredit;
use App\Http\Controllers\DataMemo;
use App\Http\Controllers\Dealer;
use App\Http\Controllers\DigitalAsign;
use App\Http\Controllers\Divisi;
use App\Http\Controllers\EntryKredit;
use App\Http\Controllers\Knowledge;
use App\Http\Controllers\MemoTemplate;
use App\Http\Controllers\Sales;
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

Route::controller(Dashboard::class)->group(function () {
    Route::get('/', 'index')->name('dashboard');
});

Route::controller(Dealer::class)->group(function () {
    Route::get('/dealer', 'index')->name('dealer');
});

Route::controller(Sales::class)->group(function () {
    Route::get('/sales', 'index')->name('sales');
});

Route::controller(Divisi::class)->group(function () {
    Route::get('/divisi', 'index')->name('divisi');
});

Route::controller(MemoTemplate::class)->group(function () {
    Route::get('/memo-template', 'index')->name('memoTemplate');
    Route::get('/memo-template/add', 'add')->name('memoTemplate.add');
    Route::get('/memo-template/add/more', 'moreTemplate')->name('memoTemplate.add.more');
});

Route::controller(DigitalAsign::class)->group(function () {
    Route::get('/digital-asign', 'index')->name('digitalAsign');
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
