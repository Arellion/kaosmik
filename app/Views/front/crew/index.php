<div class="row">
    <div class="col d-flex">
        <div>
            <h1 class="shadow text-white"> Mon équipages </h1>
            <span class="text-white">Ici, on gère nos mercenaires</span>
        </div>
    </div>

    <div class="col-auto d-flex g-3">
        <button type="button" class="btn btn-outline-danger" id="toggle-bulk-mode">
            Licensier en masse
        </button>

        <?= form_open('equipage/sell-bulk', ['id' => 'form-sell-bulk', 'class' => 'd-none']) ?>
        <div id="bulk-inputs"></div>
        <button type="submit" id="btn-sell-bulk" class="btn btn-danger" disabled>
            Licencier la selection ( <i class="fa-solid fa-cent-sign"></i> <span id="bulk-price">0</span>)
        </button>
        <?= form_close() ?>
    </div>
    <div class="row row-cols-6 g-3">
        <?php
        foreach ($logged_user->getplayer()->getHeroes() as $hero) { ?>
            <div class="col mb-3">
                <?= view_cell('HeroCell', ['character' => $hero, 'context' => 'crew']) ?>
            </div>
        <?php } ?>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        //Gestion de la confirmation pour la vente individuelle
        document.querySelectorAll('.js-single-form-sell').forEach(form => {
            form.addEventListener('submit', function (e) {
                e.preventDefault();
                const btn = this.querySelector('button[type="submit"]');
                const heroName = btn.dataset.heroName || 'ce mercenaire';
                Swal.fire({
                    title: 'Résilier le contrat ?',
                    text: `Ête-vous sûre de vouloir licencier ${heroName}`,
                    showCancelButton: true,
                    confirmButtonText: 'Oui !',
                    cancelButtonText: 'Annuler',
                    icon: 'warning',
                    customClass: {
                        confirmButton: 'btn btn-kaosmik'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.submit();
                    }
                })
            });
        });

        //Déclaration des variables pour la vente en lot
        const toggleBtn = document.getElementById('toggle-bulk-mode');
        const bulkForm = document.getElementById('form-sell-bulk');
        const bulkInputs = document.getElementById('bulk-inputs');
        const bulkPrice = document.getElementById('bulk-price')
        const btnSellBulk = document.getElementById('btn-sell-bulk')

        //Bouton de bascule pour la vente en lot
        toggleBtn.addEventListener('click', () => {
            const isBulkInactive = bulkForm.classList.contains('d-none');

            if (isBulkInactive) {
                //Activation de la vente en lot
                bulkForm.classList.remove('d-none')
                toggleBtn.classList.replace('btn-outline-danger', 'btn-warning')
                toggleBtn.textContent = 'Annuler';

            } else {
                //Désactivation de la vente en lot
                bulkForm.classList.add('d-none')
                toggleBtn.classList.replace('btn-warning', 'btn-outline-danger')
                toggleBtn.textContent = 'Licensier en masse'

                //Décocher toute les case
                document.querySelectorAll('.js-hero-select').forEach(el => {
                    el.checked = false
                });
                updateBulkTotal();
            }

            document.querySelectorAll('.js-bulk-checkbox-container').forEach(el => {
                el.classList.toggle('d-none', !isBulkInactive)
            });
            document.querySelectorAll('.js-single-sell-form').forEach(el => { //todo
                el.classList.toggle('d-none', isBulkInactive)
            })
        })

        //Selection du clic sur la carte pour cacher / décocher
        document.querySelectorAll('.js-hero-card').forEach(card => {
            card.addEventListener('click', (e) => {
                //Si la vente en lot est ACTIVE et que l'on ne click pas DIRECTEMENT dans la checkbox
                if (!bulkForm.classList.contains('d-none') && !e.target.classList.contains('js-hero-select')) {
                    const checkbox = card.querySelector('.js-hero-select');
                    if (checkbox) {
                        checkbox.click();
                    }
                }
            })
        })

        document.querySelectorAll('.js-hero-select').forEach(checkbox => {
            checkbox.addEventListener('change', updateBulkTotal)
        })

        //Confirmation Swal2 pour la vente en lot
        bulkForm.addEventListener('submit', function (e) {
            e.preventDefault();
            const total = parseInt(bulkPrice.textContent) || 0;

            Swal.fire({
                title: 'Voulez vous vraiment licencier ces mercenaires ?',
                text: `Vous allez licencier pour ${total} crédits`,
                showCancelButton: true,
                confirmButtonText: 'Oui !',
                cancelButtonText: 'Annuler',
                icon: 'warning',
                customClass: {
                    confirmButton: 'btn btn-kaosmik'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            })
        })

        //Recalcul du total
        function updateBulkTotal() {
            let total = 0;
            let count = 0;

            bulkInputs.innerHTML = '';
            document.querySelectorAll('.js-hero-select').forEach(checkbox => {
                const card = checkbox.closest('.js-hero-card');

                if (checkbox.checked) {

                    card.classList.add('is-selected');
                    const price = parseInt(card.dataset.sellPrice) || 0;
                    const heroId = card.dataset.id
                    total += price;
                    count++


                    //Ajouter mon input id caché
                    const hiddenInput = document.createElement('input')
                    hiddenInput.type = 'hidden';
                    hiddenInput.name = 'ids[]';
                    hiddenInput.value = heroId;
                    bulkInputs.appendChild(hiddenInput);
                }else{
                    card.classList.remove('is-selected')
                }
            });

            bulkPrice.textContent = total;
            btnSellBulk.disabled = (count === 0 || count === 1);
        }
    });
</script>

<style>
    .js-hero-card.is-selected {
        filter: brightness(0.6);
        opacity: 0.8;
    }
</style>