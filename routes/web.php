<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\StockHistoryController;
use App\Http\Controllers\NavHistoryController;
use App\Http\Controllers\StockCompanyController;
use App\Http\Controllers\StockKeepingController;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\NoteToDoController;
use App\Http\Controllers\NavSavingsController;
use App\Http\Controllers\DashboardController;


// Route::get('/', function () {
//     return view('admin.dashboard');
// });


Route::get('/', [AuthController::class, 'login']);
Route::post('login', [AuthController::class, 'AuthLogin']);
Route::get('logout', [AuthController::class, 'logout']);
Route::get('forgot-password', [AuthController::class, 'forgotpassword']);
Route::post('forgot-password', [AuthController::class, 'PostForgotPassword']);

Route::get('admin/dashboard', [DashboardController::class, 'index']);

// Route::get('admin/admin/list', function () {
//     return view('admin.admin.list');
// });

Route::get('admin/admin/list', [AdminController::class, 'list']);
Route::get('admin/admin/add', [AdminController::class, 'add']);
Route::post('admin/admin/add', [AdminController::class, 'insert']);
Route::get('admin/admin/edit/{id}', [AdminController::class, 'edit']);
Route::post('admin/admin/edit/{id}', [AdminController::class, 'update']);
Route::get('admin/admin/delete/{id}', [AdminController::class, 'delete']);

//Lịch sử giao dịch
Route::get('admin/stock_history/list', [StockHistoryController::class, 'getStockHistory']);
//Route::get('admin/stock_history/add', [StockHistoryController::class, 'add']);
//Route::post('admin/stock_history/add', [StockHistoryController::class, 'insert']);

#Route::get('admin/stock_history/list', [StockHistoryController::class, 'add']);
Route::post('admin/stock_history/list', [StockHistoryController::class, 'insert']);
Route::get('admin/stock_history/edit/{id}', [StockHistoryController::class, 'edit']);
Route::post('admin/stock_history/edit/{id}', [StockHistoryController::class, 'update']);
Route::get('admin/stock_history/delete/{id}', [StockHistoryController::class, 'delete']);

// Lịch sử vốn
Route::get('admin/nav_history/list', [NavHistoryController::class, 'getNavHistory']);
Route::post('admin/nav_history/list', [NavHistoryController::class, 'insert']);
Route::get('admin/nav_history/edit/{id}', [NavHistoryController::class, 'edit']);
Route::post('admin/nav_history/edit/{id}', [NavHistoryController::class, 'update']);
Route::get('admin/nav_history/delete/{id}', [NavHistoryController::class, 'delete']);

// Công ty chứng khoán
Route::get('admin/stock_company/list', [StockCompanyController::class, 'getStockCompany']);
Route::post('admin/stock_company/list', [StockCompanyController::class, 'insert']);
Route::get('admin/stock_company/edit/{id}', [StockCompanyController::class, 'edit']);
Route::post('admin/stock_company/edit/{id}', [StockCompanyController::class, 'update']);
Route::get('admin/stock_company/delete/{id}', [StockCompanyController::class, 'delete']);

// Danh mục nắm giữ
Route::get('admin/stock_keeping/list', [StockKeepingController::class, 'getStockKeeping']);

// price_trading_economics
Route::get('admin/price_trading_economics/list', function () {
    return view('admin.price_trading_economics.list');
});

// Apps
Route::get('admin/apps/list', function () {
    return view('admin.apps.list');
});

// Test
Route::get('admin/test', function () {
    return view('admin.test');
});

// ChartController
Route::get('/line-chart', function () {
    return view('line-chart');
});


// Công việc
Route::get('admin/note_to_do/list', [NoteToDoController::class, 'getNoteToDo']);
Route::post('admin/note_to_do/list', [NoteToDoController::class, 'insert']);
Route::get('admin/note_to_do/edit/{id}', [NoteToDoController::class, 'edit']);
Route::post('admin/note_to_do/edit/{id}', [NoteToDoController::class, 'update']);
Route::get('admin/note_to_do/delete/{id}', [NoteToDoController::class, 'delete']);

// Lịch sử gửi tiết kiệm
Route::get('admin/nav_savings/list', [NavSavingsController::class, 'getNavHistory']);
Route::post('admin/nav_savings/list', [NavSavingsController::class, 'insert']);
Route::get('admin/nav_savings/edit/{id}', [NavSavingsController::class, 'edit']);
Route::post('admin/nav_savings/edit/{id}', [NavSavingsController::class, 'update']);
Route::get('admin/nav_savings/delete/{id}', [NavSavingsController::class, 'delete']);