<?php

namespace App\Interfaces;

use Illuminate\Support\Collection;

interface VehicleRepository
{
    /**
     * Get a collection of vehicles by different filters.
     *
     * @param Collection $filters
     * @return Collection
     */
    public function getVehicles(Collection $filters) : Collection;
}