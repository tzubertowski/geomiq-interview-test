<?php


namespace App\Console\Commands;


use Illuminate\Console\Command;

class MapFeaturesString extends Command
{
    protected $signature = 'features:map-to-json';
    protected $description = 'Parses strings of features and maps it into a JSON string';

    public function handle()
    {
        $this->info('Parsing input features string');
    }
}