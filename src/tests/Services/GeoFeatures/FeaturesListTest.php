<?php


namespace Tests\Services\GeoFeatures;


use App\Services\GeoFeatures\DTO\FeaturesList;
use Illuminate\Support\Collection;
use Tests\TestCase;

class FeaturesListTest extends TestCase
{
    public function testSerialisesToDesiredArray()
    {
        $sut = new FeaturesList();
        $serialisedFeaturesList = $sut->toArray();
        $this->assertArrayHasKey('data', $serialisedFeaturesList);
        $serialisedData = $serialisedFeaturesList['data'];
        $this->assertArrayHasKey('features', $serialisedData);
        $this->assertArrayHasKey('elapsed_time', $serialisedData);
        $this->assertArrayHasKey('type', $serialisedData);
        $this->assertArrayHasKey('feature_count', $serialisedData);
    }

    /**
     * @dataProvider provideFeatures
     */
    public function testFeatureCountComputedForTheList($features, $expectedCount)
    {
        $sut = new FeaturesList();
        $sut->features = new Collection($features);
        $this->assertEquals($expectedCount, $sut->toArray()['data']['feature_count']);
    }

    public function provideFeatures()
    {
        return [
            [[1, 2, 3], 3],
            [[], 0],
            [[1], 1],
        ];
    }

}