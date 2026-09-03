<div class="row">
    <div class="col">
        <h1>Courbe des niveaux</h1>
    </div>
</div>
<div class="row">
    <div class="col-md-3">
        <div class="card h-100">
            <div class="card-header">
                <h2>Ajouter un niveau</h2>
            </div>
            <div class="card-body">
                <?= form_open('admin/threshold/create'); ?>
                <div class="input-icon mb-3">
                    <span class="input-icon-addon">
                        <i class="fa-solid fa-l fa-2xs"></i><i class="fa-solid fa-v fa-2xs"></i><i class="fa-solid fa-l fa-2xs"></i>
                    </span>
                    <input type="number" value="" name="level" class="form-control" placeholder="Niveaux" title="Niveaux">
                </div>

                <div class="input-icon mb-3">
                    <span class="input-icon-addon">
                        <i class="fa-solid fa-x fa-2xs"></i><i class="fa-solid fa-p fa-2xs"></i>
                    </span>
                    <input type="number" value="" name="experience_required" class="form-control" placeholder="Experience"
                           title="Experience">
                </div>

                <button type="submit" class="btn btn-primary w-100">Ajouter un niveau</button>
                <?= form_close() ?>
            </div>
        </div>
    </div>
    <div class="col-md-9">
        <div class="card p-3">
            <table class="table table-responsive table-hover table-striped table-sm " data-toggle="table"
                   data-height="460" data-pagination="true" data-page-list="[10, 25, 50, 100, 200, All]">
                <thead>
                <tr>
                    <th>NIVEAUX</th>
                    <th>EXPERIENCE REQUISE</th>
                    <th>ACTIONS</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($level_thresholds as $level_threshold): ?>
                    <tr>
                        <td><?= $level_threshold['level'] ?></td>
                        <td><?= $level_threshold['experience_required'] ?></td>
                        <td class="d-flex">
                            <?= form_open('admin/threshold/delete/') ?>
                            <button type="submit" class="btn btn-danger btn-sm me-2"><i
                                        class="fa-regular fa-trash-can"></i></button>
                            <?= form_hidden('id', $level_threshold['id']) ?>
                            <?= form_close() ?>
                            <span data-id="<?= $level_threshold['id'] ?>" data-level="<?= $level_threshold['level'] ?>" data-exp="<?= $level_threshold['experience_required'] ?>" class="btn btn-warning btn-sm me-2 openEditModal"><i class="fa-solid fa-pen"></i>
                            </span>

                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
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
            <?= form_open('admin/threshold/update') ?>
            <input type="hidden" value="" id="updateId" name="id">
            <div class="modal-body">
            <div class="input-icon mb-3">
                    <span class="input-icon-addon">
                        <i class="fa-solid fa-l fa-2xs"></i><i class="fa-solid fa-v fa-2xs"></i><i class="fa-solid fa-l fa-2xs"></i>
                    </span>
                    <input type="number" value="" id="updateLevel" name="level" class="form-control" placeholder="Niveaux" title="Niveaux">
                </div>

                <div class="input-icon mb-3">
                    <span class="input-icon-addon">
                        <i class="fa-solid fa-x fa-2xs"></i><i class="fa-solid fa-p fa-2xs"></i>
                    </span>
                    <input type="number" value="" id="updateExperience" name="experience_required" class="form-control" placeholder="Experience"
                           title="Experience">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="submit" class="btn btn-primary">Sauvegarder</button>
            </div>
            <?= form_close() ?>
        </div>
    </div>
</div>
<script>
    $(document).ready(function (){
        const modalEdit = new bootstrap.Modal('#editModal')
        $(document).on('click','.openEditModal', function (){
            let id = $(this).data('id');
            let level = $(this).data('level')
            let exp = $(this).data('exp')
            $('#updateId').val(id);
            $('#updateLevel').val(level);
            $('#updateExperience').val(exp);
            modalEdit.show();
        })

    })
</script>