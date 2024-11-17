<!doctype html>
<style>
    .image_container img {
        margin: auto;
        width: 100%;
        max-width: 800px;
    }
</style>
<html lang="en">
<link rel="stylesheet" href="<?= base_url(); ?>assets/css/switchery.css">
<link rel="stylesheet" href="<?= base_url() ?>assets/css/jquery.slidinput.min.css">
<link href="<?= base_url() ?>assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css"/>
<body class="light menu_light logo-white theme-white">
<app-sidebar _ngcontent-pjk-c62="" _nghost-pjk-c61="" class="ng-star-inserted">
    <!---->
    <app-main _nghost-pjk-c134="" class="ng-star-inserted">
        <section class="content">
            <style>
                .InfosCards h4,
                .InfosCards p {
                    color: #fff;
                }

                .InfosCards .card-body {
                    border-radius: 5px;
                }

                .image_container img {
                    margin: auto;
                    width: 100%;
                    max-width: 800px;
                }
            </style>
            <div class="main-content">
                <div class="page-content">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <br>
                                <div class="row image_container">
                                    <img src="<?= base_url(); ?>assets/images/banners/Maintiltles.png" alt="schools">
                                </div>
                                <br>
                            </div>
                        </div>
                    </div>
                    <br>
                    <h4 class="card-title"
                        style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                        MOE 013 - Enabled and Disabled School Counter </h4>
                    <?php $this->load->view('EN/Ministry/inc/schools-cards.php'); ?>
                    <br>
                    <h4 class="card-title"
                        style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                        MOE 014 - Management for Enabled and Disabled Schools </h4>
                    <div class="container-fluid">

                        <div class="card">
                            <div class="card-body">
                                <?php $this->load->view('EN/Ministry/inc/schools-table' , ['schools' => $listofadmins]); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <script src="<?= base_url(); ?>assets/libs/sweetalert2/sweetalert2.min.js"></script>
        <script src="<?= base_url(); ?>assets/js/pages/sweet-alerts.init.js"></script>
        <script src="<?= base_url(); ?>assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
        <script src="<?= base_url(); ?>assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
        <!-- Datatable init js -->
        <script src="<?= base_url(); ?>assets/js/pages/datatables.init.js"></script>
        <script src="<?= base_url(); ?>assets/js/pages/dashboard.init.js"></script>
        <script src="<?= base_url(); ?>assets/libs/sweetalert2/sweetalert2.min.js"></script>
        <script src="<?= base_url(); ?>assets/js/app.js"></script>
        <script>
            $('table').DataTable();

            <?php if ($this->session->flashdata('email_sended')) { ?>
            try {
                setTimeout(function () {
                    $('.alert.alert-success').addClass('alert-hide')
                    $('.container-fluid').css('margin-top', '0px')
                }, 3000);
            } catch (err) {

            }
            <?php } ?>

            /*$('.show-details-btn').on('click', function(e) {
                e.preventDefault();
                $(this).closest('tr').next().toggleClass('open');
                $(this).find(ace.vars['.icon']).toggleClass('fa-angle-double-down').toggleClass('fa-angle-double-up');
            });
                 */
            /*
            var pagenumber = 1;
            var lhsab = (1-1)*20;
            $('.serchable').each(function(){
            var id =  $(this).attr('id');
            if(id < lhsab && id > lhsab ){
            console.log('yes i need to hide my id is = '+id);
            }else{
                 console.log('natha id = '+id);
            }
            }); */
        </script>


</body>

</html>