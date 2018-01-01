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
        if (!$this->get('Count') || !array_get(array_first($this->get('Results')), 'VehicleDescription')) {
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

                if ($this->get('CrashRatings')) {
                    return array_merge($results, [
                        'CrashRating' => array_first(array_flatten(array_get($this->get('CrashRatings'), $index))),
                    ]);
                }

                return $results;
            }),
        ];
    }
}
