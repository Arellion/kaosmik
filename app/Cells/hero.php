<div class="card h-100 border border-4" style="border-color: <?= $character->getRarity()->color ?>!important;">
    <img class="card-img-top"
         src="<?= isset($character) && $character->getHeroModel()->getImage() ? $character->getHeroModel()->getImage()->getUrl() : base_url('assets/img/no-img.png'); ?>">
    <div class="card-body d-flex flex-column">
        <span class="card-title mb-2"><?= $character->name ?></span>
        <span class="card-subtitle text-body-secondary"><?= $character->getHeroModel()->name ?></span>
        <div class="card- mb-3">
            <div class="text-center mt-auto mt-3">
                <i class="fa-solid fa-hand-fist"></i> <?= $character->power ?>
            </div>
        </div>
        <?php
        if ($context == 'cantina') {
            $min = $character->getHeroModel()->power_min * $character->getRarity()->power_multiplier;
            $current = $character->power;
            $max = $character->getHeroModel()->power_max * $character->getRarity()->power_multiplier;

            $total = $max - $min;
            $vert = (($current - $min) / $total) * 100;
            $rouge = 100 - $vert;
            ?>
            <div class="d-flex">
                <span><?= (int) $min ?></span>
                <div class="progress mx-2" style="height: 20px">
                    <div class="progress-bar bg-success fw-semibold" style="width: <?= $vert ?>%"></div>
                    <div class="progress-bar bg-danger bg-opacity-75" style="width: <?= $rouge ?>%"></div>
                </div>
                <span><?= (int) $max ?></span>
            </div>

        <?php } ?>
    </div>
    <?php if ($context == 'cantina') { ?>
        <?= form_open('cantina/recruit/' . $character->id) ?>
        <div class="d-grid">
            <button type="submit"
                    class="btn btn-kaosmik" <?= ($character->cost_credit > auth()->user()->getPlayer()->credits ? 'disabled' : '') ?>>
                <i class="fa-solid fa-cent-sigt"></i> Recruter ( <?= $character->cost_credit ?> )
            </button>
        </div>
        <?= form_close() ?>
    <?php } ?>
    <?php if($context == 'crew') : ?>
    <?= form_open('equipage/sell/' . $character->id, ['class' => 'js-form-sell']); ?>
    <div class="d-grid">
        <button type="submit" class="btn btn-danger" data-hero-name="<?= $character->name ?>">
            Licencier pour ( <i class="fa-solid fa-cent-sign"></i><?= (int) $character->cost_credit / 2 ?>)
        </button>
    </div>
    <?php
    echo form_close();
    endif;?>

    <div class="ribbon" style="background-color: <?= $character->getRarity()->color ?>;">
        <?= $character->getRarity()->name ?>
    </div>
</div>

