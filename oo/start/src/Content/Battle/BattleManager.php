<?php

namespace App\Content\Battle;

use App\Entity\BattleResult;
use App\Entity\Ship;

class BattleManager
{
    public function battle(Ship $ship1, int $ship1Quantity, Ship $ship2, int $ship2Quantity): BattleResult
    {
        $ship1Health = $ship1->getStrength() * $ship1Quantity;
        $ship2Health = $ship2->getStrength() * $ship2Quantity;

        $ship1UsedJediPowers = false;
        $ship2UsedJediPowers = false;

        while ($ship1Health > 0 && $ship2Health > 0) {
            if ($this->didJediDestroyShipUsingTheForce($ship1)) {
                $ship2Health = 0;
                $ship1UsedJediPowers = true;

                break;
            }
            if ($this->didJediDestroyShipUsingTheForce($ship2)) {
                $ship1Health = 0;
                $ship2UsedJediPowers = true;

                break;
            }

            // now battle them normally
            $ship1Health = $ship1Health - ($ship2->getWeaponPower() * $ship2Quantity);
            $ship2Health = $ship2Health - ($ship1->getWeaponPower() * $ship1Quantity);
        }

        if ($ship1Health <= 0 && $ship2Health <= 0) {
            $winningShip = null;
            $losingShip = null;
            $usedJediPowers = $ship1UsedJediPowers || $ship2UsedJediPowers;
        } elseif ($ship1Health <= 0) {
            $winningShip = $ship2;
            $losingShip = $ship1;
            $usedJediPowers = $ship2UsedJediPowers;
        } else {
            $winningShip = $ship1;
            $losingShip = $ship2;
            $usedJediPowers = $ship1UsedJediPowers;
        }

        return new BattleResult(
            $winningShip, $losingShip, $usedJediPowers
        );
    }

    public function didJediDestroyShipUsingTheForce(Ship $ship)
    {
        $jediHeroProbability = $ship->getJediFactor() / 100;

        return \mt_rand(1, 100) <= ($jediHeroProbability*100);
    }
}