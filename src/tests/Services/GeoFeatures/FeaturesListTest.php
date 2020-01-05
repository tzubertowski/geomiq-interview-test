<?php


namespace Tests\Services\GeoFeatures;


use App\Services\GeoFeatures\DTO\FeaturesList;
use App\Services\GeoFeatures\DTO\FeatureValue;
use Tests\TestCase;

class FeaturesListTest extends TestCase
{
    public function testCountsEmbeddedFeatures()
    {
        $sut = new FeaturesList();
        $embeddedFeatureValue = new FeatureValue();
        $embeddedFeatureValue->featureData = [1, 'foobar'];
        $sut->addValueToFeature($embeddedFeatureValue);
        $this->assertEquals(1, $sut->getEmbeddedFeatureCount());
    }


    public function testSerialisesToMultidimensionalArray()
    {
        $sut = new FeaturesList();
        $embeddedFeatureValue = new FeatureValue();
        $embeddedFeatureValue->featureName = 'bar';
        $embeddedFeatureValue->featureData = [1, 'foobar'];
        $featureValue = new FeatureValue();
        $featureValue->featureData = ['foobar'];
        $featureValue->featureName = 'length';
        $sut->addValueToFeature($embeddedFeatureValue);
        $sut->addValueToFeature($featureValue);

        $serialisedList = $sut->toArray();
        $this->assertArrayHasKey('features', $serialisedList);
        $this->assertArrayHasKey('length', $serialisedList);
        $this->assertCount(1, $serialisedList['features']);
    }

    public function testCanAddEmptyFeatureValue()
    {
        $sut = new FeaturesList();
        $this->assertTrue($sut->addValueToFeature(new FeatureValue()));
    }
}