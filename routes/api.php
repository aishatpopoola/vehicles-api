<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VehicleController;

// this route gets a list of vehicles and single vehicle using the getVehicle method of the vehicle controller
Route::get("/get-vehicles/{vehicle_id?}", [VehicleController::class, 'getVehicles'])->name('vehicles.get');

// this route adds a vehicle using the createVehicle method of the vehicle controller
Route::post("/add-vehicle", [VehicleController::class, 'createVehicle'])->name('vehicles.add');

// this route updates a vehicle using the updateVehicle method of the vehicle controller
Route::patch("/update-vehicle", [VehicleController::class, 'updateVehicle'])->name('vehicles.update');

// this route deletes a vehicle using the deleteVehicle method of the vehicle controller
Route::delete("/delete-vehicle/{vehicle_id}", [VehicleController::class, 'deleteVehicle'])->name('vehicles.delete');
