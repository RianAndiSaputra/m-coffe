<?php

use App\Http\Controllers\API\ReportController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CashRegisterController;
use App\Http\Controllers\CashRegisterTransactionController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OutletController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ShiftController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);
        
    Route::middleware('role:admin')->group(function () {
        
        Route::controller(AuthController::class)->prefix('user')->group(function () {
            Route::post('/register', 'register');
            Route::post('/update/{user}', 'update');
            Route::delete('/delete/{user}', 'destroy');
        });

        Route::controller(OutletController::class)->group(function () {
            Route::get('/outlets', 'index');
            Route::post('/outlets', 'store');
            Route::get('/outlets/{outlet}', 'show');
            Route::put('/outlets/{outlet}', 'update');
            Route::delete('/outlets/{outlet}', 'destroy');
        });

        Route::controller(CategoryController::class)->group(function () {
            Route::get('/categories', 'index');
            Route::post('/categories', 'store');
            Route::get('/categories/{category}', 'show');
            Route::put('/categories/{category}', 'update');
            Route::delete('/categories/{category}', 'destroy');
        });

        Route::controller(ProductController::class)->group(function () {
            Route::get('/products', 'index');
            Route::post('/products', 'store');
            Route::get('/products/{product}', 'show');
            Route::put('/products/{product}', 'update');
            Route::delete('/products/{product}', 'destroy');
            Route::get('/products/outlet/{outletId}', 'getOutletProducts');

        });

        Route::controller(InventoryController::class)->group(function () {
            Route::get('/inventories', 'index');
            Route::post('/inventories', 'store');
            Route::get('/inventories/{inventory}', 'show');
            Route::put('/inventories/{inventory}', 'update');
            Route::delete('/inventories/{inventory}', 'destroy');
        });

        Route::controller(ShiftController::class)->group(function () {
            Route::get('/shifts', 'index');
            Route::post('/shifts', 'store');
            Route::get('/shifts/{shift}', 'show');
            Route::put('/shifts/{shift}', 'update');
            Route::delete('/shifts/{shift}', 'destroy');
        });

        Route::controller(ReportController::class)->prefix('reports')->group(function () {
            Route::get('/daily-sales/{outletId}', 'dailySales');
            Route::get('/monthly-sales/{outletId}', 'monthlySales');
            Route::get('/monthly-inventory/{outletId}', 'monthlyInventory');
            Route::get('/inventory-by-date/{outletId}', 'inventoryByDate');
            Route::get('/shift-report/{outletId}', 'shiftReport');
            Route::get('/dashboard-summary/{outletId}', 'dashboardSummary');
        });

        Route::get('/admin', function () {
            return response()->json([
                'message' => 'Ini untuk admin'
            ]);
        });
    });
    
    Route::middleware('role:kasir,admin')->group(function () {

        Route::post('/update-profile', [AuthController::class, 'updateProfile']);

        Route::get('/kasir-admin', function () {
            return response()->json([
                'message' => 'Ini untuk kasir dan admin'
            ]);
        });

        Route::controller(ProductController::class)->group(function () {
            Route::get('/products/outlet/pos', 'getOutletProductsPos');
            Route::get('/products/outlet/{outletId}', 'getOutletProducts');
        });

        Route::get('/categories', [CategoryController::class, 'index']);

        Route::controller(OrderController::class)->group(function () {
            Route::post('/orders', 'store');
            Route::get('/orders/cancel/{id}', 'cancelOrder');
            Route::get('/orders/history', 'orderHistory');
        });

        Route::controller(CashRegisterController::class)->group(function () {
            Route::get('/cash-registers', 'index');
            Route::post('/cash-registers', 'store');
            Route::get('/cash-registers/{outlet_id}', 'show');
            Route::put('/cash-registers/{id}', 'update');
            Route::delete('/cash-registers/{id}', 'destroy');
        });

        Route::controller(CashRegisterTransactionController::class)->group(function () {
            Route::get('/cash-register-transactions', 'index');
            Route::post('/cash-register-transactions', 'store');
            Route::get('/cash-register-transactions/{id}', 'show');
            Route::get('/cash-register-transactions/cash-register/{id}', 'getByCashRegister');
            Route::get('/cash-register-transactions/shift/{shiftId}', 'getByShift');
            Route::get('/cash-register-transactions/type/{type}', 'getType');
            Route::get('/cash-register-transactions/balance/{id}', 'getBalance');
        });
    });
});
