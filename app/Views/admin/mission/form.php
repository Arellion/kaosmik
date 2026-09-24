<div class="row">
    <div class="col">
        <h1 class="page-title"><?= (!isset($mission)) ? 'Création' : 'Modification' ?> d'une nouvelle mission</h1>
    </div>
</div>
<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <div class="input-icon mb-3">
                    <span class="input-icon-addon">
                        <i class="fa-solid fa-user"></i>
                    </span>
                    <input type="text" value="<?= isset($mission) ? esc($mission->title) : '' ?>" name="title"
                           class="form-control" placeholder="Titre" title=Titre"">
                </div>

                <div class="input-icon mb-3">
                    <span class="input-icon-addon">
                        <i class="fa-solid fa-user"></i>
                    </span>
                    <textarea name="description" class="form-control"
                              placeholder="Description"><?= isset($mission) ? esc($mission->description) : '' ?></textarea>
                </div>

                <div class="input-icon mb-3">
                    <span class="input-icon-addon">
                        <i class="fa-solid fa-user"></i>
                    </span>
                    <input type="number" value="<?= isset($mission) ? esc($mission->level_required) : '' ?>"
                           name="level_required"
                           class="form-control" placeholder="Level requis" title="Level requis">
                </div>

                <div class="input-icon mb-3">
                    <span class="input-icon-addon">
                        <i class="fa-solid fa-user"></i>
                    </span>
                    <input type="number" value="<?= isset($mission) ? esc($mission->power_required_min) : '' ?>"
                           name="power_required_min"
                           class="form-control" placeholder="Puissance min" title="Puissance min">
                </div>

                <div class="input-icon mb-3">
                    <span class="input-icon-addon">
                        <i class="fa-solid fa-user"></i>
                    </span>
                    <input type="number" value="<?= isset($mission) ? esc($mission->stamina_cost_max) : '' ?>"
                           name="power_required_max"
                           class="form-control" placeholder="Puissance Max" title="Puissance max">
                </div>

                <div class="input-icon mb-3">
                    <span class="input-icon-addon">
                        <i class="fa-solid fa-user"></i>
                    </span>
                    <input type="text" value="<?= isset($mission) ? esc($mission->stamina_cost_min) : '' ?>"
                           name="stamina_cost_min"
                           class="form-control" placeholder="Stamina Min" title="Stamina min">
                </div>

                <div class="input-icon mb-3">
                    <span class="input-icon-addon">
                        <i class="fa-solid fa-user"></i>
                    </span>
                    <input type="text" value="<?= isset($mission) ? esc($mission->stamina_cost_max) : '' ?>"
                           name="stamina_cost_max"
                           class="form-control" placeholder="Stamina Max" title="Stamina max">
                </div>

                <div class="input-icon mb-3">
                    <span class="input-icon-addon">
                        <i class="fa-solid fa-user"></i>
                    </span>
                    <input type="text" value="<?= isset($mission) ? esc($mission->team_size_max) : '' ?>"
                           name="team_size_max"
                           class="form-control" placeholder="Taille de l'équipe" title="Taille de l'équipe">
                </div>

                <div class="input-icon mb-3">
                    <span class="input-icon-addon">
                        <i class="fa-solid fa-user"></i>
                    </span>
                    <input type="text" value="<?= isset($mission) ? esc($mission->credits_reward_min) : '' ?>"
                           name="credits_reward_min"
                           class="form-control" placeholder="Crédit gagné min" title="Crédit gagné min">
                </div>

                <div class="input-icon mb-3">
                    <span class="input-icon-addon">
                        <i class="fa-solid fa-user"></i>
                    </span>
                    <input type="text" value="<?= isset($mission) ? esc($mission->credits_reward_max) : '' ?>"
                           name="credits_reward_max"
                           class="form-control" placeholder="Crédit gagné max" title="Crédir gagné max">
                </div>

                <div class="input-icon mb-3">
                    <span class="input-icon-addon">
                        <i class="fa-solid fa-user"></i>
                    </span>
                    <input type="text" value="<?= isset($mission) ? esc($mission->energy_reward_min) : '' ?>"
                           name="energy_reward_min"
                           class="form-control" placeholder="Energie min" title="Energie min">"">
                </div>

                <div class="input-icon mb-3">
                    <span class="input-icon-addon">
                        <i class="fa-solid fa-user"></i>
                    </span>
                    <input type="text" value="<?= isset($mission) ? esc($mission->energy_reward_max) : '' ?>"
                           name="energy_reward_max"
                           class="form-control" placeholder="Energie max" title="Energie max">
                </div>

                <div class="input-icon mb-3">
                    <span class="input-icon-addon">
                        <i class="fa-solid fa-user"></i>
                    </span>
                    <input type="text" value="<?= isset($mission) ? esc($mission->experience_reward_min) : '' ?>"
                           name="experience_reward_min"
                           class="form-control" placeholder="Experience gagné min" title="Experience gagné min">
                </div>

                <div class="input-icon mb-3">
                    <span class="input-icon-addon">
                        <i class="fa-solid fa-user"></i>
                    </span>
                    <input type="text" value="<?= isset($mission) ? esc($mission->experience_reward_max) : '' ?>"
                           name="experience_reward_max"
                           class="form-control" placeholder="Experience gagné max" title="Experience gagné max">
                </div>
                <div class="">
                    <?php foreach ($Spes as $spe) : ?>
                        <div class="me-6">
                            <label for="<?= $spe['name'] ?>"
                                   class="form-check form-switch"><?= $spe['name'] ?>
                                <input type="checkbox" name="specialization[]" class="form-check-input"
                                       id="<?= $spe['name'] ?>" value="<?= $spe['name'] ?>"

                                >
                            </label>
                        </div>
                    <?php endforeach; ?>
                    <button type="submit" class="btn btn-primary btn-sm"><?= (isset($mission)) ? 'Modifié' : 'Créer' ?> la mission</button>

                </div>
            </div>
        </div>
    </div>
</div>