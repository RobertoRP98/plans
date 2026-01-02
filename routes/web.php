<?php

use Inertia\Inertia;
use Laravel\Fortify\Features;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MunicipioController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PostClientController;
use App\Http\Controllers\PostPublicController;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canRegister' => Features::enabled(Features::registration()),
    ]);
})->name('home');

// Route::get('anuncios', function () {
//     return Inertia::render('Client/Index');
// })->middleware(['auth', 'verified'])->name('mis-anuncios');

require __DIR__ . '/settings.php';

//INICIAN RUTAS DE ADMINISTRACION DE USUARIOS, ROLES Y PERMISOS - SOLO SE ACCEDE CON ROLE DEVELOPER

Route::group(['middleware' => ['auth', 'role:Developer']], function () {
    Route::resource('users', UserController::class);
    Route::resource('permissions', PermissionController::class);
    Route::resource('roles', RoleController::class);
    Route::get('roles/{roleId}/give-permissions', [RoleController::class, 'addPermissionToRole']);
    Route::patch('roles/{roleId}/give-permissions', [RoleController::class, 'givePermissionToRole']);

    Route::get('/anuncios', [PostController::class, 'index'])
        ->name('anuncios.index');
});
//TERMINAN RUTAS DE ADMINISTRACION DE USUARIOS, ROLES Y PERMISOS

//RUTAS EXCLUSIVAS PARA DEVELOPERS
Route::group(['middleware' => ['auth', 'role:Developer']], function () {

    route::resource('/estados', StateController::class)->parameters([
        'estados' => 'state',
    ]);

    route::resource('/municipios', MunicipioController::class);

    route::resource('/categorias', CategoryController::class)->parameters(['categorias' => 'category']);

    route::resource('/planes', PlanController::class)->parameters(['planes' => 'plan']);
});
//Rutas exclusivas para developers

//RUTAS PUBLICAS PARA ANUNCIOS / SOLICITANTES
Route::get(
    '/solicitantes/{state}/{category?}/{municipio?}/{search?}',
    [PostPublicController::class, 'indexPublic']
)->name('index.public');


Route::get('/solicitantes', [PostPublicController::class, 'solicitantes'])->name('solicitantes');
route::get('/solicitante/{post}', [PostPublicController::class, 'showPublic'])->name('solicitante.public');
//RUTAS PUBLICAS PARA ANUNCIOS / SOLICITANTES

//RUTAS AUTENTICADAS PARA CREACION Y GESTION DE ANUNCIOS
Route::middleware('auth')->group(function () {

    Route::get('/anuncios/{post}', [PostController::class, 'show'])
        ->name('anuncios.show');

    Route::post('/anuncios', [PostController::class, 'store'])
        ->name('anuncios.store');

    Route::get('/anuncios/{post}/edit', [PostController::class, 'edit'])
        ->name('anuncios.edit');

    Route::patch('/anuncios/{post}', [PostController::class, 'update'])
        ->name('anuncios.update');

    Route::get('/anuncios/{post}/pagar', [PaymentController::class, 'pagar'])
        ->name('anuncios.pagar');

    route::post('process-payment', [PaymentController::class, 'processPayment'])->name('process.payment');

    route::get('/muchas-gracias', [PaymentController::class, 'thanks'])->name('thanks');

    route::get('mis-anuncios', [PostClientController::class, 'misAnuncios'])->name('mis.anuncios');

    Route::post('/anuncios/{post}/premium', [PostClientController::class, 'selectPlan'])
        ->name('anuncios.premium.select');

    Route::get('/anuncios/{post}/premium', [PostClientController::class, 'showPlans'])
        ->name('posts.premium');
});

//RUTAS AUTENTICADAS PARA CREACION Y GESTION DE ANUNCIOS
