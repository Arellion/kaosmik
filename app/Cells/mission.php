<div class="row">
    <div class="col-auto">
        <h2 class="mb-0"><?= esc($mission->title) ?></h2>
    </div>
    <div class="col-auto ms-auto">
        <div class="d-flex">
            <div class="me-2">
                <i class="fa-solid fa-users"></i> <?= $mission->team_size_max ?>
            </div>
            <div>
                <i class="fa-solid fa-star"></i>
                <?= $mission->level_required ?>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col d-flex justify-content-center">
        <img style="max-height: 250px" class="img-fluid" src="<?= base_url('assets/img/no-img.png' )?>">
    </div>
</div>
<div class="row">
    <div class="col">
        Spécialization requise
    </div>
</div>
<div class="row">
    <div class="col">
        <?= esc($mission->description) ?>
    </div>
</div>
<div class="row">
    <div class="col">
        <div class="row">
            <div class="col-4 col-md">
                <div>
                    <i class="fa-solid fa-x"></i><i class="fa-solid fa-p"></i> <span class="ms-1"><?= $mission->experience_reward_min . ' / ' . $mission->experience_reward_max ?></span>
                </div>
            </div>
            <div class="col-4 col-md">
                <i class="fa-solid fa-cent-sign"></i> <span class="ms-1"><?= $mission->credits_reward_min . ' / ' . $mission->credits_reward_max ?></span>
            </div>
            <div class="col-4 col-md">
                <div>
                    <i class="fa-solid fa-atom"></i> <span class="ms-1"><?= $mission->energy_reward_min . ' / ' . $mission->energy_reward_max ?></span>
                </div>
            </div>
            <div class="col-4 col-md">
                <div>
                    <i class="fa-solid fa-hand-fist"></i> <span class="ms-1"><?= $mission->power_required_min . ' / ' . $mission->power_required_max ?></span>
                </div>
            </div>
            <div class="col-4 col-md">
                <div>
                    <i class="fa-solid fa-bolt"></i> <span class="ms-1"><?= $mission->stamina_cost_min . ' / ' . $mission->stamina_cost_max ?></span>
                </div>
            </div>
        </div>
    </div>
</div>