<?php

use Inertia\Inertia;
use Laravel\Fortify\Features;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MunicipioController;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canRegister' => Features::enabled(Features::registration()),
    ]);
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__ . '/settings.php';


route::resource('/estados', StateController::class)->parameters([
    'estados' => 'state',
]);

route::resource('/municipios', MunicipioController::class);

route::resource('/categorias', CategoryController::class)->parameters(['categorias' => 'category']);

route::resource('/planes',PlanController::class)->parameters(['planes' => 'plan']);

route::resource('/anuncios',PostController::class)->parameters(['anuncios' => 'post']);

Route::get('/anuncios/{post}/pagar', [PaymentController::class, 'pagar'])
    ->name('anuncios.pagar');

route::post('process-payment',[PaymentController::class,'processPayment'])->name('process.payment');