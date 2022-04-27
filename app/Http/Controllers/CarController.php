<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\CarResource;
use App\Car;

class CarController extends Controller
{
    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $cars = Car::all();
        return CarResource::collection($cars);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'year' => 'required|integer',
            'make' => 'required|string',
            'model' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response(['error' => $validator->errors(), 'Validation Error']);
        }


        $car = Car::create($data);
        return new CarResource($car);
    }

    /**
     *  Display the specified resource.
     * @param Car $car
     * @return CarResource
     */
    public function show(Car $car)
    {
        return new CarResource($car);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Car  $car
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $car = Car::find($id);
        $success = $car->delete();

        return ["success" => $success];
    }

    /**
     * Search for a name
     *
     * @param  str  $name
     * @return \Illuminate\Http\Response
     */
    public function search($title)
    {
        $cars = Car::where('title', 'like', '%'.$title.'%')->get();
        return CarResource::collection($cars);
    }
}
