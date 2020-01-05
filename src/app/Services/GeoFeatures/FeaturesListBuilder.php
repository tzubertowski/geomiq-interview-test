<?php


namespace App\Services\GeoFeatures;


use App\Services\GeoFeatures\DTO\FeaturesList;

class FeaturesListBuilder
{
    public function build(string $inputString): FeaturesList
    {
        if ($inputString === '') {
            throw new \InvalidArgumentException('Can only parse non-empty strings');
        }

        return new FeaturesList();
    }
}