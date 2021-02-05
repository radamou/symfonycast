<?php

namespace App;

use App\Internal\DependencyInjection\Container;
$container = new Container([]);
$shipsLoader = $container->getShipLoader();

use Symfony\Component\HttpFoundation\Request;

$request = Request::createFromGlobals();

$ship1Id = $request->query->get('ship1_id', 1);
$ship1Quantity = $request->query->get('ship1_quantity',1);
$ship2Id = $request->query->get('ship2_id', 2);
$ship2Quantity = $request->query->get('ship2_quantity',1);
$battleType = $request->query->get('battle_type', 1);

if (!$ship1Id || !$ship2Id) {
    header('Location: /home?error=missing_data');
    die;
}

$ship1 = $shipsLoader->fetchOne($ship1Id);
$ship2 = $shipsLoader->fetchOne($ship2Id);


if (!$ship1 || !$ship2) {
    header('Location: /home?error=bad_ships');
    die;
}

if ($ship1Quantity <= 0 || $ship2Quantity <= 0) {
    header('Location: /home?error=bad_quantities');
    die;
}

$battleManager = $container->getBattleManager();
$battleResult = $battleManager->battle($ship1, $ship1Quantity, $ship2, $ship2Quantity, $battleType);

?>

<?php require __DIR__ . '/header.html' ?>

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
    <a href="/home"><p class="text-center"><i class="fa fa-undo"></i> Battle again</p></a>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="../public/js/bootstrap.min.js"></script>
</div>
</body>
</html>
