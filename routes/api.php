<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VehicleController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get("/get-vehicles/{vehicle_id?}", [VehicleController::class, 'getVehicles'])->name('vehicles.get');
Route::post("/add-vehicle", [VehicleController::class, 'createVehicle'])->name('vehicles.add');
Route::patch("/update-vehicle", [VehicleController::class, 'updateVehicle'])->name('vehicles.update');
Route::delete("/delete-vehicle", [VehicleController::class, 'deleteVehicle'])->name('vehicles.delete');
