<?php

namespace OwowAgency\LaravelResources\Tests\Support\Snapshots\Drivers;

use PHPUnit\Framework\Assert;
use Spatie\Snapshots\Drivers\JsonDriver;

class JsonStructureDriver extends JsonDriver
{
    /**
     * Override the match method to compare the JSON structures.
     *
     * @param  string  $expected
     * @param  mixed  $actual
     * @return void
     */
    public function match($expected, $actual): void
    {
        if (is_array($actual)) {
            $actual = json_encode($actual, JSON_PRETTY_PRINT).PHP_EOL;
        }

        $this->assertEqualJsonStructure($expected, $actual);
    }

    /**
     * Assert that the actual JSON structure matches the expected.
     *
     * @param  string  $expected
     * @param  string  $actual
     * @return void
     */
    public function assertEqualJsonStructure(string $expected, string $actual): void
    {
        $expected = json_decode($expected, true);

        $actual = json_decode($actual, true);

        Assert::assertEquals(
            $this->arrayGetFormat($expected),
            $this->arrayGetFormat($actual),
        );
    }

    /**
     * Return the attributes and types of a given array.
     *
     * @param  array  $array
     * @return array
     */
    public function arrayGetFormat(array $array): array
    {
        $function = function (&$value, $key) {
            if (!is_array($value)) {
                if (
                    preg_match("/(?<![a-zA-Z])id(?![a-zA-Z])/", $key)
                    && is_numeric($value)
                ) {
                    // If the attribute is an id, don't alter $value

                } elseif (preg_match("/\d{4}-\d{2}-\d{2}/", $value)) {
                    // If the attribute is a date or datetime, get its date format
                    
                    $value = preg_replace("/\d/", "X", $value);
                } else {
                    // Else, the attribute is a simple variable, get its type

                    $value = gettype($value);
                }
            }
        };

        array_walk_recursive($array, $function);

        return $array;
    }
}
