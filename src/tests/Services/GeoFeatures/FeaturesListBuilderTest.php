<?php


namespace Tests\Services\GeoFeatures;


use App\Services\GeoFeatures\DTO\FeaturesList;
use App\Services\GeoFeatures\FeaturesListBuilder;
use Tests\TestCase;

class FeaturesListBuilderTest extends TestCase
{
    /**
     * System Under Test
     * @var FeaturesListBuilder
     */
    private $sut;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->sut = new FeaturesListBuilder();
    }

    public function testReturnsFeaturesListForNonEmptyString(): void
    {
        $featuresList = $this->sut->build('feature');
        $this->assertInstanceOf(FeaturesList::class, $featuresList);
    }

    public function testThrowsInvalidArgumentExceptionForEmptyInputString(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->sut->build('');
    }
}