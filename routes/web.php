<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AuthMiddleware;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\TechicianController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ServiceReportController;
use App\Http\Controllers\FeedbackController;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard')->middleware(AuthMiddleware::class);

// If need a middleware for role
Route::middleware(['Role:super_admin,admin'])->group(function () {
    //  Route for employee
    Route::get('/add-employee', [EmployeeController::class, 'index'])->name('add-employee');
    Route::get('/list-employee', [EmployeeController::class, 'showEmployee'])->name('list-employee');

    //  Route for customer
    Route::get('/list-customer', [CustomerController::class, 'index'])->name('customer.index');
    Route::get('/add-customer', [CustomerController::class, 'create'])->name('customer.create');
    Route::post('/add-customer', [CustomerController::class, 'store'])->name('customer.store');
    Route::put('/customer/{id}', [CustomerController::class, 'updateTech'])->name('customer.updateTech');
    Route::delete('/customer/{id}', [CustomerController::class, 'destroy'])->name('customer.destroy');
});

Route::middleware(['Role:user'])->group(function () {
    Route::get('/customers', [TechicianController::class, 'getCustomer'])->name('technician.getCustomer');
});

Route::get('/feedback/{id}', [FeedbackController::class, 'showFeedbackForm']);
Route::post('/feedback/{id}', [FeedbackController::class, 'submitFeedback']);

// Route for report
Route::get('/report-technician/{id}', [ServiceReportController::class, 'index'])->name('report.technician');
Route::get('/report-download/{id}', [ReportController::class, 'generate'])->name('pdf.generate');
Route::POST('/report-create/{id}', [ServiceReportController::class, 'createReport'])->name('report.create');
Route::get('/report-pdf/{id}', [ReportController::class, 'index'])->name('report.index');

Route::post('/employee/create', [EmployeeController::class, 'createEmployee'])->name('create-employee');
Route::delete('/employee/delete/{id}', [EmployeeController::class, 'deleteEmployee'])->name('delete-employee');
Route::post('/employee/update/{id}', [EmployeeController::class, 'updateEmployee'])->name('employee.update');

Route::get('/data-chart', [DashboardController::class, 'getDataChart']);

Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');