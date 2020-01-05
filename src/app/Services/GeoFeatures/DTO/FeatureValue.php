<?php


namespace App\Services\GeoFeatures\DTO;


class FeatureValue
{
    public $featureData = [];
    public $featureName;

    public function getFeatureId()
    {
        if (count($this->featureData) > 1) {
            return reset($this->featureData);
        }
        throw new \LogicException('Feature partial does not belong to embedded feature');
    }

    public function getFeatureData()
    {
        try {
            $this->getFeatureId();
            return array_slice($this->featureData, 1);
        } catch (\LogicException $e) {
            // There's no ID, return as is
            return $this->featureData;
        }
    }

    public function getFeatureName()
    {
        return $this->featureName;
    }
}