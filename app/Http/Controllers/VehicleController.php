<?php

namespace App\Http\Controllers;

use App\Filters\VehicleFilters;
use App\Http\Resources\VehicleCollectionResource;
use App\Http\Transformers\VehicleTransformer;
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
     * Show a list of vehicles by specific model year, manufacturer and model.
     *
     * @param Request $request
     * @param $modelYear
     * @param $manufacturer
     * @param $model
     *
     * @return VehicleCollectionResource
     */
    public function index(Request $request, $modelYear, $manufacturer, $model)
    {
        $vehicles = $this->vehicleFilters->getVehicles(collect([
            'modelYear' => $modelYear,
            'manufacturer' => $manufacturer,
            'model' => $model,
        ]));

        return new VehicleCollectionResource($vehicles);
    }
}
