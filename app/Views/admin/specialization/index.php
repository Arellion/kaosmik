<div class="row">
    <div class="col">
        <h1>Liste des specialization</h1>
    </div>
</div>
<div class="row">
    <div class="col-md-3">
        <div class="card h-100">
            <div class="card-body">
                <?= form_open('admin/specialization/create') ?>
                <div class="input-icon mb-3">
                    <span class="input-icon-addon">
                        <i class="fa-solid fa-tag"></i>
                    </span>
                    <input type="text" name="name" class="form-control" placeholder="Nom" value="" min="1"
                           title="Niveau">
                </div>
                <div>
                        <textarea class="form-control mb-3" name="description" rows="3" placeholder="Description"></textarea>
                </div>
                <button type="submit" class="btn btn-primary w-100"><i class="fa-solid fa-plus me-1"></i> Ajouter une spécialization</button>

                <?= form_close() ?>
            </div>
        </div>
    </div>
    <div class="col-md-9">
        <div class="card">
            <div class="card-body text-center">
                <table class="table table-responsive table-hover table-striped table-sm " data-toggle="table"
                       data-height="460" data-pagination="true" data-page-list="[10, 25, 50, 100, 200, All]">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Nom</th>
                        <th>description</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($specializations as $specialization): ?>
                        <tr>
                            <td><?= $specialization['id'] ?></td>
                            <td><?= $specialization['name'] ?></td>
                            <td><?= $specialization['description'] ?></td>
                            <td class="d-flex">
                                <span
                                        class="ms-2 btn btn-sm btn-warning openEditModal me-3"
                                        data-bs-toggle="modal"
                                        data-bs-target="#editModal"
                                        data-id="<?= $specialization['id'];?>"
                                        data-name="<?= $specialization['name'];?>"
                                        data-description="<?= $specialization['description'];?>">
                                    <i class="fa-solid fa-pen"></i>
                                </span>

                                <?php if($specialization['id'] != 1) {
                                echo form_open('admin/specialization/delete');
                                echo form_hidden('id', $specialization['id']);
                                ?>

                                <button type="submit" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash-alt"></i></button>
                                <?= form_close();
                                }?>
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
            <?= form_open('admin/specialization/update'); ?>
            <input type="hidden" id="updateId" value="" name="id">
            <div class="modal-body">
                <div class="input-icon mb-3">
                    <span class="input-icon-addon">
                                                <i class="fa-solid fa-tag"></i>

                    </span>
                    <input id="updateName" type="text" name="name" class="form-control" placeholder="Nom" value="">
                </div>
                <div class="input-icon mb-3">
                    <textarea name="description" class="form-control mb-3" placeholder="Description" id="updateDescription"></textarea>
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

<script>
    $(document).ready(function(){
        // A n'écouter qu'en JS natif : tabler.min.js dispatche un évènement DOM
        // dont le "type" est littéralement "show.bs.modal". jQuery .on('show.bs.modal', ...)
        // interprète le point comme un namespace et n'écoute que "show", donc ne se déclenche jamais.
        document.getElementById('editModal').addEventListener('show.bs.modal', function (event) {
            let button = event.relatedTarget;
            let id = button.getAttribute('data-id');
            let name = button.getAttribute('data-name');
            let descripton = button.getAttribute('data-description');
            $('#updateId').val(id);
            $('#updateName').val(name);
            $('#updateDescription').val(descripton);
        })
    });
</script>