<?php

namespace App;

require_once __DIR__.'/config/Bootstrap.php';

use App\Internal\DependencyInjection\Container;
$container = new Container([]);
$shipsLoader = $container->getShipLoader();

$ship1Id = isset($_POST['ship1_id']) ?? null;
$ship1Quantity = isset($_POST['ship1_quantity']) ? $_POST['ship1_quantity'] : 1;
$ship2Id = isset($_POST['ship2_id']) ?? null;
$ship2Quantity = isset($_POST['ship2_quantity']) ? $_POST['ship2_quantity'] : 1;
$battleType = isset($_POST['battle_tyype']) ?? null;

if (!$ship1Id || !$ship2Id) {
    header('Location: /index.php?error=missing_data');
    die;
}

$ship1 = $shipsLoader->fetchOne($ship1Id);
$ship2 = $shipsLoader->fetchOne($ship2Id);

if (!$ship1 || !$ship2) {
    header('Location: /index.php?error=bad_ships');
    die;
}

if ($ship1Quantity <= 0 || $ship2Quantity <= 0) {
    header('Location: /index.php?error=bad_quantities');
    die;
}

$battleManager = $container->getBattleManager();
$battleResult = $battleManager->battle($ship1, $ship1Quantity, $ship2, $ship2Quantity, $battleType);

?>

<?php require __DIR__.'/templates/header.html'?>

<body>
<div class="container">
    <div class="page-header">
        <h1>OO Battleships of Space</h1>
    </div>
    <div>
        <h2 class="text-center">The Matchup:</h2>
        <p class="text-center">
            <br>
            <?php echo $ship1Quantity; ?>
            <?php echo $ship1->getName(); ?>
            <?php echo $ship1Quantity > 1 ? 's': ''; ?>
            VS.
            <?php echo $ship2Quantity; ?>
            <?php echo $ship2->getName(); ?>
            <?php echo $ship2Quantity > 1 ? 's': ''; ?>
        </p>
    </div>
    <div class="result-box center-block">
        <h3 class="text-center audiowide">
            Winner:
            <?php if ($battleResult->isThereAWinner()): ?>
                <?php echo $battleResult->getWinningShip()->getName(); ?>
            <?php else: ?>
                Nobody
            <?php endif; ?>
        </h3>
        <p class="text-center">
            <?php if (!$battleResult->isThereAWinner()): ?>
                Both ships destroyed each other in an epic battle to the end.
            <?php else: ?>
                The <?php echo $battleResult->getWinningShip()->getName(); ?>
                <?php if ($battleResult->getUseJediPowers()): ?>
                    used its Jedi Powers for a stunning victory!
                <?php else: ?>
                    overpowered and destroyed the <?php echo $battleResult->getLosingShip()->getName() ?>s
                <?php endif; ?>
            <?php endif; ?>
        </p>
    </div>
    <a href="./index.php"><p class="text-center"><i class="fa fa-undo"></i> Battle again</p></a>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="public/js/bootstrap.min.js"></script>
</div>
</body>
</html>
