<div class="row row-cols-3">
    <?php
    foreach ($cantinaHeroes as $hero) { ?>
        <div class="col">
            <?= view_cell('HeroCell', ['character' => $hero]); ?>
        </div>
    <?php } ?>
</div>