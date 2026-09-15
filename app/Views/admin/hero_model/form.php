<div class="row align-items-center mb-3">
    <div class="col">
        <div class="page-title">
            <?= isset($hm) ? "Modification d'un nouveau modèle " . $hm->name : "Création d'un nouveau modèle" ?>
        </div>
    </div>
</div>
<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <?php echo form_open_multipart('admin/hero-model/create-update');
                if (isset($hm)):
                    echo form_hidden('id', $hm->id);
                endif; ?>
                <div class="mb-3">
                    <label class="form-label">Nom</label>
                    <div class="input-icon">
                    <span class="input-icon-addon">
                        <i class="fa-solid fa-tag"></i>
                    </span>
                        <input type="text" name="name" class="form-control" placeholder="Nom" title="Nom"
                               value="<?= isset($hm) ? $hm->name : '' ?>" required>
                    </div>
                </div>
                <?php if (isset($hm)): ?>
                <div class="mb-3 d-flex">
                    <img class="avatar border border-kaosmik me-3" src="<?= (isset($hm) && $hm->getImage()) ? $hm->getImage()->getUrl() : base_url('assets/img/no-img.png') ?>">
                    <input type="file" name="image" class="form-control" placeholder="Image" title="Image">
                </div>
                <?php endif; ?>
                <div class="mb-3">
                    <label class="form-label">Déscription</label>
                    <textarea class="form-control" name="description" title="description"
                              placeholder="déscription"><?= isset($hm) ? $hm->description : '' ?></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Selectionner la spécialization</label>
                    <select name="specialization_id" class="form-select" >
                        <?php foreach ($specializations as $spe): ?>
                            <option <?=(isset($hm) && $spe['id'] == $hm->specialization_id) ? 'selected' : '' ?> value="<?= $spe['id'] ?>"><?= $spe['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Puissance minimum</label>
                    <div class="input-icon">
                    <span class="input-icon-addon">
                        <i class="fa-solid fa-hand-fist"></i>
                    </span>
                        <input step="any" type="number" name="power_min" class="form-control" placeholder="Puissance minimum"
                               title="Puissance minimum" value="<?= isset($hm) ? $hm->power_min : '' ?>" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Puissance maximum</label>
                    <div class="input-icon">
                    <span class="input-icon-addon">
                        <i class="fa-solid fa-hand-fist"></i>
                    </span>
                        <input type="number" name="power_max" class="form-control" placeholder="Puissance maximum"
                               title="Puissance maximum" value="<?= isset($hm) ? $hm->power_max : '' ?>" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Coût minimum</label>
                    <div class="input-icon">
                    <span class="input-icon-addon">
                        <i class="fa-solid fa-cent-sign"></i>
                    </span>
                        <input step="any" type="number" name="cost_credits_min" class="form-control" placeholder="Coût minimum"
                               title="Coût minimum" value="<?= isset($hm) ? $hm->cost_credits_min : '' ?>" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Coût maximum</label>
                    <div class="input-icon">
                    <span class="input-icon-addon">
                        <i class="fa-solid fa-cent-sign"></i></span>
                        <input step="any" type="number" name="cost_credits_max" class="form-control" placeholder="Coût maximum"
                               title="Coût maximum" value="<?= isset($hm) ? $hm->cost_credits_max : '' ?>" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Level requis</label>
                    <div class="input-icon">
                    <span class="input-icon-addon">
                        <i class="fa-solid fa-l fa-2xs"></i><i class="fa-solid fa-v fa-2xs"></i><i
                                class="fa-solid fa-l fa-2xs"></i>
                    </span>
                        <input type="number" name="level_required" class="form-control" placeholder="Level requis"
                               title="Level requis" value="<?= isset($hm) ? $hm->level_required : '' ?>" required>
                    </div>
                </div>
                <div class="text-end">
                <button class="btn btn-primary btn-sm" type="submit"><i
                            class="fa-solid fa-plus me-1"></i><?= isset($hm) ? 'Modifier' : 'Créer' ?> le modèle hero
                </button>
                </div>
                <?= form_close() ?>
            </div>
        </div>
    </div>
</div>