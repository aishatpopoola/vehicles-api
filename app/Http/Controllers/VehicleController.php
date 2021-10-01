<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Webpatser\Uuid\Uuid;

class VehicleController extends Controller
{
    public function validateRequest($request)
    {
        $request->validate(
            [
                'maker' => ['required', 'string', 'max:255'],
                'model' => ['required', 'string', 'max:255'],
                'license_plate' => ['required', 'string', 'max:255'],
                'year' => ['required', 'digits_between:1, 2021'],
            ]
        );
    }

    public function createVehicle(Request $request)
    {
        $this->validateRequest($request);
        $Vehicle_id = utf8_encode(Uuid::generate());
        $Vehicle = new Vehicle;
        $Vehicle->Vehicle_id = $Vehicle_id;
        $Vehicle->maker = $request->maker;
        $Vehicle->model = $request->model;
        $Vehicle->year = $request->year;
        $Vehicle->license_plate = $request->license_plate;
        $Vehicle->save();
        return response(
            [
                'message' => "Vehicle created",
                'vehicle' => $vehicle,
            ],
            201
        );
    }

    public function getVehicles($vehicle_id = null)
    {
        if ($vehicle_id) {
            $vehicle = Vehicle::where('vehicle_id', $vehicle_id)->first();
            if (!$vehicle) {
                return response(['error' => 'Not found'], 404);
            }
            return response(
                [ 'vehicle' => $vehicle ],
                200
            );
        } else {
            $vehicles = Vehicle::get();
            return response(
                [ 'Vehicles' => $Vehicles ],
                200
            );
        }
    }

    public function updateVehicle(Request $request)
    {
        $this->validateRequest($request);
        $vehicle = Vehicle::where('vehicle_id', '=', $request->vehicle_id)->first();
        if (!$vehicle) {
            return response(['error' => 'Not found'], 404);
        }
        $vehicle->maker = $request->maker;
        $vehicle->model = $request->model;
        $vehicle->year = $request->year;
        $vehicle->license_plate = $request->license_plate;
        $vehicle->save();
        return response(
            [
                'message' => "Vehicle updated",
                'vehicle' => $vehicle,
            ],
            200
        );
    }

    public function deleteBook($vehicle_id)
    {
        $vehicle = Vehicle::where('vehicle_id', '=', $vehicle_id)->first();
        if (!$vehicle) {
            return response(['error' => 'Not found'], 404);
        }
        
        $vehicle->delete();
        return response(
            [
                'message' => "Vehicle deleted"
            ],
            200
        );
    }
}
