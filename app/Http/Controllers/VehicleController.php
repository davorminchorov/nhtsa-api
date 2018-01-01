<?php

namespace App\Http\Controllers;

use App\Filters\VehicleFilters;
use App\Http\Requests\CreateNewVehicleRequest;
use App\Http\Resources\VehicleCollectionResource;
use App\Http\Resources\VehicleResource;
use App\Http\Transformers\VehicleTransformer;
use App\Services\VehicleCreator;
use Illuminate\Http\Request;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;

class VehicleController extends Controller
{

    /**
     * @var VehicleFilters
     */
    private $vehicleFilters;

    /**
     * VehicleController constructor.
     * @param VehicleFilters $vehicleFilters
     */
    public function __construct(VehicleFilters $vehicleFilters)
    {
        $this->vehicleFilters = $vehicleFilters;
    }

    /**
     * Show a list of vehicles by specific model year, manufacturer and model with or without overall rating.
     *
     * @param Request $request
     * @param $modelYear
     * @param $manufacturer
     * @param $model
     *
     * @return VehicleCollectionResource
     */
    public function index(Request $request, $modelYear = null, $manufacturer = null, $model = null)
    {
        $vehicles = $this->vehicleFilters->getVehicles(collect(
            array_merge([
                'modelYear' => (int)$modelYear,
                'manufacturer' => $manufacturer,
                'model' => $model,
            ], $request->only(['modelYear', 'manufacturer', 'model']))
        ), $request->get('withRating') === 'true');

        return new VehicleCollectionResource($vehicles);
    }
}
