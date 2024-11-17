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

    input:checked+.slider {
        background-color: #2196F3;
    }

    input:focus+.slider {
        box-shadow: 0 0 1px #2196F3;
    }

    input:checked+.slider:before {
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
</style>

<html lang="en">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/switchery.css">

<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/jquery.slidinput.min.css">
<link href="<?php echo base_url() ?>assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
<style>
    .InfosCards h4,
    .InfosCards p {
        color: #fff;
    }

    .InfosCards .card-body {
        border-radius: 5px;
    }
</style>

<body class="light menu_light logo-white theme-white">
    <app-sidebar _ngcontent-pjk-c62="" _nghost-pjk-c61="" class="ng-star-inserted">
        <!---->
        <app-main _nghost-pjk-c134="" class="ng-star-inserted">
            <section class="content">

                <div class="main-content">
                    <div class="page-content">
                        <div class="row">
                            <div class="col-md-4 col-xl-4 InfosCards">
                                <div class="card">
                                    <div class="card-body" style="background-color: #144882;">
                                        <div class="float-right mt-2">
                                            <img src="<?php echo base_url(); ?>assets/images/icons/counterschools.png" alt="schools" width="50px"></i>
                                        </div>
                                        <div>
                                            <?php
                                            $id = $sessiondata['admin_id'];
                                            $all = $this->db->query("SELECT * FROM `l1_school` 
                                            WHERE  `Added_by` = $id ")->num_rows();
                                            $allEn = $this->db->query("SELECT * FROM `l1_school` 
                                            WHERE  `Added_by` = $id AND `status` = '1'  ")->num_rows();
                                            $allDe = $this->db->query("SELECT * FROM `l1_school` 
                                            WHERE  `Added_by` = $id  AND `status` = '0' ")->num_rows();
                                            ?>
                                            <h4 class="mb-1 mt-1"><span data-plugin="counterup"><?php echo $all ?></span></h4>
                                            <p class="mb-0">Total Schools</p>
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- end col-->
                            <div class="col-md-4 col-xl-4 InfosCards">
                                <div class="card">
                                    <div class="card-body" style="background-color: #0164a8;">
                                        <div class="float-right mt-2">
                                            <img src="<?php echo base_url(); ?>assets/images/icons/school_en.png" alt="schools" width="50px"></i>
                                        </div>
                                        <div>
                                            <h4 class="mb-1 mt-1">
                                                <span data-plugin="counterup"><?php echo $allEn ?></span>
                                            </h4>
                                            <p class="mb-0">Total Enabled Schools</p>
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- end col-->
                            <div class="col-md-4 col-xl-4 InfosCards">
                                <div class="card">
                                    <div class="card-body" style="background-color: #6f42c1;">
                                        <div class="float-right mt-2">
                                            <img src="<?php echo base_url(); ?>assets/images/icons/school_ds.png" alt="schools" width="50px"></i>
                                        </div>
                                        <div>
                                            <h4 class="mb-1 mt-1">
                                                <span data-plugin="counterup"><?php echo $allDe ?></span>
                                            </h4>
                                            <p class="mb-0">Total Disabled Schools</p>
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- end col-->
                        </div> <!-- end row-->
                        <div class="container-fluid" style="overflow: auto;">
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Schools</a></li>
                                    <li class="breadcrumb-item active">List</li>
                                </ol>
                            </div>

                            <div class="card">
                                <div class="card-body">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Type</th>
                                                <th>Username</th>
                                                <th>Arabic Title</th>
                                                <th>English Title</th>
                                                <th>Country &amp; City </th>
                                                <th>Edit</th>
                                                <th class="actions">Status</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($listofadmins as $admin) { ?>
                                                <tr>
                                                    <th scope="row"><?php echo $admin['Id']; ?></th>
                                                    <td><?php echo $admin['Type_Of_School']; ?></td>
                                                    <td><?php echo $admin['Username']; ?></td>
                                                    <td><?php echo $admin['School_Name_AR']; ?></td>
                                                    <td><?php echo $admin['School_Name_EN']; ?></td>
                                                    <td>
                                                        <?php
                                                        $contriesarray = $this->db->query("SELECT * FROM `r_cities` 
                                                        WHERE id = '" . $admin['Citys'] . "' ORDER BY `Name_EN` ASC LIMIT 1")->result_array();
                                                        foreach ($contriesarray as $contrie) {
                                                            echo $contrie['Name_EN'];
                                                        }

                                                        ?>
                                                    </td>
                                                    <td><a href="<?php echo base_url() ?>EN/DashboardSystem/UpdateSchoolData/<?php echo $admin['Id']; ?>">
                                                            <i class="uil-pen" style="font-size: 25px;" title="Edit"></i></a></td>
                                                    <?php
                                                    if ($admin['status'] == 1) {
                                                        $cheked = 'checked';
                                                    } else {
                                                        $cheked = '';
                                                    }

                                                    ?>
                                                    <td><label class="switch">
                                                            <input type="checkbox" theAdminId="<?php echo $admin['Id']; ?>" id="status" <?php echo $cheked; ?>>
                                                            <span class="slider round"></span></label></td>
                                                </tr>
                                            <?php  } ?>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            </table>
                        </div>
                    </div>
                </div>
                </div>

            </section>
            <script src="<?php echo base_url(); ?>assets/libs/sweetalert2/sweetalert2.min.js"></script>
            <script src="<?php echo base_url(); ?>assets/js/pages/sweet-alerts.init.js"></script>
            <script src="<?php echo base_url(); ?>assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
            <script src="<?php echo base_url(); ?>assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
            <!-- Datatable init js -->
            <script src="<?php echo base_url(); ?>assets/js/pages/datatables.init.js"></script>
            <script src="<?php echo base_url(); ?>assets/js/pages/dashboard.init.js"></script>
            <script src="<?php echo base_url(); ?>assets/libs/sweetalert2/sweetalert2.min.js"></script>
            <script src="<?php echo base_url(); ?>assets/js/app.js"></script>
            <script>
                $('table').DataTable();
                $('input[type="checkbox"]').each(function() {
                    $(this).change(function() {
                        var theAdminId = $(this).attr('theAdminId');
                        console.log(theAdminId);
                        console.log(this.checked);
                        $.ajax({
                            type: 'POST',
                            url: '<?php echo base_url(); ?>EN/DashboardSystem/changeSchoolstatus',
                            data: {
                                adminid: theAdminId,
                            },
                            success: function(data) {
                                Swal.fire(
                                    'success',
                                    data,
                                    'success'
                                )
                            },
                            ajaxError: function() {
                                Swal.fire(
                                    'error',
                                    'oops!! لدينا خطأ',
                                    'error'
                                )
                            }
                        });

                    });
                });

                <?php if ($this->session->flashdata('email_sended')) { ?>
                    try {
                        setTimeout(function() {
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