<?php

namespace App;

require_once __DIR__.'/config/Bootstrap.php';

use App\Internal\DependencyInjection\Container;
$container = new Container([]);
$shipsLoader = $container->getShipLoader();
$ships = $shipsLoader->fetchAll();

$errorMessage = '';
if (isset($_GET['error'])) {
    switch ($_GET['error']) {
        case 'missing_data':
            $errorMessage = 'Don\'t forget to select some ships to battle!';
            break;
        case 'bad_ships':
            $errorMessage = 'You\'re trying to fight with a ship that\'s unknown to the galaxy?';
            break;
        case 'bad_quantities':
            $errorMessage = 'You pick strange numbers of ships to battle - try again.';
            break;
        default:
            $errorMessage = 'There was a disturbance in the force. Try again.';
    }
}
?>

<?php require __DIR__.'/templates/header.html'?>

<?php if ($errorMessage): ?>
    <div><?php echo $errorMessage; ?></div>
<?php endif; ?>

<body>
    <div class="container">
        <div class="page-header">
            <h1>Battleships of Space</h1>
        </div>
        <table class="table table-hover">
            <caption><i class="fa fa-rocket">
                </i> These ships are ready for their next Mission</caption>
            <thead>
            <tr>
                <th>Ship</th>
                <th>Weapon Power</th>
                <th>Jedi Factor</th>
                <th>Strength</th>
                <th>Status</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($ships as $ship): ?>
                <tr>
                    <td><?php echo $ship->getName(); ?></td>
                    <td><?php echo $ship->getWeaponPower(); ?></td>
                    <td><?php echo $ship->getJediFactor(); ?></td>
                    <td><?php echo $ship->getStrength(); ?></td>
                    <td>
                        <?php if ($ship->isFunctional()): ?>
                            <i class="fa fa-sun-o"></i>
                        <?php else: ?>
                            <i class="fa fa-cloud"></i>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>

        <div class="battle-box center-block border">
            <div>
                <form method="POST" action="/battle.php">
                    <h2 class="text-center">The Mission</h2>
                    <input
                            class="center-block form-control text-field"
                           type="text" name="ship1_quantity"
                           placeholder="Enter Number of Ships"
                    />
                    <select
                            class="center-block form-control btn drp-dwn-width btn-default dropdown-toggle"
                            name="ship1_id"
                    >
                        <option value="">Choose a Ship</option>
                        <?php foreach ($ships as $ship): ?>
                            <?php if ($ship->isFunctional()): ?>
                                <option value="<?php echo $ship->getId(); ?>">
                                    <?php echo $ship->getNameAndSpecs(); ?>
                                </option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                    <br>
                    <p class="text-center">AGAINST</p>
                    <br>
                    <input
                            class="center-block form-control text-field"
                            type="text"
                            name="ship2_quantity"
                            placeholder="Enter Number of Ships"
                    />
                    <select
                            class="center-block form-control btn drp-dwn-width btn-default dropdown-toggle"
                            name="ship2_id"
                    >
                        <option value="">Choose a Ship</option>
                        <?php foreach ($ships as $ship): ?>
                            <?php if ($ship->isFunctional()): ?>
                                <option value="<?php echo $ship->getId(); ?>">
                                    <?php echo $ship->getNameAndSpecs(); ?>
                                </option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                    <br>
                    <?php require_once __DIR__ . '/templates/battle/battle-type.php'; ?>
                    <button class="btn btn-md btn-danger center-block" type="submit">Engage</button>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>
