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
        // this validates the inputs from the requests to create a vehicle
        $request->validate(
            [
                'maker' => ['required', 'string', 'max:255'],
                'model' => ['required', 'string', 'max:255'],
                'license_plate' => ['required', 'string', 'max:255', 'unique:vehicles'],
                'year' => ['required', 'digits_between:1, 2021'],
            ]
        );
        $vehicle_id = utf8_encode(Uuid::generate());

        // here we are creating a new vehicle instance
        $vehicle = new Vehicle;
        $vehicle->vehicle_id = $vehicle_id;
        $vehicle->maker = $request->maker;
        $vehicle->model = $request->model;
        $vehicle->year = $request->year;
        $vehicle->license_plate = $request->license_plate;

        // vehicle is being saved here
        $vehicle->save();

        // a json response is returned with message and vehicle data
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

        // the if statement below checks if the the vehicle_id is given
        // if it is not null we want to get a single vehicle of that vehicle_id
        if ($vehicle_id) {

            // here we are getting a vehicle with the vehicle_id given
            $vehicle = Vehicle::where('vehicle_id', $vehicle_id)->first();

            // here we are cheking if a vehicle with that id exist if not we want to return 404 not found error
            if (!$vehicle) {
                return response(['error' => 'Not found'], 404);
            }

            // here we have confirmed that the vehicle exists to we want to return the vehicle
            return response(
                [ 'vehicle' => $vehicle ],
                200
            );
        } else {
        // if it is null we want to get all vehicles
            $vehicles = Vehicle::get();

            // and we want to return a json response of all the vehicles
            return response(
                [ 'vehicles' => $vehicles ],
                200
            );
        }
    }

    public function updateVehicle(Request $request)
    {

        // here we are getting a vehicle with the vehicle_id given in the request
        $vehicle = Vehicle::where('vehicle_id', '=', $request->vehicle_id)->first();

        // here we are cheking if a vehicle with that id exist if not we want to return 404 not found error
        if (!$vehicle) {
            return response(['error' => 'Not found'], 404);
        }

        // if the vehicle exist we want to validate our requests data
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

        // here we are saving the data with data given 
        $vehicle->save();

        // Here we are returning the json response of the vehicle
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
        // This gets a vehicle with the vehicle_id given
        $vehicle = Vehicle::where('vehicle_id', '=', $vehicle_id)->first();

        // This checks if a vehicle with that id exists, if not we want to return 404 not found error
        if (!$vehicle) {
            return response(['error' => 'Not found'], 404);
        }

        // this deletes the vehicle record
        $vehicle->delete();

        // this returns a message that the vehicle has been deleted
        return response(
            [
                'message' => "Vehicle deleted"
            ],
            200
        );
    }
}
