<div class="row">
    <div class="col d-flex justify-content-between">
        <h1 class="page-title mb-3">Liste des mission</h1>
        <a class="btn btn-primary btn-sm mb-3" href="<?= base_url('admin/mission/new') ?>">
            <i class="fa-solid fa-plus me-2"></i> Ajouter une mission
        </a>
    </div>
</div>
<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <table class="table table-responsive table-hover table-striped table-sm " data-toggle="table"
                       data-height="460" data-pagination="true" data-page-list="[10, 25, 50, 100, 200, All]">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Titre</th>
                        <th>level requis</th>
                        <th>puissance</th>
                        <th>stamina</th>
                        <th>taille equipe</th>
                        <th>Crédit gagné</th>
                        <th>Experience gagné</th>
                        <th>Spécialization</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($missions as $mission) : ?>

                        <tr>
                            <td><?= $mission->id ?></td>
                            <td><?= $mission->title ?></td>
                            <td><?= $mission->level_required ?></td>
                            <td><?= $mission->stamina_cost_min . ' / ' . $mission->stamina_cost_max ?></td>
                            <td><?= $mission->team_size_max ?></td>
                            <td><?= $mission->credits_reward_min . ' / ' . $mission->credits_reward_max ?></td>
                            <td><?= $mission->energy_reward_min . ' / ' . $mission->energy_reward_max ?></td>
                            <td><?= $mission->experience_reward_min . ' / ' . $mission->experience_reward_max ?></td>
                            <td>
                            <?php foreach ($mission->getSpecialization($mission->id) as $spe) : ?>
                                     <?= $spe ?>
                                <?php endforeach;?>
                            </td>
                            <td></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>