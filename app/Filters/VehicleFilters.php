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
    public function getVehicles(Collection $filters, bool $withRating = false): Collection
    {
        $vehicles = $this->vehicleRepository->getVehicles($filters);

        return $withRating ? $this->getVehiclesWithCrashRating($vehicles) : $vehicles;
    }

    /**
     * Get the crash rating for each vehicle and include it in the results.
     *
     * @param $vehicles
     * @return mixed
     */
    private function getVehiclesWithCrashRating($vehicles) : Collection
    {
        return $this->vehicleDescriptionIsMissing($vehicles) ? $vehicles : $this->getCrashRatingForEachVehicle($vehicles);
    }

    /**
     * Check if the vehicle description is missing from the results.
     *
     * @param $vehicles
     * @return bool
     */
    private function vehicleDescriptionIsMissing($vehicles): bool
    {
        return !array_get(array_first($vehicles->get('Results')), 'VehicleDescription');
    }

    /**
     * Get the crash rating for each vehicle ID.
     *
     * @param $vehicles
     * @return mixed
     */
    private function getCrashRatingForEachVehicle(Collection $vehicles) : Collection
    {
        $crashRatings = collect($vehicles->get('Results'))->map(function ($vehicle) {
            $vehicle = $this->vehicleRepository->findById(array_get($vehicle, 'VehicleId'));

            return [
                'CrashRating' => $this->getOverallRatingForVehicle($vehicle)
            ];
        })->all();

        return $vehicles->merge([
            'CrashRatings' => $crashRatings
        ]);
    }

    /**
     * Gets the overall rating value from the vehicle data.
     *
     * @param $vehicle
     * @return mixed
     */
    function getOverallRatingForVehicle($vehicle): string
    {
        return array_get(array_first($vehicle->get('Results')), 'OverallRating');
    }
}