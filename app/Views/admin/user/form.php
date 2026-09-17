<div class="row mb-3 align-items-center">
    <div class="col">
        <div class="page-title">
            <?= isset($user) ? "Modification" : "Création"; ?> d'un utilisateur
        </div>
    </div>
</div>

<?php $form_action = 'admin/user/';
if (isset($user)) {
    $form_action .= 'update';
}else {
    $form_action .= 'create';
}; ?>
<?= form_open_multipart($form_action) ?>
<div class="row g-3">
    <div class="col-md-9">
        <div class="card mb-3">
            <div class="card-header">Informations Utilisateur</div>
            <div class="card-body">
                <div class="input-icon mb-3">
                    <span class="input-icon-addon">
                        <i class="fa-solid fa-user"></i>
                    </span>
                    <input type="text" value="<?= isset($user) ? esc($user->username) : '' ?>" name="username"
                           class="form-control" placeholder="Nom d'utilisateur" title="Nom d'utilisateur">
                </div>
                <div class="input-icon mb-3">
                    <span class="input-icon-addon">
                        <i class="fa-solid fa-lock"></i>
                    </span>
                    <input type="text" value="" name="password" class="form-control" placeholder="Mot de passe"
                           title="Mot de passe">
                </div>
                <div class="input-icon mb-3">
                    <span class="input-icon-addon">
                        <i class="fa-solid fa-envelope"></i>
                    </span>
                    <input type="text" value="<?= isset($user) ? esc($user->email) : '' ?>" name="mail"
                           title="Mail" class="form-control" placeholder="Mail" <?= isset ($user) ? "disabled" : "" ?>>
                </div>
                <label class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="active" <?php
                    if(isset($user)){
                        if($active = 1)
                        {echo "checked";}
                    } ?>>
                    <span class="form-check-label">Actif</span>
                </label>
                <?php if(!isset($user) || $user->id !== 1 ) : ?>
                <label class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="admin" value="1" <?php
                    if(isset($user)){
                        if($user->ingroup('admin'))
                        {echo "checked";}
                    } ?>>
                    <span class="form-check-label">Permission d'administrateur</span>
                </label>
                <?php endif; ?>

            </div>
        </div>
        <div class="card">
            <div class="card-header">Informations Joueur(s)</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        AVATAR
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="d-flex align-items-center h-100">
                                    Niveau : <span
                                            class="badge rounded-pill text-bg-info ms-3"><?= isset($user) ? $user->getPlayer()->level : "" ?> </span>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="input-icon">
                                    <span class="input-icon-addon">
                                        <i class="fa-solid fa-x fa-xs"></i>
                                        <i class="fa-solid fa-p fa-xs"></i>
                                    </span>
                                    <input class="form-control" value="<?=isset($user) ? $user->getPlayer()->experience : "" ?>"
                                           name="experience" placeholder="Experience" title="Experience">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-icon mb-3">
                                    <span class="input-icon-addon">
                                        <i class="fa-solid fa-cent-sign"></i>
                                    </span>
                                    <input type="number" value="<?= isset($user) ? $user->getPlayer()->credits : '' ?>"
                                           name="credits" class="form-control" placeholder="Crédit" title="Crédit">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-icon mb-3">
                                    <span class="input-icon-addon">
                                        <i class="fa-solid fa-atom"></i>
                                    </span>
                                    <input type="number"
                                           value="<?= isset($user) ? $user->getPlayer()->fusion_energy : '' ?>"
                                           name="fusion_energy" class="form-control" placeholder="Fusion Energy"
                                           title="Fusion Energy">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card h-100">
            <div class="card-body">
                <?php if(isset ($user)) : ?>
                    <div class="d-flex justify-content-between mb-1">
                        <div>
                            Créer le :
                        </div>
                        <div>
                            <i class="fa-solid fa-clock me-1"></i> <?=format_date_fr($user->created_at); ?>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <div>
                            Mise à jours le :
                        </div>
                        <div>
                            <i class="fa-solid fa-clock me-1"></i> <?=format_date_fr($user->updated_at); ?>
                        </div>
                    </div>
                <?php endif; ?>
                <div class="d-grid">
                    <?php if(isset($user)) :
                        echo form_hidden('id', (string) $user->id);
                    endif;?>
                    <button type="submit" class="btn btn-primary btn-sm"><i class="fa-solid fa-floppy-disk me-2"></i><?= isset($user) ? 'Sauvegarder' : 'Créer' ?></button>
                </div>
            </div>
        </div>
    </div>
</div>
<?= form_close() ?>