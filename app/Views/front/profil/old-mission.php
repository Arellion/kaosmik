<div class="row mb-3 alogn-item-center">
    <div class="col">
        <h1 class="shadow text-white">Historique des missions</h1>
        <span class="text-white">Quel ont été mes anciennes récompense</span>
    </div>
</div>
<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <table class="table tabble-sm" data-toggle="table" data-pagination="true" data-page-size="20">
                    <thead>
                    <tr>
                        <th>Date</th>
                        <th>Nom</th>
                        <th>Crédits</th>
                        <th>Energie</th>
                        <th>Experience</th>
                    </tr>
                    </thead>
                    <tbody>

                        <?php foreach ($logged_user->getPlayer()->getMissionResolutions() as $mr) : ?>
                    <tr>
                        <td><?= $mr->created_at ?></td>
                        <td><?= $mr->getmission()->title ?></td>
                        <td><?= $mr->credits_gained ?></td>
                        <td><?= $mr->energy_gained ?></td>
                        <td><?= $mr->experience_gained ?></td>

                    </tr>
                        <?php endforeach; ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>