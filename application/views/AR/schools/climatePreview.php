<style>
    .icon {
        width: 40px;
        height: 40px;
        margin-right: 10px;
    }

    .valueShow {
        display: flex;
        flex-flow: row;
        justify-content: space-between;
    }

</style>
<div class="main-content">
    <div class="page-content">
        <div class="col-lg-8 m-auto 2 mt-5">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title w-100 mt-2">Category :</h3>
                    <h3 class="card-title w-100 valueShow"><span><?= $choices[0]['Cat_ar'] ?? '----' ?></span></h3>
                    <h3 class="card-title w-100 mt-4">Title :</h3>
                    <h3 class="card-title w-100 valueShow"><span><?= $choices[0]['set_name_ar'] ?? '----' ?></span></h3>
                    <h3 class="card-title w-100 mt-4">Question :</h3>
                    <h3 class="card-title w-100 valueShow mb-5"><span><?= $choices[0]['questionName_ar'] ?? '----' ?></span></h3>
                    <div id="ChoicesSort">
                        <?php foreach ($choices as $choice) { ?>
                            <div class="card type" data-id="<?= $choice['id'] ?>">
                                <div class="card-body">
                                    <h3 class="card-title m-0">
                                        <p class="mt-1 mb-0">
                                            <?php if ($choice['icon_ar'] !== null) { ?>
                                                <img class="icon" src="<?= base_url('uploads/climate_choices_icons/' . $choice['icon_ar']); ?>">
                                            <?php } else { ?>
                                                <i class="uil uil-check"></i>
                                            <?php } ?>
                                            <?= $choice['title_ar'] ?>
                                        </p>
                                    </h3>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                    <button class="btn btn-primary btn-block go" disabled>حفظ (للمعاينة فقط)</button>
                </div>
            </div>
        </div>
    </div>
</div>