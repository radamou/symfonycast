<?php

namespace App\Internal\Storage;

interface LoaderInterface
{
    public function fetchAllData(): array ;
    public function fetchSingleData(int $id): array;
}
