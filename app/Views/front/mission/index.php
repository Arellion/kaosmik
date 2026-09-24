<div class="row mb-3 alogn-item-center">
    <div class="col">
        <h1 class="shadow text-white">Choix de la mission</h1>
        <span class="text-white">Ici, on envoie nos mercenaire au casse pipe</span>
    </div>
</div>
<div class="row">
    <div class="col-9">
        <div class="card">
            <div class="card-body">
                <div id="mission-container">
                    <?= view_cell('MissionCell', ['mission' => $missions[0]]) ?>
                </div>
                <div>
                    BUTTON
                </div>
            </div>
        </div>
    </div>
    <div class="col-3">
        <div class="card">
            <div class="card-body" id="mission-list">
                <?php foreach ($missions as $mission): ?>
                    <div class="card js-mission mb-3 shadow <?= $mission->level_required > $logged_user->getPlayer()->level ? "not-available" : "" ?>"
                         data-id="<?= $mission->id ?>">
                        <div class="row g-0">
                            <div class="col md-4">
                                <img class="img-fluid rounded-start" src=" <?= base_url('assets/img/no-img.png') ?>">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body p-2 d-flex flex-column">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <i class="fa-solid fa-x"></i><i class="fa-solid fa-p"></i> <span
                                                    class="ms-1"><?= $mission->experience_reward_min . ' / ' . $mission->experience_reward_max ?></span>
                                        </div>

                                        <div>
                                            <i class="fa-solid fa-users"></i> <span
                                                    class="ms-1"><?= $mission->team_size_max ?></span>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <i class="fa-solid fa-cent-sign"></i> <span
                                                    class="ms-1"><?= $mission->credits_reward_min . ' / ' . $mission->credits_reward_max ?></span>
                                        </div>
                                        <div>
                                            <i class="fa-solid fa-atom"></i> <span
                                                    class="ms-1"><?= $mission->energy_reward_min . ' / ' . $mission->energy_reward_max ?></span>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <i class="fa-solid fa-hand-fist"></i> <span
                                                    class="ms-1"><?= $mission->power_required_min . ' / ' . $mission->power_required_max ?></span>
                                        </div>
                                        <div>
                                            <i class="fa-solid fa-bolt"></i> <span
                                                    class="ms-1"><?= $mission->stamina_cost_min . ' / ' . $mission->stamina_cost_max ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<style>
    .js-mission {
        cursor: pointer;
    }

    .js-mission:hover, .js-mission:focus {
        transform: scale(1.02);
    }

    .not-available {
        filter: brightness(0.6);
        opacity: 0.6;
        cursor: not-allowed;
    }

    .mission-selected {
        border: 2px solid #007bff;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const mission_container = document.getElementById('mission-container');
        const mission_list = document.getElementById('mission-list');

        mission_list.addEventListener('click', async (e) => {
            //remonte à partir du click à la div .js-mission la plus proche
            const mission = e.target.closest('.js-mission')
            if (!mission || mission.classList.contains('not-available')) return;

            const id = mission.dataset.id;
            if (!id) return;

            mission_list.querySelectorAll('.mission-selected').forEach(card => card.classList.remove('mission-selected'))
            mission.classList.add('mission-selected');

            mission_container.innerHTML = '';
            try {
                const response = await fetch(`<?= base_url('mission/details/')?>${id}`, {
                    header: {'X-Requested-With': 'XMLHttpRequest'}
                });
                if (!response.ok) throw new Error('HTTP error ! status: ' + response.status)

                const html = await response.text();
                mission_container.innerHTML = html;
            } catch (error) {
                console.error(error);
                mission_container.innerHTML = `
                    <div class="alert alert-danger">
                        Impossible de charger cette mission
                    </div>
                `;
            }
        })

    })
</script>