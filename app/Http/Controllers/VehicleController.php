<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Webpatser\Uuid\Uuid;
use App\Models\Vehicle;

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
        $vehicle_id = utf8_encode(Uuid::generate());
        $vehicle = new Vehicle;
        $vehicle->vehicle_id = $vehicle_id;
        $vehicle->maker = $request->maker;
        $vehicle->model = $request->model;
        $vehicle->year = $request->year;
        $vehicle->license_plate = $request->license_plate;
        $vehicle->save();
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
                [ 'vehicles' => $vehicles ],
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

    public function deleteVehicle($vehicle_id)
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
