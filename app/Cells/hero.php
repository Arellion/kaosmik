<div class="card h-100 border border-4 js-hero-card" style="border-color: <?= $character->getRarity()->color ?>!important;"
     data-id="<?= $character->id ?>" data-sell-price="<?= (int) $character->cost_credit /2 ?>">
    <div class="position-absolute top-0 start-0 m-3 d-none js-bulk-checkbox-container" style="z-index: 10;">
        <input type="checkbox" class="form-check-input js-hero-select" style="transform: scale(1.5); cursor: pointer;">
    </div>
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
            <?php if(auth()->user()->getplayer()->isFleetFull()) : ?>
            <span class="badge text-bg-danger">Equipage complet</span>
        <?php endif ?>
        <?= form_open('cantina/recruit/' . $character->id) ?>
        <div class="d-grid">
            <button type="submit"
                    class="btn btn-kaosmik" <?= ($character->cost_credit > auth()->user()->getPlayer()->credits || (auth()->user()->getplayer()->isFleetFull()) ? 'disabled' : '') ?>>
                 Recruter ( <i class="fa-solid fa-cent-sign me-1 ms-1"></i><?= $character->cost_credit ?> )
            </button>
        </div>
        <?= form_close() ?>
    <?php } ?>
    <?php if($context == 'crew') : ?>
    <?= form_open('equipage/sell/' . $character->id, ['class' => 'js-single-form-sell']); ?>
    <div class="d-grid">
        <button type="submit" class="btn btn-danger js-single-sell-form" data-hero-name="<?= $character->name ?>">
            Licencier pour ( <i class="fa-solid fa-cent-sign"></i> <?= (int) $character->cost_credit / 2 ?>)
        </button>
    </div>
    <?php
    echo form_close();
    endif;?>

    <div class="ribbon" style="background-color: <?= $character->getRarity()->color ?>;">
        <?= $character->getRarity()->name ?>
    </div>
</div>

