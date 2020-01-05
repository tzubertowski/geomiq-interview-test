<?php


namespace App\Services\GeoFeatures\DTO\Values;


class ScientificNotation
{
    public $value;

    public function __toString()
    {
        return (string)$this->value;
    }
}