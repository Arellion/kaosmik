<div class="row">
    <div class="col d-flex">
        <div>
            <h1 class="shadow text-white"> Mon équipages' </h1>
            <span class="text-white">Ici, on gère nos mercenaires</span>
        </div>
    </div>
</div>

<div class="row row-cols-6">
    <?php
    foreach ($logged_user->getplayer()->getHeroes() as $hero) { ?>
        <div class="col mb-3">
            <?= view_cell('HeroCell', ['character' => $hero, 'context' => 'crew']) ?>
        </div>
    <?php } ?>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.js-form-sell').forEach(form => {
            form.addEventListener('submit', function(e) {
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
                    if(result.isConfirmed){
                        this.submit();
                    }
                })
            })
        })
    })
</script>