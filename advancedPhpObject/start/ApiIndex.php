<?php

require_once __DIR__.'/vendor/autoload.php';

use App\Api\CollectEggs;

$collectEggs = new CollectEggs();

echo $collectEggs->postEggs();

