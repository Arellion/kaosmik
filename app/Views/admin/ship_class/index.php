<div class="row align-items-center mb-3">
    <div class="col">
        <div class="page-title">Gestion des classes de vaisseaux</div>
    </div>
</div>
<div class="row mb-3">
    <div class="col-md-3">
        <div class="card h-100">
            <div class="card-body">
                <div class="card-title">Nouvelle classes de vaisseaux</div>
                <?= form_open('admin/rarity/create') ?>
                <div class="input-icon mb-3">
                        <span class="input-icon-addon">
                            <i class="fa-solid fa-tag"></i>
                        </span>
                    <input type="text" name="size" class="form-control" placeholder="Taille du vaisseau" value="" title="Taille du vaisseau" required>
                </div>
                <div class="input-icon mb-3">
                        <span class="input-icon-addon">
                            <i class="fa-solid fa-hand-fist"></i>
                        </span>
                    <input type="number" name="crew" class="form-control" placeholder="Nombre d'équipage" value="" title="Nombre d'équipage" required>
                </div>
                <div class="input-icon mb-3">
                        <span class="input-icon-addon">
                            <i class="fa-solid fa-cent-sign"></i>
                        </span>
                    <input type="number" name="power_min" class="form-control" step='0.1' min='1' placeholder="Puissance minimum" value="" title="Puissance minimum" required>
                </div>
                <div class="input-icon mb-3">
                            <span class="input-icon-addon">
                                <i class="fa-solid fa-percent"></i>
                            </span>
                    <input type="number" name="power_max" class="form-control" step='0.1' min='1' placeholder="Puissance maximum" value="" title="Puissance maximum" required>
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk me-2"></i>Créer</button>
                </div>
                <?= form_close(); ?>
            </div>
        </div>
    </div>
    <div class="col-md-9">
        <div class="card h-100">
            <div class="card-body table-responsive">
                <table class="table table-hover table-striped table-sm" data-toggle="table" data-pagination="true" data-page-size="15" data-sortable="true">
                    <thead>
                    <tr>
                        <th>Taille</th>
                        <th>Equipage</th>
                        <th>Puissance</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($shipClass as $ship) : ?>
                        <tr>
                            <td><?= $ship['size']; ?></td>
                            <td><?= $ship['crew']; ?></td>
                            <td><?= $ship['power_min'] . " / " . $ship['power_max']; ?></td>

                            <td class="d-flex">
                                <button type="button" class="btn btn-sm btn-warning me-2"><i class="fa-solid fa-pen"></i></button>
                                <?= form_open('admin/rarity/delete'); ?>
                                <?= form_hidden('id', $ship['id']); ?>
                                <button type="submit" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i></button>
                                <?= form_close(); ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Modification</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <?= form_open('admin/rarity/update'); ?>
            <input type="hidden" id="updateId" value="" name="id">
            <div class="modal-body">
                <div class="input-icon mb-3">
                        <span class="input-icon-addon">
                            <i class="fa-solid fa-tag"></i>
                        </span>
                    <input id="updateName" type="text" name="name" class="form-control" placeholder="Nom de la rareté" value="" title="Rareté" required>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-3 form-control ">
                    <label for="updateColor" style="color: var(--tblr-icon-color); font-size: 1.2em">
                        <i class="fa-solid fa-palette me-2"></i> Couleur
                    </label>
                    <input type="color" id="updateColor" name="color" class="form-control form-control-color" placeholder="Couleur de la rareté" value="" title="Couleur" required>
                </div>
                <div class="input-icon mb-3">
                        <span class="input-icon-addon">
                            <i class="fa-solid fa-hand-fist"></i>
                        </span>
                    <input id="updatePower" type="number" name="power_multiplier" class="form-control" step='0.1' min='1' placeholder="Multiplicateur de force" value="" title="Multiplicateur de force" required>
                </div>
                <div class="input-icon mb-3">
                        <span class="input-icon-addon">
                            <i class="fa-solid fa-cent-sign"></i>
                        </span>
                    <input id="updateCost" type="number" name="cost_multiplier" class="form-control" step='0.1' min='1' placeholder="Multiplicateur de coût" value="" title="Multiplicateur de coût" required>
                </div>
                <div class="input-icon mb-3">
                            <span class="input-icon-addon">
                                <i class="fa-solid fa-percent"></i>
                            </span>
                    <input id="updateAppearance" type="number" name="appearance_rate" class="form-control" step='1' min='0' max="50" placeholder="Taux d'apparition" value="" title="Taux d'apparition" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="submit" class="btn btn-primary">Sauvegarder</button>
            </div>
            <?= form_close(); ?>
        </div>
    </div>
</div>
<style>
    /* Annule le flex: 0 0 50% de Tabler sur les boutons de pagination */
    .bootstrap-table .pagination .page-item.page-next,
    .bootstrap-table .pagination .page-item.page-prev {
        flex: none !important;
        text-align: inherit !important;
    }
</style>
