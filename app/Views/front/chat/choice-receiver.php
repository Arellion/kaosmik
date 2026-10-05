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
                    <?php foreach ($users as $user) : ?>
                        <a href="<?= base_url('chat/' . $user->username )?>" class="list-group-item list-group-item-action"><?= $user->username ?></a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>