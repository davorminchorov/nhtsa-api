<?php

namespace App\Repositories;


use App\Interfaces\VehicleRepository;
use GuzzleHttp\Client;
use Illuminate\Support\Collection;

class GuzzleVehicleRepository implements VehicleRepository
{
    /**
     * @var Client
     */
    private $guzzleClient;

    /**
     * GuzzleVehicleRepository constructor.
     * @param Client $guzzleClient
     */
    public function __construct(Client $guzzleClient)
    {
        $this->guzzleClient = $guzzleClient;
    }

    /**
     * Get a collection of vehicles by different filters.
     *
     * @param Collection $filters
     * @return Collection
     */
    public function getVehicles(Collection $filters): Collection
    {
        $vehicles = $this->guzzleClient->get("https://one.nhtsa.gov/webapi/api/SafetyRatings/modelyear/{$filters->get('modelYear')}/make/{$filters->get('manufacturer')}/model/{$filters->get('model')}?format=json");

        return collect(json_decode($vehicles->getBody(), true));
    }
}