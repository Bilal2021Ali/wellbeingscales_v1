<div class="pb-3 row">
    <div class="col-lg-4 col-sm-12 d-flex justify-content-around last">
        <div class="rounded-container border-primary">
            <h3><?= $results['low'] ?>/<?= $total ?></h3>
            <p class="font-size-16"><?= __("low") ?></p>
        </div>
    </div>
    <div class="col-lg-4 col-sm-12 d-flex justify-content-around">
        <div class="rounded-container border-warning">
            <h3><?= $results['average'] ?>/<?= $total ?></h3>
            <p class="font-size-16"><?= __("average") ?></p>
        </div>
    </div>
    <div class="col-lg-4 col-sm-12 d-flex justify-content-around">
        <div class="rounded-container border-danger">
            <h3><?= $results['high'] ?>/<?= $total ?></h3>
            <p class="font-size-16"><?= __("high") ?></p>
        </div>
    </div>
</div>