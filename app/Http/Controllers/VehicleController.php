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
                'year' => ['nullable', 'integer', 'between:1,1000'],
                'license_plate' => ['nullable', 'string', 'max:255'],
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
}
