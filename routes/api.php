<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\PostController;
use App\Models\Municipio;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


route::get('planes/datos',[PlanController::class,'dataIndex'])->name('planes.data');
route::get('anuncios/datos',[PostController::class,'dataIndex'])->name('anuncios.data');


Route::get('/municipios/{state}', function ($state) {
    return Municipio::where('state_id', $state)->get();
});

Route::get('/municipiosSelect/{stateSlug}', function ($stateSlug) {
    $state = \App\Models\State::where('slug', $stateSlug)->firstOrFail();
    return \App\Models\Municipio::where('state_id', $state->id)->get();
});
