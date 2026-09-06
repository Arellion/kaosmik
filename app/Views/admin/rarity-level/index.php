<div class="row">
    <div class="col">
        <h1>Niveau de rareté</h1>
    </div>
</div>
<div class="row">
    <div class="col-md-3">
        <div class="card h-100 p-3">
            <h2>Ajouter une rareté</h2>
            <?= form_open('admin/rarity/create') ?>
            <div class="input-icon mb-3">
                    <span class="input-icon-addon">
                        <i class="fa-regular fa-gem"></i>
                    </span>
                <input type="text" value="" name="name" class="form-control" placeholder="Nom" title="Nom">
            </div>
            <div class="input-icon mb-3">
                    <span class="input-icon-addon">
                        <i class="fa-solid fa-highlighter"></i>
                    </span>
                <input type="color" value="" name="color" class="form-control" placeholder="Couleur" title="Couleur">
            </div>
            <div class="input-icon mb-3">
                    <span class="input-icon-addon">
                        <i class="fa-solid fa-up-long"></i>
                    </span>
                <input type="number" value="" name="power_multiplier" class="form-control"
                       placeholder="Multiplicateur de puissance" title="Multiplicateur de puissance">
            </div>
            <div class="input-icon mb-3">
                    <span class="input-icon-addon">
                        <i class="fa-solid fa-coins"></i>
                    </span>
                <input type="number" value="" name="cost_multiplier" class="form-control"
                       placeholder="Multiplicateur du coût" title="Multiplicateur du coût">
            </div>
            <div class="input-icon mb-3">
                    <span class="input-icon-addon">
                        <i class="fa-solid fa-down-long"></i>
                    </span>
                <input type="number" value="" name="appearance_rate" class="form-control"
                       placeholder="Taux d'apparition" title="Taux d'apparition">
            </div>
            <button type="submit" class="btn btn-primary w-100"><i class="fa-solid fa-plus"></i> Ajouter une rareté
            </button>
            <?= form_close() ?>
        </div>
    </div>
    <div class="col">
        <div class="card">
            <div class="card-body p-3">
                <table class="table table-responsive table-hover table-striped table-sm " data-toggle="table"
                       data-height="460" data-pagination="true" data-page-list="[10, 25, 50, 100, 200, All]">
                    <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Couleur</th>
                        <th>Multiplicateur de puissance</th>
                        <th>Multiplicateur du coût</th>
                        <th>Taux d'apparition</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach ($RarityLevels as $RarityLevel) { ?>
                        <tr>
                            <td><?= $RarityLevel->name ?></td>
                            <td><input class="form-control-sm form-control-color w-100" type="color" disabled
                                       value="<?= $RarityLevel->color ?>"</td>
                            <td><?= $RarityLevel->power_multiplier ?></td>
                            <td><?= $RarityLevel->cost_multiplier ?></td>
                            <td><?= $RarityLevel->appearance_rate ?></td>
                            <td class="d-flex justify-content-center">
                                <?= form_open('admin/rarity/delete');
                                echo form_hidden('id', $RarityLevel->id) ?>
                                <button type="submit" class="btn btn-danger btn-sm me-3"><i
                                            class="fa-solid fa-trash-can"></i></button>
                                <?= form_close() ?>
                                <span id="btn_edit" class="btn btn-warning btn-sm openEditModal"
                                      data-id="<?= $RarityLevel->id ?>"
                                      data-name="<?= $RarityLevel->name ?>"
                                      data-color="<?= $RarityLevel->color ?>"
                                      data-power_multiplier="<?= $RarityLevel->power_multiplier ?>"
                                      data-cost_multiplier="<?= $RarityLevel->cost_multiplier ?>"
                                      data-appearance_rate="<?= $RarityLevel->appearance_rate ?>"
                                      data-created_at="<?= $RarityLevel->created_at ?>"
                                      data-updated_at="<?= $RarityLevel->updated_at ?>"
                                ><i class="fa-solid fa-pen"></i></span>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modification du niveau <span id="level_title"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?= form_open('admin/rarity/create') ?>
                <div class="input-icon mb-3">
                    <span class="input-icon-addon">
                        <i class="fa-regular fa-gem"></i>
                    </span>
                    <input id="update_name" type="text" value="" name="name" class="form-control" placeholder="Nom" title="Nom">
                </div>
                <div class="input-icon mb-3">
                    <span class="input-icon-addon">
                        <i class="fa-solid fa-highlighter"></i>
                    </span>
                    <input id="update_color" type="color" value="" name="color" class="form-control" placeholder="Couleur"
                           title="Couleur">
                </div>
                <div class="input-icon mb-3">
                    <span class="input-icon-addon">
                        <i class="fa-solid fa-up-long"></i>
                    </span>
                    <input id="update_power" type="number" value="" name="power_multiplier" class="form-control"
                           placeholder="Multiplicateur de puissance" title="Multiplicateur de puissance">
                </div>
                <div class="input-icon mb-3">
                    <span class="input-icon-addon">
                        <i class="fa-solid fa-coins"></i>
                    </span>
                    <input id="update_cost" type="number" value="" name="cost_multiplier" class="form-control"
                           placeholder="Multiplicateur du coût" title="Multiplicateur du coût">
                </div>
                <div class="input-icon mb-3">
                    <span class="input-icon-addon">
                        <i class="fa-solid fa-down-long"></i>
                    </span>
                    <input id="update_appaearance" type="number" value="" name="appearance_rate" class="form-control"
                           placeholder="Taux d'apparition" title="Taux d'apparition">
                </div>
                <div class="d-flex justify-content-between">
                    <i class="fa-solid fa-clock me-2"></i><span id="update_created"></span>
                    <i class="fa-solid fa-clock me-2"></i><span id="update_updated"></span>

                </div>
                <button type="submit" class="btn btn-primary w-100"><i class="fa-solid fa-plus"></i> Ajouter une rareté
                </button>
                <?= form_close() ?>
            </div>
            <div class="modal-footer">
                <input type="hidden" value="" id="update_id" name="id">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        const btn_edit = new bootstrap.Modal('#btn_edit')
        $(document).on('Click','openEditModal', function (){
            let id = $(this).data('id');
            let name = $(this).data('name');
            let color = $(this).data('color');
            let power = $(this).data('power');
            let cost = $(this).data('cost');
            let appearance = $(this).data('appearance');
            let created = $(this).data('created');
            let updated = $(this).data('updated');
            $('#updateId').val(id);
            $('#update_name').val(name);
            $('#update_color').val(color);
            $('#update_power').val(power);
            $('#update_cost').val(cost);
            $('#update_appaearance').val(appearance);
            $('#update_created').val(created);
            $('#update_updated').val(updated);
            modalEdit.show();
        })
    })
</script>