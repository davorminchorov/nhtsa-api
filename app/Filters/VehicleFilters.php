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
     * Get vehicles by different filters.
     *
     * @param Collection $filters
     * @return Collection
     */
    public function getVehicles(Collection $filters) : Collection
    {
        return $this->vehicleRepository->getVehicles($filters);
    }
}