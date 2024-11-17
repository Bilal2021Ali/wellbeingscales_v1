<body class="authentication-bg">
    <style>
        .child {
            transform: scale(0);
            transform-origin: top left;
            transition: 0.4s all;
        }

        .rot {
            transform: scale(1);
            transition: 0.5s all;
        }
    </style>
    <div class="" style="padding: 20px;">

        <div class="">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-flex align-items-center justify-content-between">
                            <h4 class="mb-0"> Select a Child </h4>
                            <img width="130px" src="<?php echo base_url(); ?>assets/images/qlick-health-logo.png" alt="">
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Parent</a></li>
                                    <li class="breadcrumb-item active"> Childrens </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end page title -->
                <div class="row">
                    <?php
                    $childernsarray = $this->db->query(" SELECT `l2_student`.* , `r_levels`.`Class_ar` AS StudentClass 
                    FROM `l2_student`
                    JOIN `r_levels` ON `r_levels`.`Id` = `l2_student`.`Class`
                    WHERE Parent_NID = '" . $sessiondata['username'] . "' ")->result_array();
                    foreach ($childernsarray as $child) { ?>
                        <div class="col-xl-3 col-sm-6">
                            <div class="card text-center child">
                                <div class="card-body">
                                    <div class="clearfix"></div>
                                    <div class="mb-4">
                                        <?php $avatars = $this->db->query("SELECT * FROM `l2_avatars` WHERE 
                                        `For_User` = '" . $child['Id'] . "' AND Type_Of_User = 'Student' LIMIT 1")->result_array(); ?>
                                        <?php if (!empty($avatars)) {
                                            foreach ($avatars as $avatar) { ?>
                                                <img src="<?php echo base_url() . "/uploads/avatars/" . $avatar['Link']; ?>" alt="" class="avatar-lg rounded-circle img-thumbnail">
                                            <?php }
                                        } else { ?>
                                            <img src="<?php echo base_url(); ?>/uploads/avatars/default_avatar.jpg" alt="" class="avatar-lg rounded-circle img-thumbnail">
                                        <?php } ?>
                                    </div>
                                    <h5 class="font-size-16 mb-1"><a href="#" class="text-dark"><?php echo $child['F_name_EN'] . ' ' . $child['L_name_EN'] ?></a></h5>
                                    <p class="text-muted mb-2">The Class: <?= $child['StudentClass'] ?></p>

                                </div>

                            </div>
                        </div>
                    <?php } ?>
                </div>
                <!-- end row -->
            </div>
            <!-- container-fluid -->
        </div>
        <!-- End Page-content -->
        <script>
            $(document).ready(function() {
                var interval = 100;

                $('.child').each(function() {
                    var self = this;
                    setTimeout(function() {
                        $(self).addClass('rot');
                    }, interval);
                    interval += 200;
                });
            });

            function goToEdit(Id) {
                location.href = "<?php echo base_url(); ?>EN/Users/ChildAccount/" + Id;
            }

            function AddTemp(Id) {
                location.href = "<?php echo base_url(); ?>EN/Results/index/Student/" + Id;
            }
        </script>
    </div>
</body>