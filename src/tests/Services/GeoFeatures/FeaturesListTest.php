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
        $this->assertArrayHasKey('data', $serialisedList);
        $this->assertArrayHasKey('features', $serialisedList['data']);
        $this->assertArrayHasKey('length', $serialisedList['data']);
        $this->assertCount(1, $serialisedList['data']['features']);
    }

    public function testCanAddEmptyFeatureValue()
    {
        $sut = new FeaturesList();
        $this->assertTrue($sut->addValueToFeature(new FeatureValue()));
    }
}