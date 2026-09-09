<div class="row align-items-center">
    <div class="col">
        <div class="page-title">Liste des modèles des héros</div>
        <div class="col-auto d-print-none">
            <div class="btn-list d-flex justify-content-end">
                <a href="<?= base_url('/admin/hero-model/new') ?>" class="btn btn-primary btn-sm">
                    <i class="fa-solid fa-plus me-2"></i> Créer un nouveau modèle
                </a>
            </div>
        </div>
    </div>
</div>
<div class="row mt-3">
    <div class="col">
        <div class="card h-100">
            <div class="card-body">
                <table class="table table-responsive table-hover table-striped table-sm " data-toggle="table"
                       data-height="460" data-pagination="true" data-page-list="[10, 25, 50, 100, 200, All]">
                    <thead>
                    <tr>
                        <th data-sortable="true">#</th>
                        <th data-sortable="true">Nom</th>
                        <th data-sortable="true">Specialisation</th>
                        <th data-sortable="false">Puissance (min / max)</th>
                        <th data-sortable="false">Coût (min / max)</th>
                        <th data-sortable="true">Niveau Min</th>
                        <th data-sortable="false">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($hero_models as $hm) : ?>
                        <tr>
                            <td><?= $hm->id ?></td>
                            <td><?= $hm->name ?></td>
                            <td><?= $hm->getSpecialization()['name'] ?></td>
                            <td><?= $hm->power_min . ' / ' . $hm->power_max ?></td>
                            <td><?= $hm->cost_credits_min . ' / ' . $hm->cost_credits_max ?></td>
                            <td><?= $hm->level_required ?></td>
                            <td class="d-flex">
                                <a class="btn btn-warning btn-sm me-2"
                                   href="<?= base_url('/admin/hero-model/edit/' . $hm->id) ?>"><i
                                            class="fa-solid fa-pen"></i></a>

                                <?php if ($hm->id != 1) : ?>
                                    <a class="btn btn-danger btn-sm"
                                       href="<?= base_url('/admin/hero-model/delete/' . $hm->id) ?>"><i class="fa-solid fa-trash-can"></i></a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
