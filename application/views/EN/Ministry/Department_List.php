<!doctype html>
<style>
    /* The switch - the box around the slider */
    .switch {
        position: relative;
        display: inline-block;
        width: 60px;
        height: 34px;
    }

    /* Hide default HTML checkbox */
    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    /* The slider */
    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        -webkit-transition: .4s;
        transition: .4s;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 26px;
        width: 26px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        -webkit-transition: .4s;
        transition: .4s;
    }

    input:checked + .slider {
        background-color: #2196F3;
    }

    input:focus + .slider {
        box-shadow: 0 0 1px #2196F3;
    }

    input:checked + .slider:before {
        -webkit-transform: translateX(26px);
        -ms-transform: translateX(26px);
        transform: translateX(26px);
    }

    /* Rounded sliders */
    .slider.round {
        border-radius: 34px;
    }

    .slider.round:before {
        border-radius: 50%;
    }

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
                        MOE 018 - Department Counter </h4>
                    <?php $this->load->view('EN/Ministry/inc/departments-cards'); ?>
                    <br>
                    <h4 class="card-title"
                        style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
                        MOE 019 - Enabled and Disabled Department Management </h4>
                    <div class="container-fluid" style="overflow: auto;">

                        <div class="card">

                            <div class="card-body">

                                <?php if (!empty($listofadmins)) { ?>
                                    <?php $this->load->view('EN/Ministry/inc/department-table', ['departments' => $listofadmins]); ?>
                                <?php } else { ?>
                                    <div class="empty col-lg-12 text-center">
                                        <h3>No Data</h3>
                                        <?php if (trim($sessiondata["type"]) == 'Ministry') { ?>
                                            <a href="<?= base_url() ?>EN/DashboardSystem/addSchool">
                                                <button type="button"
                                                        class="btn btn-danger btn-rounded waves-effect waves-light">Add
                                                    a New system
                                                </button>
                                            </a>
                                        <?php } else { ?>
                                            <a href="<?= base_url() ?>EN/DashboardSystem/addDepartment">
                                                <button type="button"
                                                        class="btn btn-danger btn-rounded waves-effect waves-light">Add
                                                    New Department
                                                </button>
                                            </a>
                                        <?php } ?>
                                    </div>
                                <?php } ?>
                            </div>

                        </div>
                        </table>
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
            $('table').on('change', '.switch input', function () {
                const userId = $(this).attr('data-user-id');
                $.ajax({
                    type: 'POST',
                    url: '<?= base_url(); ?>EN/DashboardSystem/changeDepartmentstatus',
                    data: {
                        adminid: userId,
                    },
                    success: function (data) {
                        Swal.fire(
                            'Updated!​',
                            data,
                            'success'
                        )
                    },
                    ajaxError: function () {
                        Swal.fire(
                            'error',
                            'oops!! we have a error',
                            'error'
                        )
                    }
                });
            });
        </script>
</body>

</html>