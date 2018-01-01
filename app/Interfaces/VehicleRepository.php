<?php

namespace App\Interfaces;

use Illuminate\Support\Collection;

interface VehicleRepository
{
    /**
     * Get a collection of vehicles by model year, manufacturer and model.
     *
     * @param Collection $filters
     *
     * @return Collection
     */
    public function getVehicles(Collection $filters): Collection;

    /**
     * Find a vehicle by a specific vehicle ID.
     *
     * @param int $id
     *
     * @return Collection
     */
    public function findById(int $id): Collection;
}