<?php

use App\Http\Livewire\Admin\Advertiser;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Admin\ShowOffers;
use App\Http\Livewire\Admin\ShowDocs;

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

    Route::get('/advertiser', function () {
        return view('admin.advertiser');
    })->name('advertiser');
    Route::get('show-offers/{id}', function($id) {
        return view('admin.show-offers', ['id' => $id]);
    })->name('admin.show-offers');

Route::get('show-docs/{id}', function($id) {
        return view('admin.show-docs', ['id' => $id]);
    })->name('admin.show-docs');
});


