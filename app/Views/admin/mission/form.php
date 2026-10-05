<div class="row">
    <div class="col">
        <h1 class="page-title"><?= (!isset($mission)) ? 'Création' : 'Modification' ?> d'une nouvelle mission</h1>
    </div>
</div>
<div class="row">
    <div class="col">
        <?= form_open('admin/mission/createUpdate');
        if(isset($mission)) : ?>
        <input type="hidden" name="id" value="<?= $mission->id ?>">
        <?php endif; ?>

        <div class="card mb-3">
            <div class="card-body">
                <h3>Information :</h3>
                <div class="input-icon mb-3">
                    <span class="input-icon-addon">
                        <i class="fa-solid fa-tag"></i>
                    </span>
                    <input type="text" value="<?= isset($mission) ? esc($mission->title) : '' ?>" name="title"
                           class="form-control" placeholder="Titre" title=Titre"">
                </div>

                <div class="input-icon mb-3">
                    <span class="input-icon-addon">
                        <i class="fa-solid fa-book-open"></i>
                    </span>
                    <textarea name="description" class="form-control"
                              placeholder="Description"><?= isset($mission) ? esc($mission->description) : '' ?></textarea>
                </div>
                <div class="mb-3 d-flex">
                    <img class="avatar border border-kaosmik me-3" src="<?= (isset($mission) && $mission->getImage()) ? $mission->getImage()->getUrl() : base_url('assets/img/no-img.png') ?>">
                    <input type="file" name="image" class="form-control" placeholder="Image" title="Image">
                </div>
            </div>
        </div>
        <div class="card mb-3">
            <div class="card-body">
                <h3>Besoin :</h3>
                <div class="row row-cols-2 d-flex justify-content-center">
                    <div class="row row-cols-2">
                        <div class="input-icon mb-3">
                    <span class="input-icon-addon">
                        <i class="fa-solid fa-hand-fist text-danger"></i>
                    </span>
                            <input type="number"
                                   value="<?= isset($mission) ? esc($mission->power_required_min) : '' ?>"
                                   name="power_required_min"
                                   class="form-control" placeholder="Puissance min" title="Puissance min">
                        </div>

                        <div class="input-icon mb-3">
                    <span class="input-icon-addon">
                        <i class="fa-solid fa-hand-fist text-danger"></i>
                    </span>
                            <input type="number"
                                   value="<?= isset($mission) ? esc($mission->power_required_max) : '' ?>"
                                   name="power_required_max"
                                   class="form-control" placeholder="Puissance Max" title="Puissance max">
                        </div>
                    </div>
                    <div class="row row-cols-2">
                        <div class="input-icon mb-3">
                    <span class="input-icon-addon">
                        <i class="fa-solid fa-bolt fs-2 text-warning"></i>
                    </span>
                            <input type="text"
                                   value="<?= isset($mission) ? esc($mission->stamina_cost_min) : '' ?>"
                                   name="stamina_cost_min"
                                   class="form-control" placeholder="Stamina Min" title="Stamina min">
                        </div>

                        <div class="input-icon mb-3">
                    <span class="input-icon-addon">
                        <i class="fa-solid fa-bolt fs-2 text-warning"></i>
                    </span>
                            <input type="text"
                                   value="<?= isset($mission) ? esc($mission->stamina_cost_max) : '' ?>"
                                   name="stamina_cost_max"
                                   class="form-control" placeholder="Stamina Max" title="Stamina max">
                        </div>
                    </div>

                    <div class="row row-cols-2">
                        <div class="input-icon mb-3">
                    <span class="input-icon-addon">
                        <i class="fa-solid fa-star"></i>
                    </span>
                            <input type="number"
                                   value="<?= isset($mission) ? esc($mission->level_required) : '' ?>"
                                   name="level_required"
                                   class="form-control" placeholder="Level requis" title="Level requis">
                        </div>

                        <div class="input-icon mb-3">
                    <span class="input-icon-addon">
                        <i class="fa-solid fa-users"></i>
                    </span>
                            <input type="text"
                                   value="<?= isset($mission) ? esc($mission->team_size_max) : '' ?>"
                                   name="team_size_max"
                                   class="form-control" placeholder="Taille de l'équipe"
                                   title="Taille de l'équipe">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="card mb-3">
    <div class="card-body">
        <h3>Récompense :</h3>
        <div class="row row-cols-2 d-flex justify-content-center">
            <div class="row row-cols-2">
                <div class="input-icon mb-3">
                    <span class="input-icon-addon">
                        <i class="fa-solid fa-cent-sign"></i>
                    </span>
                    <input type="text" value="<?= isset($mission) ? esc($mission->credits_reward_min) : '' ?>"
                           name="credits_reward_min"
                           class="form-control" placeholder="Crédit gagné min" title="Crédit gagné min">
                </div>

                <div class="input-icon mb-3">
                    <span class="input-icon-addon">
                        <i class="fa-solid fa-cent-sign"></i>
                    </span>
                    <input type="text" value="<?= isset($mission) ? esc($mission->credits_reward_max) : '' ?>"
                           name="credits_reward_max"
                           class="form-control" placeholder="Crédit gagné max" title="Crédir gagné max">
                </div>
            </div>
            <div class="row row-cols-2">
                <div class="input-icon mb-3">
                    <span class="input-icon-addon">
                        <i class="fa-solid fa-atom"></i>
                    </span>
                    <input type="text" value="<?= isset($mission) ? esc($mission->energy_reward_min) : '' ?>"
                           name="energy_reward_min"
                           class="form-control" placeholder="Energie min" title="Energie min">
                </div>

                <div class="input-icon mb-3">
                    <span class="input-icon-addon">
                        <i class="fa-solid fa-atom"></i>
                    </span>
                    <input type="text" value="<?= isset($mission) ? esc($mission->energy_reward_max) : '' ?>"
                           name="energy_reward_max"
                           class="form-control" placeholder="Energie max" title="Energie max">
                </div>
            </div>

            <div class="row row-cols-2">

                <div class="input-icon mb-3">
                    <span class="input-icon-addon">
                        <i class="fa-solid fa-user"></i>
                    </span>
                    <input type="text"
                           value="<?= isset($mission) ? esc($mission->experience_reward_min) : '' ?>"
                           name="experience_reward_min"
                           class="form-control" placeholder="Experience gagné min" title="Experience gagné min">
                </div>
                <div class="input-icon mb-3">
                    <span class="input-icon-addon">
                            <i class="fa-solid fa-x fa-sm"></i><i class="fa-solid fa-p fa-sm"></i>
                    </span>
                    <input type="text"
                           value="<?= isset($mission) ? esc($mission->experience_reward_max) : '' ?>"
                           name="experience_reward_max"
                           class="form-control" placeholder="Experience gagné max" title="Experience gagné max">
                </div>
            </div>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <h3>Spécialization</h3>
        <div class="row row-cols-6">
            <?php foreach ($specializations as $spe) : ?>
            <div class="me-6">
                <label for="<?= $spe['name'] ?>"
                       class="form-check form-switch"><?= $spe['name'] ?>
                    <input type="checkbox" name="specialization[]" class="form-check-input" value="<?= $spe['id'] ?>"
                            <?php foreach ($specSelected as $spSelect) :
                            if ($spSelect['specialization_id'] == $spe['id']) : ?> checked
                            <?php endif;
                            endforeach;
                            ?>
                    >
                </label>
            </div>
            <?php endforeach; ?>
        </div>
        <div class="row">
            <div class="col text-end">
                <button type="submit"
                        class="btn btn-primary btn-sm"><?= (isset($mission)) ? 'Modifié' : 'Créer' ?> la mission
                </button>
            </div>
        </div>
    </div>
</div>
<?php echo form_close(); ?>