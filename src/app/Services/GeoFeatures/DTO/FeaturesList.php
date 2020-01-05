<?php

namespace App\Services\GeoFeatures\DTO;

class FeaturesList
{
    private $features = [];
    private $embeddedFeatures = [];

    public function addValueToFeature(FeatureValue $featureValue)
    {
        $featureName = $featureValue->getFeatureName();
        $featureData = $featureValue->getFeatureData();
        try {
            $featureId = $featureValue->getFeatureId();
            if (isset($this->embeddedFeatures[$featureId][$featureName])) {
                $this->embeddedFeatures[$featureId][$featureName] = array_merge(
                    $this->embeddedFeatures[$featureId][$featureName],
                    $featureData
                );
                return true;
            }
            $this->embeddedFeatures[$featureId]['id'] = $featureId;
            $this->embeddedFeatures[$featureId][$featureName] = $featureData;
        } catch (\LogicException $e) {
            // feature is not embedded, add to root list
            if (array_key_exists($featureName, $this->embeddedFeatures)) {
                $this->features[$featureName] = array_merge($this->features[$featureName], $featureData);
                return true;
            }
            $this->features[$featureName] = $featureData;
        }
        return true;
    }

    public function getEmbeddedFeatureCount(): int
    {
        return count($this->embeddedFeatures);
    }

    public function toArray()
    {
        $embeddedFeatures = array_map([$this, 'flattenEmbeddedFeatureValues'], $this->embeddedFeatures);
        $features = array_map([$this, 'flattenFeatureValue'], $this->features);
        return array_merge($features, [
            'features' => $embeddedFeatures,
            'feature_count' => $this->getEmbeddedFeatureCount(),
        ]);
    }

    private function flattenEmbeddedFeatureValues($feature)
    {
        foreach ($feature as $key => &$featureValue) {
            $featureValue = $this->flattenFeatureValue($featureValue);
        }
        return $feature;
    }

    private function flattenFeatureValue($featureValue)
    {
        if (is_countable($featureValue) && count($featureValue) === 1) {
            return reset($featureValue);
        }
        return $featureValue;
    }
}