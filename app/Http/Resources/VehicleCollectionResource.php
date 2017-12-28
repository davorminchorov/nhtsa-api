<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class VehicleCollectionResource extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        if (! $this->get('Count')) {
            return [
                'Count' => 0,
                'Results' => [],
            ];
        }

        return [
            'Count' => $this->get('Count'),
            'Results' => collect($this->get('Results'))->map(function ($vehicle) {
                return [
                    'Description' => $vehicle['VehicleDescription'],
                    'VehicleId' => $vehicle['VehicleId'],
                ];
            }),
        ];
    }
}
