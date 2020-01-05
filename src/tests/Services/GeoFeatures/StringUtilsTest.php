<?php


namespace Tests\Services\GeoFeatures;


use App\Services\GeoFeatures\StringUtils;
use Tests\TestCase;

class StringUtilsTest extends TestCase
{
    /**
     * @dataProvider provideCoerceData
     * @param $input
     * @param $expectedOutput
     */
    public function testGetsCoercedValue($input, $expectedOutput)
    {
        $this->assertEquals($expectedOutput, StringUtils::getCoercedValue($input));
    }

    public function provideCoerceData(): array
    {
        return [
            ['1', 1],
            ['a', 'a'],
            ['', 0],
            ['0.1', 0.1],
            ['0.1231231', 0.123123],
        ];
    }

    /**
     * @dataProvider provideSanitizationData
     * @param string $input
     * @param string $expectedOutput
     */
    public function testSanitizesInputString(string $input, string $expectedOutput): void
    {
        $this->assertEquals($expectedOutput, StringUtils::sanitizeInputString($input));
    }

    public function provideSanitizationData(): array
    {
        return [
            ['foobar', 'foobar'],
            ['foo%', 'foo;'],
            ['foo-', 'foo;'],
            ['foo-1.23', 'foo;1.23'],
            ['foo=1.23', 'foo;1.23'],
            ['foo_bar=bar', 'foo_bar;bar'],
            ['foo_bar=1.23,ke-1=21', 'foo_bar;1.23;ke;1;21'],
            ['true', 'true']
        ];
    }
}