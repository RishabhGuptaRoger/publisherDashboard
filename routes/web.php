<?php

use App\Http\Livewire\Admin\CompanyComponent;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Admin\ShowOffers;
use App\Http\Livewire\Admin\ShowDocs;
use App\Http\Controllers\CompanyController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.index');
    })->name('dashboard');

    Route::prefix('admin')->group(function () {

        Route::get('/company', function () {
            return view('admin.company-component');
        })->name('advertiser');

        Route::get('show-offers/{id}', function($id) {
            return view('admin.show-offers', ['id' => $id]);
        })->name('admin.show-offers');

        Route::get('show-docs/{id}', function($id) {
            return view('admin.show-docs', ['id' => $id]);
        })->name('admin.show-docs');

        Route::get('company/{company}/approve', [CompanyController::class, 'approve'])->name('company.approve');
        Route::get('company/{company}/disapprove', [CompanyController::class, 'disapprove'])->name('company.disapprove');
    });
});



