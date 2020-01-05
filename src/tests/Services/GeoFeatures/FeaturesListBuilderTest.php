<?php


namespace Tests\Services\GeoFeatures;


use App\Services\GeoFeatures\DTO\FeaturesList;
use App\Services\GeoFeatures\FeaturesListBuilder;
use Tests\TestCase;

class FeaturesListBuilderTest extends TestCase
{
    public function testReturnsFeaturesListForNonEmptyString(): void
    {
        $featuresList = FeaturesListBuilder::build('feature');
        $this->assertInstanceOf(FeaturesList::class, $featuresList);
    }

    public function testThrowsInvalidArgumentExceptionForEmptyInputString(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        FeaturesListBuilder::build('');
    }

    public function testSerialisesExampleTaskString()
    {
        $taskString = "elapsed_time=0.0022132396697998047, type-CNC,radius-1-15,position-1=0.000000000000014,position-1//90,position-2=0%direction-1=-2.0816681711721685e-16";
        $output = FeaturesListBuilder::build($taskString);
        $expectedArray = [
            'data' => [
                'elapsed_time' => 0.002213,
                'type' => 'CNC',
                'feature_count' => 2,
                'features' => [],
            ]
        ];
        $expectedArray['features'][1] = [
            'id' => '1',
            'radius' => 15,
            'position' => [
                0.0,
                90
            ],
            'direction' => '2.0816681711721685e-16',
        ];
        $expectedArray['features'][2] = [
            'id' => '2',
            'position' => 0
        ];
        $this->assertSame($expectedArray, $output->toArray());
    }
}