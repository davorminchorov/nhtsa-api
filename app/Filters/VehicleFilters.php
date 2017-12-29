<?php

namespace App\Filters;

use App\Interfaces\VehicleRepository;
use Illuminate\Support\Collection;

class VehicleFilters
{
    /**
     * @var VehicleRepository
     */
    private $vehicleRepository;

    /**
     * VehicleFilters constructor.
     * @param VehicleRepository $vehicleRepository
     */
    public function __construct(VehicleRepository $vehicleRepository)
    {
        $this->vehicleRepository = $vehicleRepository;
    }

    /**
     * Get a list of vehicles by specific model year, manufacturer and model with or without overall rating.
     *
     * @param Collection $filters
     * @param bool $withRating
     *
     * @return Collection
     */
    public function getVehicles(Collection $filters, bool $withRating = false) : Collection
    {
        $vehicles = $this->vehicleRepository->getVehicles($filters);

        if ($withRating) {

            if (! array_get(array_first($vehicles->get('Results')), 'VehicleDescription')) {
                return $vehicles;
            }
            $vehiclesCollection = collect($vehicles->get('Results'));

            $crashRatings = $vehiclesCollection->map(function ($vehicle) {
                $vehicle = $this->vehicleRepository->findById($vehicle['VehicleId']);

                return [
                    'CrashRating' => array_get(array_first($vehicle->get('Results')), 'OverallRating')
                ];
            })->all();

            return $vehicles->merge([
                'CrashRatings' => $crashRatings
            ]);

        }

        return $vehicles;
    }
}