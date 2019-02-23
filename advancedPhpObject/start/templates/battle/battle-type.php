<?php
    $types = \App\Content\Battle\BattleManager::getAllBattleTypesWithDescriptions();
?>

<div class="text-center">
    <label for="battle_type">Battle Type</label>
    <select name="battle_type" id="battle_type" class="form-control drp-dwn-width center-block">
        <?php foreach ($types as $key => $value) {?>
            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
       <?php } ?>
    </select>
</div>
<br/>/