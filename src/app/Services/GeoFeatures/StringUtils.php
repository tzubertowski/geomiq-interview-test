<?php


namespace App\Services\GeoFeatures;


class StringUtils
{
    /**
     * Sanitizes the input string by unifying delimiters
     *
     * @param string $inputString
     * @return string
     */
    public static function sanitizeInputString(string $inputString): string
    {
        $inputString = str_replace(' ', '', $inputString);
        $inputString = preg_replace("![^a-z0-9_.]+!i", "-", $inputString);
        return $inputString;
    }

    /**
     * Gets coerced value from a string, eg. "0" returns 0 as an integer
     *
     * @param string $initialValue
     * @return bool|float|int|string
     */
    public static function getCoercedValue(string $initialValue)
    {
        $initialValue = trim($initialValue);
        if (empty($initialValue)) {
            return 0;
        }

        if (!preg_match("/[^0-9.]+/", $initialValue)) {
            if (preg_match("/[.]+/", $initialValue)) {
                $double = (double)$initialValue;
                return round($double, 6);
            }
            return (int)$initialValue;
        }

        return (string)$initialValue;
    }
}