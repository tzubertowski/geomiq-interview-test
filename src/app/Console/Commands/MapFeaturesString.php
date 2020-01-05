<?php


namespace App\Console\Commands;


use Illuminate\Console\Command;
use App\Services\GeoFeatures\FeaturesListBuilder;

class MapFeaturesString extends Command
{
    protected $signature = 'features:map-to-json {input_string}';
    protected $description = 'Parses strings of features and maps it into a JSON string';

    public function handle()
    {
        $stringToMap = $this->argument('input_string');
        $featuresList = FeaturesListBuilder::build($stringToMap);
        $this->info(json_encode($featuresList->toArray()));
    }
}