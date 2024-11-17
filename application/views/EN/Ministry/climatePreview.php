<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <link href="<?= base_url(); ?>assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url(); ?>assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url(); ?>assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link href="<?= base_url(); ?>assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url(); ?>assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url() ?>assets/css/app.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/animate.css" />

</head>  
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

    .w-100.text-center {
        padding-bottom: 10px;
        border-bottom: 1px solid rgb(0 0 0 / 11%);
        margin-bottom: 13px;
    }
</style>
<div class="main-content">
    <div class="page-content">
        <div class="col-lg-8 offset-lg-2 mt-5">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title w-100 mt-2">Category:</h3>
                    <h3 class="card-title w-100 valueShow"><span><?= $choices[0]['Cat_en'] ?? '----' ?></span></h3>
                    <h3 class="card-title w-100 mt-4">Title:</h3>
                    <h3 class="card-title w-100 valueShow"><span><?= $choices[0]['set_name_en'] ?? '----' ?></span></h3>
                    <h3 class="card-title w-100 mt-4">Question:</h3>
                    <h3 class="card-title w-100 valueShow mb-5"><span><?= $choices[0]['questionName_en'] ?? '----' ?></span></h3>
                    <div id="ChoicesSort">
                        <?php foreach ($choices as $choice) { ?>
                            <div class="card type" data-id="<?= $choice['id'] ?>">
                                <div class="card-body">
                                    <h3 class="card-title m-0">
                                        <p class="mt-1 mb-0">
                                            <?php if ($choice['icon_en'] !== null) { ?>
                                                <img class="icon" src="<?= base_url('uploads/climate_choices_icons/' . $choice['icon_en']); ?>">
                                            <?php } else { ?>
                                                <i class="uil uil-check"></i>
                                            <?php } ?>
                                            <?= $choice['title_en'] ?>
                                        </p>
                                    </h3>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                    <button class="btn btn-primary btn-block go" disabled>Save (just for preview)</button>
                </div>
            </div>
        </div>
    </div>
</div>