<?php

namespace App\Content\FixtureLoader;

use App\Internal\Storage\LoaderInterface;

class JsonFileLoadFixtures implements LoaderInterface
{
    private $filename;

    public function __construct($jsonFilePath)
    {
        $this->filename = $jsonFilePath;
    }

    public function fetchAllData()
    {
        $jsonContents = file_get_contents($this->filename);

        return json_decode($jsonContents, true);
    }

    public function fetchSingleData(int $id)
    {
        $ships = $this->fetchAllData();

        foreach ($ships as $ship) {
            if ($ship['id'] == $id) {
                return $ship;
            }
        }

        return null;
    }
}
