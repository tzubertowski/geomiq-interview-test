<?php

namespace Tests\Console\Commands;

use App\Console\Commands\MapFeaturesString;
use Tests\ConsoleTestCase;

class MapFeaturesStringTest extends ConsoleTestCase
{
    /**
     * System under test
     * @var MapFeaturesString
     */
    private $sut;

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->sut = app(MapFeaturesString::class);
    }

    public function testCommandIsCallable(): void
    {
        $this->assertEquals(0, $this->artisan('features:map-to-json', ['input_string' => 'foo=bar']));
    }

    public function testCommandReturnsOutput(): void
    {
        $sutOutput = $this->runCommand($this->sut, ['input_string' => 'foo-bar']);
        $this->assertJson($sutOutput->getDisplay());
    }
}