<?php

require_once __DIR__ . '/Entity/Ship.php';

function printShipSummary(Ship $someShip)
{
    echo 'Ship Name: '.$someShip->getName();
    echo '<hr/>';
    $someShip->sayHello();
    echo '<hr/>';
    echo $someShip->getNameAndSpecs(false);
    echo '<hr/>';
    echo $someShip->getNameAndSpecs(true);
}

// but it doesn't do anything yet...
$myShip = new Ship('TIE Fighter');
$myShip->setWeaponPower(10);


printShipSummary($myShip);

$otherShip = new Ship('Imperial Shuttle');
$otherShip->setWeaponPower(5)
        ->setStrength(50);

echo '<hr/>';
printShipSummary($otherShip);
echo '<hr/>';

if ($myShip->doesGivenShipHaveMoreStrength($otherShip)) {
    echo $otherShip->getName().' has more strength';
} else {
    echo $myShip->getName().' has more strength';
}
