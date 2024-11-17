<link href="<?= base_url(); ?>assets/css/app.css" rel="stylesheet">
<style>
    .odd {
        background: #f4faff;
    }

    .footer {
        left: <?= isset($hasntnav) ? "0px" : "250px" ?>;
    }

    .one-link-container {
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
    }
</style>
<!-- sample modal content -->
<?php if (isset($sessiondata)) { ?>
    <div class="modal fade links-list-container" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <h4 class="card-title p-2 text-center bg-primary text-white" style="border-top-right-radius: 5px;border-top-left-radius: 5px;margin: -1px -1px 3px -1px;"> Index </h4>
                <div class="modal-header">
                    <input type="search" class="form-control links-list-search" placeholder="Search by page name ..." style="border: 0px;">
                </div>
                <div class="modal-body overflow-auto" style="max-height: 300px;">
                    <?php foreach ($this->Links->get() as $k => $link) { ?>
                        <div class="mb-2 border-bottom one-link-container" style="cursor: pointer;" onclick="window.location='<?= base_url("EN/" . $link["url"]) ?>'">
                            <div class="avatar-sm me-4">
                                <span class="avatar-title bg-primary text-primary font-size-16 rounded-circle">
                                    <?php if (strpos($link["icon"], 'uil-') !== false) {  ?>
                                        <i style="color: #fff;" class="uil <?= $link["icon"] ?>"></i>
                                    <?php } else { ?>
                                        <img width="19px" src="<?= base_url($link["icon"] ?? '') ?>">
                                    <?php } ?>
                                </span>
                            </div>
                            <div class="flex-grow-1 ml-2 pt-1">
                                <div class="">
                                    <h5 class="text-truncate font-size-16 mb-0"><span class="text-dark"><?= ucfirst($link["name"]) ?></span></h5>
                                    <p class="text-muted">
                                        <i class="mdi mdi-copy me-1"></i><?= $link["url"] ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    <?php } ?>
    </div>
    <footer class="footer">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <script>
                        document.write(new Date().getFullYear())
                    </script> &copy; QlickHealth. Version 2.0
                </div>
                <div class="col-sm-6">
                    <div class="text-sm-right d-none d-sm-block">
                        Welcome <i class="mdi mdi-heart text-danger"></i>
                        <a href="https://wellbeinggo.com/" target="_blank" class="text-reset"><?= $sessiondata['username']; ?></a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <style>
        th {
            font-weight: bolder !important;
        }
    </style>
    <script src="<?= base_url(); ?>assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/metismenu/metisMenu.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/simplebar/simplebar.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/node-waves/waves.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/waypoints/lib/jquery.waypoints.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/jquery.counterup/jquery.counterup.min.js"></script>
    <script src="<?= base_url(); ?>assets/libs/parsleyjs/parsley.min.js"></script>
    <script src="<?= base_url(); ?>assets/js/pages/form-validation.init.js"></script>
    <script src="<?= base_url(); ?>assets/js/app.js"></script>
    <script>
        $('table').addClass('table table-bordered dt-responsive nowrap dataTable no-footer dtr-inline');
        $('.links-list').click(() => {
            $('.links-list-container').modal('show');
        });

        var isCtrl = false;
        document.onkeyup = function(e) {
            if (e.keyCode == 17) isCtrl = false;
        }
        document.onkeydown = function(e) {
            if (e.keyCode == 17) isCtrl = true;
            if (e.keyCode == 83 && isCtrl == true) {
                //run code for CTRL+S -- ie, save!
                $('.links-list-container').modal('toggle');
                return false;
            }
        }
        const links = [];

        // $('.metismenu a').each((i, e) => {
        //     links.push({
        //         name: $(e).find("span").text(),
        //         url: $(e).attr('href'),
        //         icon: $(e).find("i img").attr("src"),
        //         protected: null,
        //     });
        // });
        // console.log("----------------------- OTHER -----------------------");
        // $('.link-comp').each((i, e) => {
        //     links.push({
        //         name: $(e).find(".card-title").text(),
        //         url: $(e).data('href'),
        //         icon: $(e).find("img.icon").attr("src"),
        //         protected: null,
        //     });
        // });
        // $('.col-md-4 .card.card-body').each((i, e) => {
        //     links.push({
        //         name: $(e).find(".card-title").text(),
        //         url: $(e).find("a").attr('href'),
        //         icon: $(e).find("img.icon").attr("src") ?? "",
        //         protected: null,
        //     });
        // });
        // for (url in urls) links.push({
        //     name: urls[url].innerText,
        //     url: urls[url].href,
        //     icon: urls[url].getAttribute('data-icon'),
        //     protected_by: urls[url].getAttribute('data-protected-by'),
        // });

        console.log(links);

        $('.links-list-search').on('keyup', function() {
            const value = $(this).val().toLowerCase().trim();
            if (value == "") {
                $(".one-link-container").show();
                return;
            }
            $('.one-link-container').each(function(i, e) {
                const text = $(e).text().toLowerCase().trim();
                if (text.indexOf(value) === -1) {
                    $(e).hide();
                } else {
                    $(e).show();
                }
            });
        });
    </script>