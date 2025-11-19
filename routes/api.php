<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlanController;
use App\Models\Municipio;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


route::get('planes/datos',[PlanController::class,'dataIndex'])->name('planes.data');

Route::get('/municipios/{state}', function ($state) {
    return Municipio::where('state_id', $state)->get();
});