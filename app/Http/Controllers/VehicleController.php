<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Webpatser\Uuid\Uuid;
use App\Models\Vehicle;
use Illuminate\Validation\Rule;

class VehicleController extends Controller
{
    public function createVehicle(Request $request)
    {
        $request->validate(
            [
                'maker' => ['required', 'string', 'max:255'],
                'model' => ['required', 'string', 'max:255'],
                'license_plate' => ['required', 'string', 'max:255', 'unique:vehicles'],
                'year' => ['required', 'digits_between:1, 2021'],
            ]
        );
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
        $vehicle = Vehicle::where('vehicle_id', '=', $request->vehicle_id)->first();
        if (!$vehicle) {
            return response(['error' => 'Not found'], 404);
        }
        $request->validate(
            [
                'maker' => ['required', 'string', 'max:255'],
                'model' => ['required', 'string', 'max:255'],
                'license_plate' => ['required', 'string', 'max:255', Rule::unique('vehicles')->ignore($vehicle->id)],
                'year' => ['required', 'digits_between:1, 2021'],
            ]
        );
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
