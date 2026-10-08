<div class="row mb-3 align-items-center">
    <div class="col">
        <div>
            <h1 class="shadow text-white">Le Chat</h1>
            <span class="text-white">Ici, ont choisi avec qui on discute</span>
        </div>
    </div>
</div>
<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <div class="list-group">
                    <?php foreach ($users as $user) :
                        ?>
                        <a href="<?= base_url('chat/' . esc($user->username)); ?>">
                            <div class="list-group-item list-group-item-action text-black">
                                <div class="row">
                                    <div class="col-3">
                                        <?= $user->username ?>
                                    </div>
                                    <div class="col-8">
                                        <?= esc(mb_strimwidth($lastMessages[$user->id]->message, 0, 50)); ?>
                                    </div>
                                    <div class="col-1">
                                        <span class="badge badge-kaosmik"><?= $lastMessages[$user->id]->created_at->format('h:i') ?></span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>