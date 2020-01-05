<?php


namespace App\Services\GeoFeatures\DTO;


use Illuminate\Support\Collection;

class FeaturesList
{
    /** @var Collection[Feature] */
    public $features;
    /** @var int|null */
    public $elapsedTime;
    /** @var string|null */
    public $type;

    public function __construct()
    {
        $this->features = new Collection();
    }

    public function toArray()
    {
        return [
            'data' => [
                'features' => $this->features->toArray(),
                'elapsed_time' => $this->elapsedTime,
                'type' => $this->type,
                'feature_count' => $this->features->count(),
            ]
        ];
    }
}