<?php

namespace App\Services\GeoFeatures;

use App\Services\GeoFeatures\DTO\FeaturesList;
use App\Services\GeoFeatures\DTO\FeatureValue;
use Illuminate\Support\Collection;

class FeaturesListBuilder
{
    public static function build(string $inputString)
    {
        if ($inputString === '') {
            throw new \InvalidArgumentException('Can only parse non-empty strings');
        }
        $inputString = StringUtils::sanitizeInputString($inputString);
        $inputData = array_map(function ($element) {
            return StringUtils::getCoercedValue($element);
        }, explode(';', $inputString));

        $featuresPartials = self::parseInputDataIntoPartials($inputData);
        return self::buildFeaturesList($featuresPartials);
    }

    private static function parseInputDataIntoPartials(array $inputData)
    {
        $featuresValues = new Collection();
        while (true) {
            $featureValue = self::getFeatureValue($inputData);
            $featuresValues->add($featureValue);
            if (empty($inputData)) {
                break;
            }
        }
        return $featuresValues;
    }

    private static function getFeatureValue(array &$inputData): FeatureValue
    {
        $featureValue = new FeatureValue();
        foreach ($inputData as $key => $value) {
            if (!$featureValue->getFeatureName()) {
                $featureValue->featureName = $value;
                unset($inputData[$key]);
                continue;
            }
            if (is_string($value) && $featureValue->featureData) {
                // We do nothing, as this is another feature name and not a value
                break;
            }
            $featureValue->featureData[] = $value;
            unset($inputData[$key]);
        }
        return $featureValue;
    }

    private static function buildFeaturesList(Collection $featuresPartials): FeaturesList
    {
        $featuresList = new FeaturesList();
        $featuresPartials->each(static function (FeatureValue $featureValue) use (&$featuresList) {
            $featuresList->addValueToFeature($featureValue);
        });
        return $featuresList;
    }

}

