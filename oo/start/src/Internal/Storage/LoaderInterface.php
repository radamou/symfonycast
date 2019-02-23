<?php

namespace App\Internal\Storage;

interface LoaderInterface
{
    public function fetchAllData();
    public function fetchSingleData(int $id);
}