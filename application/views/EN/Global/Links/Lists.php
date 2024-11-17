<!doctype html>
<html lang="en">
<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/jquery.slidinput.min.css">
<link href="<?php echo base_url() ?>assets/libsArea/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css"
      rel="stylesheet"/>
<link href="<?php echo base_url(); ?>assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css"
      rel="stylesheet">
<link href="<?php echo base_url(); ?>assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet"/>
<link href="<?php echo base_url(); ?>assets/libs/jquery-bar-rating/themes/bars-movie.css" rel="stylesheet"
      type="text/css"/>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/libs/twitter-bootstrap-wizard/prettify.css">
<link href="<?php echo base_url(); ?>assets/libs/ion-rangeslider/css/ion.rangeSlider.min.css" rel="stylesheet"
      type="text/css"/>
<link href="<?php echo base_url(); ?>assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url(); ?>assets/css/amsify.select.css" rel="stylesheet" type="text/css"/>
<style>
    .image_container img {
        margin: auto;
        width: 100%;
        max-width: 800px;
    }

    .icon {
        margin: auto;
        width: 100px;
        height: 100px;
        margin-bottom: 7px;
    }

    .link-comp {
        cursor: pointer;
    }

    .link-comp .card {
        background: linear-gradient(190deg, #7358a3 0%, #7dbce3 100%);
    }
</style>

<body class="light menu_light logo-white theme-white">

<?php if (!isset($disableDefaultLayout)) { ?>
<div class="main-content">
    <div class="page-content">
        <?php } ?>
        <?php /*?><div class="row">
            <div class="col-12">
                <div class="card">
                    <br>
                    <div class="row image_container">
                        <img src="<?php echo base_url(); ?>assets/images/banners/logo.png" alt="schools">
                    </div>
                    <br>
                </div>
            </div>
        </div><?php */ ?>
        <div class="container">
            <?php if (isset($EnableSearch)) { ?>
                <input type="search" class="form-control mb-2" placeholder="Search For..." name="search"/>
            <?php } ?>
        </div>
        <?php if (isset($links[0]["title"])) { ?>
            <?php foreach ($links as $key => $link) { ?><br>
                <h4 class="card-title"
                    style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;"><?= $link['title'] ?? "---" ?></h4>
                <div class="row">
                    <?php foreach ($link['links'] as $link_val) { ?>
                        <?php if ($sessiondata['type'] !== "school" || ($sessiondata['type'] == "school" && $this->subaccounts->can(strtolower(basename($link_val['link']))))) { ?>
                            <div data-href="<?= $link_val['link']; ?>" class="col-md-3 link-comp">
                                <div class="card card-body">
                                    <img class="icon"
                                         src="<?= base_url("assets/images/linksicons/" . ($link_val['icon'] ?? "fav_icon.png")) ?>"
                                         alt="">
                                    <h3 class="card-title mt-2 text-white text-center"><?= ucfirst(ucfirst($link_val['name'])) ?></h3>
                                    <p class="card-text text-white text-center"><?= ucfirst(ucfirst($link_val['desc'])) ?></p>
                                </div>
                            </div>
                        <?php } ?>
                    <?php } ?>
                </div>
            <?php } ?>
        <?php } else { ?>
            <div class="row">
                <?php foreach ($links as $link_val) { ?>
                    <?php if ($sessiondata['type'] !== "school" || ($sessiondata['type'] == "school" && $this->subaccounts->can(strtolower(basename($link_val['link']))))) { ?>
                        <div class="col-md-3 link-comp" data-href="<?= $link_val['link']; ?>">
                            <div class="card card-body text-center">
                                <img class="icon"
                                     src="<?= base_url("assets/images/linksicons/" . ($link_val['icon'] ?? "fav_icon.png")) ?>"
                                     alt="">
                                <h3 class="card-title mt-2 text-white text-center"><?= ucfirst(ucfirst($link_val['name'])) ?></h3>
                                <p class="card-text text-white text-center"><?= ucfirst(ucfirst($link_val['desc'])) ?></p>
                            </div>
                        </div>
                    <?php } ?>
                <?php } ?>
            </div>
        <?php } ?>
        <?php if (!isset($disableDefaultLayout)){ ?>
    </div>
</div>
<?php } ?>
<script>
    $('.link-comp').click(function () {
        location.href = $(this).attr('data-href');
    });

    $('input[name="search"]').keyup(function () {
        var value = this.value.toLowerCase();
        $(".link-comp").filter(function () {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });
</script>
