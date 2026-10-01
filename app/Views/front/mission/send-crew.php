<div class="row mb-3 alogn-item-center">
    <div class="col">
        <h1 class="shadow text-white">Choix des mercenaires</h1>
        <span class="text-white">Ici, on envoie nos mercenaires au casse pipe</span>
    </div>
</div>
<div class="row">
    <div class="col-md-7">
        <div class="row">
            <div class="col">
                <div class="card mb-3">
                    <div class="card-body">
                        <?= view_cell('MissionCell', ['mission' => $mission, 'context' => 'send']); ?>
                        <div class="row mt-3">
                            <div class="col ">
                                <div class="alert alert-danger" role="alert">
                                    <?php if (count($mission->getSpecializations()) > 0): ?>
                                        <div id="err-spe" data-state="0"><i class="fa-solid fa-mask"></i>Les besoins en
                                            spécialités n'ont pas été atteintes par vos mercenaires.
                                        </div>
                                    <?php endif; ?>
                                    <div id="err-stam" class="d-none" data-state="1"><i class="fa-solid fa-bolt"></i> Au
                                        moins un de vos mercenaires n'as pas assez d'endurance pour la mission.
                                    </div>
                                    <div id="err-power" data-state="0"><i class="fa-solid fa-hand-fist"></i> La
                                        puissance requise n'a pas été atteinte.
                                    </div>
                                </div>
                            </div>
                            <div class="col col-auto ms-auto">
                                <?= form_open('mission/send-crew', ['id' => 'send-crew-form']); ?>
                                <div id="heroes-ids"></div>
                                <input type="hidden" name="mission_id" value="<?= $mission->id ?>">
                                <button id="send-squad" type="submit" class="btn btn-kaosmik" disabled>Envoyer en
                                    mission
                                </button>
                                <?= form_close() ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="row row-cols-3 row-cols-md-4 g-3" id="mission-squad"
                             data-stamina-required="<?= $mission->getStaminaRequired(); ?>">
                            <?php for ($i = 0; $i < $mission->team_size_max; $i++): ?>
                                <div class="col js-squad-slot" data-slot-index="<?= $i ?>">
                                    <div class="card shadow h-100 default-slot" style="min-height: 331px">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-center align-items-center h-100">
                                                <i class="fa-solid fa-user-astronaut fa-5x"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-done h-100 squad-hero">

                                    </div>
                                </div>
                            <?php endfor; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-5" id="hero-list">
        <div class="card h-100">
            <div class="card-body">
                <div class="row g-3">
                    <?php foreach ($logged_user->getPlayer()->getHeroes() as $hero) : ?>
                        <div class="col-4">
                            <?= view_cell('HeroCell', ['character' => $hero]); ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .js-hero-card:hover, .js-hero-card:focus {
        cursor: pointer;
        transform: scale(1.02);
    }
</style>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const heroList = document.getElementById('hero-list');
        const missionSquad = document.getElementById('mission-squad');
        const totalpowerEL = document.getElementById('total-power')
        const sendSquadBtn = document.getElementById('send-squad')

        const errSpe = document.getElementById('err-spe')
        const errStam = document.getElementById('err-stam')
        const errPower = document.getElementById('err-power')

        let isPowerOk = false;
        let isStaminaOk = true;
        let isSpecializationOk = errSpe ? false : true;

        const powerRequired = parseInt(totalpowerEL.closest('.list-group-item').dataset.powerRequired);
        const staminaRequired = parseInt(missionSquad.dataset.staminaRequired);

        let total_power = 0;

        const requiredSpecs = [];
        const specBadges = document.querySelectorAll('.js-mission-spec');
        specBadges.forEach(badge => {
            requiredSpecs.push(parseInt(badge.dataset.specId));
        })


        function updateSquadState() {
            const squadHeroes = Array.from(missionSquad.querySelectorAll('.squad-hero .js-hero-card'));
            const heroesIdsInput = document.getElementById('heroes-ids');
            const hasHeroes = squadHeroes.length > 0;
            const alert = document.querySelector('.alert-danger');

            //Puissance
            isPowerOk = total_power >= powerRequired;
            if (errPower) errPower.classList.toggle('d-none', isPowerOk);

            //Couleur du texte
            if (totalpowerEL) {
                if (isPowerOk) {
                    totalpowerEL.classList.replace('text-danger', 'text-success')
                } else {
                    totalpowerEL.classList.replace('text-success', 'text-danger')
                }
            }
            //Stamina
            isStaminaOk = true;

            squadHeroes.forEach(hero => {
                const heroStamina = parseInt(hero.dataset.stamina);
                console.log(staminaRequired)
                if (heroStamina < staminaRequired) {
                    isStaminaOk = false;
                }
            })

            if (errStam) errStam.classList.toggle('d-none', isStaminaOk)

            //Spécialization

            if (requiredSpecs.length > 0) {
                //Etape 1 : Listé les spécialisations de l'escouade
                const squadSpecs = []
                squadHeroes.forEach(hero => {
                    squadSpecs.push(parseInt(hero.dataset.specialization));
                });
                //Etape 2 : Comparé les spécialization de l'escouade avec celle de la mission
                isSpecializationOk = true;
                requiredSpecs.forEach(spec => {
                    //includes() == in_array() en php
                    if (!squadSpecs.includes(spec)) {
                        isSpecializationOk = false;
                    }
                });
                if (errSpe) errSpe.classList.toggle('d-none', isSpecializationOk);
            } else {
                isSpecializationOk = true
            }

            //Validation
            const isSquadReady = isPowerOk && isStaminaOk && isSpecializationOk;
            if(isSquadReady && hasHeroes){
                heroesIdsInput.innerHTML = "";
                squadHeroes.forEach(hero => {
                    const hiddenInput = document.createElement('input');
                    hiddenInput.type = "hidden";
                    hiddenInput.name = "heroes_ids[]";
                    hiddenInput.value = hero.dataset.id;
                    heroesIdsInput.appendChild(hiddenInput)
                });
            }
            if (alert) alert.classList.toggle('d-none', isSquadReady);
            if (sendSquadBtn) sendSquadBtn.disabled = !isSquadReady;
        }

        // ALLER : Ajouter un héro dans l'escouade de mission
        heroList.addEventListener('click', function (e) {
            //On récupère la carte du hero le plus proche de notre click
            const heroCard = e.target.closest('.js-hero-card');
            if (!heroCard) return;

            //Récupère dans les data l'id et recherche le parent le plus proche de qui possède la classe (col-4)
            const heroID = heroCard.dataset.id;
            const heroPower = heroCard.dataset.power

            const heroColumn = heroCard.closest('.col-4');

            //On cherche le premier slot vide dans la zone de l'escouade de mission
            const emptySlot = Array.from(missionSquad.querySelectorAll('.js-squad-slot')).find(slot => {
                return !slot.dataset.heroId;
            });
            if (!emptySlot) return;

            //Affecter un HeroId au slot vide (ce qui nous permet de savoir qu'il n'est pas vide)
            emptySlot.dataset.heroId = heroID;

            //On cache la carte par défaut et on cache le hero dans la liste
            emptySlot.querySelector('.default-slot').classList.add('d-none');
            heroColumn.classList.add('d-none');

            //On clone la carte du hero
            const cloneCard = heroCard.cloneNode(true);

            //Calculer le total de puissance
            total_power += parseInt(heroPower);
            totalpowerEL.textContent = total_power;


            //On ajoute le clone et on l'affiche
            emptySlot.querySelector('.squad-hero').appendChild(cloneCard);
            emptySlot.querySelector('.squad-hero').classList.remove('d-none')

            updateSquadState()
        });

        //RETOUR: Retirer un héro de l'escouade pour la remetre dans la liste
        missionSquad.addEventListener('click', function (e) {
            const squadSlot = e.target.closest('.js-squad-slot');
            if (!squadSlot || !squadSlot.dataset.heroId) return;

            const heroId = squadSlot.dataset.heroId;

            const orginalHeroCard = heroList.querySelector(`.js-hero-card[data-id="${heroId}"]`);
            if (!orginalHeroCard) return;

            const originalHeroPower = orginalHeroCard.dataset.power;

            const originalHeroColumn = orginalHeroCard.closest('.col-4')
            if (!originalHeroColumn) return;

            total_power -= parseInt(originalHeroPower);
            totalpowerEL.textContent = total_power;

            originalHeroColumn.classList.remove('d-none')

            delete squadSlot.dataset.heroId

            const squadHero = squadSlot.querySelector('.squad-hero');
            squadHero.classList.add('d-none');
            squadHero.innerHTML = "";

            squadSlot.querySelector('.default-slot').classList.remove('d-none');

            updateSquadState()
        });

    });
</script>