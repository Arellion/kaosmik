<div class="card h-100">
    <img class="card-img-top"
         src="<?= isset($character) && $character->getHeroModel()->getImage() ? $character->getHeroModel()->getImage()->getUrl() : base_url('assets/img/no-img.png'); ?>">
    <div class="card-body">
        <ul>
            <li>name : <?= $character->name ?></li>
            <li>classe : <?= $character->getHeroModel()->name ?></li>
            <li>rarity : <?= $character->getRarity()->name ?></li>
            <li>Color : <?= $character->getRarity()->color ?></li>
            <li>power : <?= $character->power ?></li>
            <li>cost : <?= $character->cost_credit ?></li>

        </ul>
        <?php
        if ($context == 'cantina') {
            $min = $character->getHeroModel()->power_min * $character->getRarity()->power_multiplier;
            $current = $character->power;
            $max = $character->getHeroModel()->power_max * $character->getRarity()->power_multiplier;

            $total = $max - $min;
            $vert = (($current - $min) / $total) * 100;
            $rouge = 100 - $vert;
            ?>
            <div class="progress" style="height: 20px">
                <div class="progress-bar bg-success fw-semibold" style="width: <?= $vert ?>%"></div>
                <div class="progress-bar bg-danger bg-opacity-75" style="width: <?= $rouge ?>%"></div>

            </div>
        <?php } ?>
    </div>
    <?php if ($context == 'cantina') { ?>
        <?= form_open('cantina/recruit/' . $character->id) ?>
        <div class="d-grid">
            <button type="submit" class="btn btn-kaosmik" <?= ($character->cost_credit > auth()->user()->getPlayer()->credits ? 'disabled' : '') ?>>
                Recruter ( <?= $character->cost_credit ?> )
            </button>
        </div>
        <?= form_close() ?>
    <?php } ?>

    <div class="ribbon" style="background-color: <?= $character->getRarity()->color ?>;">
        <?= $character->getRarity()->name ?>
    </div>
</div>