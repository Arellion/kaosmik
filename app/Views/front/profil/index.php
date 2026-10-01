<div class="row mb-3 alogn-item-center">
    <div class="col">
        <h1 class="shadow text-white">Mon compte</h1>
    </div>
</div>
<div class="row">
    <div class="col">
        <div class="card mb-3">
            <div class="card-body ">
                <?= form_open_multipart('mon-profil/update') ?>
                <h3>Mes informations :</h3>
                <div class=" d-flex justify-content-center">
                    <img class="avatar" src="<?= ($logged_user->getImage() ? $logged_user->getImage()->getUrl() : base_url('assets/img/no-img.png')) ?>" alt="Image d'utilisateur non valide" >
                </div>
                <div class="mb-3">
                    <label class="form-label">Nom</label>
                    <div class="input-icon">
                        <span class="input-icon-addon"><i class="fa-solid fa-tag"></i></span>
                        <input type="text" name="username" class="form-control" placeholder="Nom" title="Nom"
                               value="<?= $logged_user->username ?>" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Mot de passe :</label>
                    <div class="input-icon">
                        <span class="input-icon-addon"><i class="fa-solid fa-tag"></i></span>
                        <input type="password" name="password" class="form-control" placeholder="Mot de passe"
                               title="Mor de passe" value="">
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Adresse Mail</label>
                    <div class="input-icon">
                        <span class="input-icon-addon"><i class="fa-solid fa-tag"></i></span>
                        <input type="text" name="mail" class="form-control" placeholder="Adresse Mail"
                               title="Adresse Mail" value="<?= $logged_user->email ?>" disabled>
                    </div>
                </div>
                <input class="form-control mb-3" type="file" name="image" title="Modifié une image">
                <div class="text-end">
                    <input type="hidden" name="id" value="<?= $logged_user->id ?>">
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </div>
                <?= form_close() ?>
            </div>
        </div>
    </div>
</div>