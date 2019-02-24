<?php

namespace App\Content\FixtureLoader;

use App\Content\FixtureLoader\Exception\ReadFileException;
use App\Internal\Storage\LoaderInterface;
use Safe\Exceptions\FilesystemException;

class JsonFileLoadFixtures implements LoaderInterface
{
    private $filename;

    public function __construct($jsonFilePath)
    {
        $this->filename = $jsonFilePath;
    }

    public function fetchAllData(): array
    {
        try {
            $jsonContents = \Safe\file_get_contents($this->filename);

            return json_decode($jsonContents, true);
        } catch (FilesystemException $e) {
            throw new ReadFileException(sprintf(
                'Impossible to read this file %s',
                $e->getMessage()
            ));
        }
    }

    public function fetchSingleData(int $id): array
    {
        $ships = $this->fetchAllData();

        foreach ($ships as $ship) {
            if ($ship['id'] == $id) {
                return $ship;
            }
        }

        return [];
    }
}
