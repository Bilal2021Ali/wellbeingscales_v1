<div class="pb-3 row">
    <div class="col-lg-6 col-sm-12 d-flex justify-content-around last">
        <div class="rounded-container" style="background: #ff0000;color: #fff;">
            <h3 class="text-white"><?= $results['pending'] ?>/<?= $total ?></h3>
            <p><?= __("pending") ?></p>
        </div>
    </div>
    <div class="col-lg-6 col-sm-12 d-flex justify-content-around">
        <div class="rounded-container" style="background: #0070c0;color:#fff;">
            <h3 class="text-white"><?= $results['closed'] ?>/<?= $total ?></h3>
            <p><?= __("closed") ?></p>
        </div>
    </div>
</div>
