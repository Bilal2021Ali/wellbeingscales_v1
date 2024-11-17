  
        <!-- owl.carousel css -->
        <link rel="stylesheet" href="<?php echo base_url('assets/libs/owl.carousel/assets/owl.carousel.min.css'); ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/libs/owl.carousel/assets/owl.theme.default.min.css'); ?>">
        <style>
            /* not done */
            .notdone .event-date{
                background-color: red !important;
            }
            .notdone .text-primary {
                color: #fff !important;
            }

            .notdone a  {
                color: #f90000 !important;
            }

            .notdone h5 , .notdone p {
                color: #da6060 !important;
            }

            /* doned -*/
            .hasdone .event-date{
                background-color: green !important;
            }
            .hasdone .text-primary {
                color: #fff !important;
            }

            .hasdone a  {
                color: #0bc511  !important;
            }

            .hasdone h5 , .hasdone p {
                color: #2b8a2e !important;
            }
        </style>
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title">ملف النظام</h3>
                    <div class="hori-timeline mt-5" dir="ltr">
                        <div class="owl-carousel owl-theme  navs-carousel events" id="timeline-carousel">
                            <div class="item event-list <?php echo $account_status['Profile'] ? "hasdone" : "notdone" ?>">
                                <div class="event-date">
                                    <div class="text-primary"><?php echo $account_status['Profile'] ? "تم" : "لم ينجز" ?></div>
                                </div>
                                <div class="px-3">
                                    <h5>ملف النظام</h5>
                                    <p class="text-muted"><?php echo $account_status['Profile'] ? "تم تحديث ملف النظام" : "لم يتم تحديث ملف النظام" ?></p>
                                    <div>
                                        <a href="<?php echo base_url("AR/schools/Profile") ?>"><?php echo $account_status['Profile'] ? "ملف النظام" : "تحديث ملف النظام" ?><i class="uil uil-arrow-right"></i></a>
                                    </div>
                                </div>
                            </div>

                            <div class="item event-list <?php echo $account_status['Classes'] ? "hasdone" : "notdone" ?>">
                                <div class="event-date">
                                    <div class="text-primary"><?php echo $account_status['Classes'] ? "تم" : "لم ينجز" ?></div>
                                </div>
                                <div class="px-3">
                                    <h5>المراحل التعليمية</h5>
                                    <p class="text-muted"><?php echo $account_status['Classes'] ? "لديك مراحل تعليمية" : "ليس لديك أي مراحل تعليمية" ?></p>
                                    <div>
                                        <a href="<?php echo base_url("AR/schools/Profile") ?>">إدارة المراحل التعليمية<i class="uil uil-arrow-right"></i></a>
                                    </div>
                                </div>
                            </div>

                            <div class="item event-list <?php echo $account_status['sites'] ? "hasdone" : "notdone" ?>">
                                <div class="event-date">
                                    <div class="text-primary"><?php echo $account_status['sites'] ? "تم" : "لم ينجز" ?></div>
                                </div>
                                <div class="px-3">
                                    <h5>مواقع الفحوصات المخبرية</h5>
                                    <p class="text-muted"><?php echo $account_status['sites'] ? "لديك مواقع للفحوصات المخبرية" : "ليس لديك مواقع للفحوصات المخبرية" ?></p>
                                    <div>
                                        <a href="<?php echo $account_status['sites'] ? base_url("AR/Schools/listOfSites") : base_url("AR/Schools/AddMembers"); ?>">إدارة المواقع<i class="uil uil-arrow-right"></i></a>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="item event-list <?php echo $account_status['Areas'] ? "hasdone" : "notdone" ?>">
                                <div class="event-date">
                                    <div class="text-primary"><?php echo $account_status['Areas'] ? "تم" : "لم ينجز" ?></div>
                                </div>
                                <div class="px-3">
                                    <h5>أجهزة جودة الهواء</h5>
                                    <p class="text-muted"><?php echo $account_status['Areas'] ? "لديك أجهزة جودة الهواء" : "ليس لديك أجهزة جودة الهواء" ?></p>
                                    <div>
                                        <a href="<?php echo base_url("AR/Schools/AddMembers/areas") ?>">إدارة أجهزة جودة الهواء<i class="uil uil-arrow-right"></i></a>
                                    </div>
                                </div>
                            </div>

                            <div class="item event-list <?php echo $account_status['Devices'] ? "hasdone" : "notdone" ?>">
                                <div class="event-date">
                                    <div class="text-primary"><?php echo $account_status['Devices'] ? "تم" : "لم ينجز" ?></div>
                                </div>
                                <div class="px-3">
                                    <h5>أجهزة موازين الحرارة والمختبرات والبوابات</h5>
                                    <p class="text-muted"><?php echo $account_status['Devices'] ? "لديك أجهزة موازين الحرارة والمختبرات والبوابات" : "ليس لديك أجهزة موازين الحرارة والمختبرات والبوابات" ?></p>
                                    <div>
                                        <a href="<?php  echo $account_status['Devices'] ?  base_url("AR/Schools/ListofDevices") : base_url("AR/Schools/AddMembers") ?>">إدارة الأجهزة<i class="uil uil-arrow-right"></i></a>
                                    </div>
                                </div>
                            </div>

                            <div class="item event-list <?php echo $account_status['Staffs'] ? "hasdone" : "notdone" ?>">
                                <div class="event-date">
                                    <div class="text-primary"><?php echo $account_status['Staffs'] ? "تم" : "لم ينجز" ?></div>
                                </div>
                                <div class="px-3">
                                    <h5>الموظفين</h5>
                                    <p class="text-muted"><?php echo $account_status['Staffs'] ? "لديك موظفين في النظام" : "لليس لديك موظفين في النظام" ?></p>
                                    <div>
                                        <a href="<?php  echo $account_status['Staffs'] ?  base_url("AR/Schools/listOfStaff") : base_url("AR/Schools/AddMembers/staff") ?>"><?php echo $account_status['Staffs'] ? "إدارة الموظفين" : "إضافة موظف" ?><i class="uil uil-arrow-right"></i></a>
                                    </div>
                                </div>
                            </div>

                            <div class="item event-list <?php echo $account_status['Teachers'] ? "hasdone" : "notdone" ?>">
                                <div class="event-date">
                                    <div class="text-primary"><?php echo $account_status['Teachers'] ? "تم" : "لم ينجز" ?></div>
                                </div>
                                <div class="px-3">
                                    <h5>المعلمين</h5>
                                    <p class="text-muted"><?php echo $account_status['Teachers'] ? "لديك معلمين في النظام" : "ليس لديك معلمين في النظام" ?></p>
                                    <div>
                                        <a href="<?php  echo $account_status['Teachers'] ?  base_url("AR/Schools/listOfTeachers") : base_url("AR/Schools/AddMembers/teacher") ?>"><?php echo $account_status['Teachers'] ? "إدارة المعلمين" : "أضف معلم" ?><i class="uil uil-arrow-right"></i></a>
                                    </div>
                                </div>
                            </div>

                            <div class="item event-list <?php echo $account_status['Students'] ? "hasdone" : "notdone" ?>">
                                <div class="event-date">
                                    <div class="text-primary"><?php echo $account_status['Students'] ? "تم" : "لم ينجز" ?></div>
                                </div>
                                <div class="px-3">
                                    <h5>الطلاب</h5>
                                    <p class="text-muted"><?php echo $account_status['Students'] ? "لديك طلاب في النظام" : "ليس لديك طلاب في النظام " ?></p>
                                    <div>
                                        <a href="<?php  echo $account_status['Students'] ?  base_url("AR/Schools/listOfStudents") : base_url("AR/Schools/AddMembers/student") ?>"><?php echo $account_status['Students'] ? "إدارة الطلاب" : "إضافة طالب" ?><i class="uil uil-arrow-right"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end card -->
            </div>
        </div>
        <script src="<?php echo base_url("assets/libs/owl.carousel/owl.carousel.min.js"); ?>"></script>
        <script src="<?php echo base_url("assets/js/pages/timeline.init.js"); ?>"></script>