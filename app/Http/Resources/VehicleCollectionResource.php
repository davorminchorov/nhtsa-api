<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class VehicleCollectionResource extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        if ($this->countIsZeroOrVehicleDescriptionIsMissing()) {
            return [
                'Count' => 0,
                'Results' => [],
            ];
        }

        return [
            'Count' => $this->get('Count'),
            'Results' => collect($this->get('Results'))->map(function ($vehicle, $index) {
                $results = [
                    'Description' => array_get($vehicle, 'VehicleDescription'),
                    'VehicleId' => array_get($vehicle, 'VehicleId'),
                ];

                return $this->withCrashRatings() ? $this->includeCrashRating($results, $index) : $results;
            }),
        ];
    }

    /**
     * Check for invalid request data.
     *
     * @return bool
     */
    private function countIsZeroOrVehicleDescriptionIsMissing(): bool
    {
        return !$this->get('Count') || !array_get(array_first($this->get('Results')), 'VehicleDescription');
    }


    /**
     * Get the crash rating for each vehicle.
     *
     * @param $index
     * @return mixed
     */
    function getCrashRating($index): string
    {
        return array_first(array_flatten(array_get($this->get('CrashRatings'), $index)));
    }

    /**
     * Include crash rating for each vehicle.
     *
     * @param $results
     * @param $index
     * @return array
     */
    public function includeCrashRating($results, $index) : array
    {
        return array_merge($results, [
            'CrashRating' => $this->getCrashRating($index),
        ]);
    }

    /**
     * Check to see if crash ratings are included in the collection.
     *
     * @return mixed
     */
    private function withCrashRatings()
    {
        return $this->get('CrashRatings');
    }
}
