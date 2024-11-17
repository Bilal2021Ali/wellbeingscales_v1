<link rel="stylesheet" href="<?= base_url('assets/libs/owl.carousel/assets/owl.carousel.min.css'); ?>">
        <link rel="stylesheet" href="<?= base_url('assets/libs/owl.carousel/assets/owl.theme.default.min.css'); ?>">
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
        <div class="col-lg-12 p-0">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title">Account Status</h3>
                    <div class="hori-timeline mt-5" dir="ltr">
                        <div class="owl-carousel owl-theme  navs-carousel events" id="timeline-carousel">
                            <div class="item event-list <?= $account_status['Profile'] ? "hasdone" : "notdone" ?>">
                                <div class="event-date">
                                    <div class="text-primary"><?= $account_status['Profile'] ? "Done." : "Not." ?></div>
                                </div>
                                <div class="px-3">
                                    <h5>Profile</h5>
                                    <p class="text-muted"><?= $account_status['Profile'] ? "Your profile has been updated." : "Your profile not updated yet" ?></p>
                                    <div>
                                        <a href="<?= base_url("EN/schools/Profile") ?>"><?= $account_status['Profile'] ? "Profile" : "Update my profile" ?><i class="uil uil-arrow-right"></i></a>
                                    </div>
                                </div>
                            </div>

                            <div class="item event-list <?= $account_status['Classes'] ? "hasdone" : "notdone" ?>">
                                <div class="event-date">
                                    <div class="text-primary"><?= $account_status['Classes'] ? "Done." : "Not." ?></div>
                                </div>
                                <div class="px-3">
                                    <h5>Classes</h5>
                                    <p class="text-muted"><?= $account_status['Classes'] ? "You have classes connected with your account" : "You do not have any class connected with your account yet." ?></p>
                                    <div>
                                        <a href="<?= base_url("EN/schools/Profile") ?>">Manage Classes<i class="uil uil-arrow-right"></i></a>
                                    </div>
                                </div>
                            </div>

                            <div class="item event-list <?= $account_status['sites'] ? "hasdone" : "notdone" ?>">
                                <div class="event-date">
                                    <div class="text-primary"><?= $account_status['sites'] ? "Done." : "Not." ?></div>
                                </div>
                                <div class="px-3">
                                    <h5>Sites for Lab Tests</h5>
                                    <p class="text-muted"><?= $account_status['sites'] ? "You have site/s connected with your account." : "We cannot find any area connected with your account." ?></p>
                                    <div>
                                        <a href="<?= $account_status['sites'] ? base_url("EN/Schools/listOfSites") : base_url("EN/Schools/AddMembers"); ?>">Manage Sites<i class="uil uil-arrow-right"></i></a>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="item event-list <?= $account_status['Areas'] ? "hasdone" : "notdone" ?>">
                                <div class="event-date">
                                    <div class="text-primary"><?= $account_status['Areas'] ? "Done." : "Not." ?></div>
                                </div>
                                <div class="px-3">
                                    <h5>Air Quality</h5>
                                    <p class="text-muted"><?= $account_status['Areas'] ? "You have areas connected with your account." : "We cannot find any area connected with your account." ?></p>
                                    <div>
                                        <a href="<?= base_url("EN/Schools/AddMembers/areas") ?>">Manage Air Quality<i class="uil uil-arrow-right"></i></a>
                                    </div>
                                </div>
                            </div>

                            <div class="item event-list <?= $account_status['Devices'] ? "hasdone" : "notdone" ?>">
                                <div class="event-date">
                                    <div class="text-primary"><?= $account_status['Devices'] ? "Done." : "Not." ?></div>
                                </div>
                                <div class="px-3">
                                    <h5>Devices (Thermometers, Labs, and Gateways)</h5>
                                    <p class="text-muted"><?= $account_status['Devices'] ? "You have devices connected with your account. " : "we can't find any devices connected with your account." ?></p>
                                    <div>
                                        <a href="<?php  echo $account_status['Devices'] ?  base_url("EN/Schools/ListofDevices") : base_url("EN/Schools/AddMembers") ?>">Manage Devices<i class="uil uil-arrow-right"></i></a>
                                    </div>
                                </div>
                            </div>

                            <div class="item event-list <?= $account_status['Staffs'] ? "hasdone" : "notdone" ?>">
                                <div class="event-date">
                                    <div class="text-primary"><?= $account_status['Staffs'] ? "Done." : "Not." ?></div>
                                </div>
                                <div class="px-3">
                                    <h5>Staff</h5> 
                                    <p class="text-muted"><?= $account_status['Staffs'] ? "You have staff connected with your account." : "you shoulde add staff to your account." ?></p>
                                    <div>
                                        <a href="<?php  echo $account_status['Staffs'] ?  base_url("EN/Schools/listOfStaff") : base_url("EN/Schools/AddMembers/staff") ?>"><?= $account_status['Staffs'] ? "Manage Staff" : "Add Staff" ?><i class="uil uil-arrow-right"></i></a>
                                    </div>
                                </div>
                            </div>

                            <div class="item event-list <?= $account_status['Teachers'] ? "hasdone" : "notdone" ?>">
                                <div class="event-date">
                                    <div class="text-primary"><?= $account_status['Teachers'] ? "Done." : "Not." ?></div>
                                </div>
                                <div class="px-3">
                                    <h5>Teachers</h5>
                                    <p class="text-muted"><?= $account_status['Teachers'] ? "You have teachers connected with your account." : "you shoulde add staff to your account." ?></p>
                                    <div>
                                        <a href="<?php  echo $account_status['Teachers'] ?  base_url("EN/Schools/listOfTeachers") : base_url("EN/Schools/AddMembers/teacher") ?>"><?= $account_status['Teachers'] ? "Manage Teachers" : "Add Teachers" ?><i class="uil uil-arrow-right"></i></a>
                                    </div>
                                </div>
                            </div>

                            <div class="item event-list <?= $account_status['Students'] ? "hasdone" : "notdone" ?>">
                                <div class="event-date">
                                    <div class="text-primary"><?= $account_status['Students'] ? "Done." : "Not." ?></div>
                                </div>
                                <div class="px-3">
                                    <h5>Students</h5>
                                    <p class="text-muted"><?= $account_status['Students'] ? "You have students connected with your account." : "you should add Students to your account." ?></p>
                                    <div>
                                        <a href="<?php  echo $account_status['Students'] ?  base_url("EN/Schools/listOfStudents") : base_url("EN/Schools/AddMembers/student") ?>"><?= $account_status['Students'] ? "Manage Students" : "Add Students" ?><i class="uil uil-arrow-right"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end card -->
            </div>
        </div>
        <script src="<?= base_url("assets/libs/owl.carousel/owl.carousel.min.js"); ?>"></script>
        <script src="<?= base_url("assets/js/pages/timeline.init.js"); ?>"></script>