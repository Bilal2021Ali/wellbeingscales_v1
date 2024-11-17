<div class="card">
                                            <div class="card-body">
                                                <h4 class="card-title mb-4">
                                                    <div class="float-right">
                                                        <div class="dropdown"> <a class=" dropdown-toggle" href="#" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <span class="text-muted"><b>Select Test</b><i class="mdi mdi-chevron-down ml-1"></i></span> </a>
                                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton2" style="z-index: 100001;">
                                                                <li class="dropdown-item" onclick="Tempratur_List('#simpl_home_list','#New_home_List');">Temperature </li>
                                                                <?php foreach ($list_Tests as $test) { ?>
                                                                    <li class="dropdown-item" onClick="home_labTests('<?php echo $test['Test_Desc']; ?>');"><?php echo $test['Test_Desc']; ?></li>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </h4>
                                                <h4 class="card-title mb-4"> <img src="<?php echo base_url(); ?>assets/images/icons/png_icons/Temp_Counter.png" style="width: 25px;margin: auto 5px;"> Stay Home(<span id="STAYHOMESHOWTESTNAME">Temperature</span>) <font color=#e13e2b>(Staff, Teacher, and Student)</font>
                                                </h4>
                                                <div data-simplebar style="height: 350px;overflow: auto;">
                                                    <div id="simpl_home_list">
                                                        <?php
                                                        $listTeachers = array();
                                                        $today = date("Y-m-d");
                                                        $OurStudens = $this->db->query(" SELECT `l2_student`.* , `r_levels`.`Class` AS StudentClass 
                                                        FROM `l2_student`
                                                        JOIN `r_levels` ON `r_levels`.`Id` = `l2_student`.`Class`
                                                        WHERE Added_By = '" . $sessiondata['admin_id'] . "'  ")->result_array();
                                                        foreach ($OurStudens as $Teacher) {
                                                            $Teachername = $Teacher['F_name_EN'] . ' ' . $Teacher['L_name_EN'];
                                                            $ID = $Teacher['Id'];
                                                            $Position = $Teacher['Position'];
                                                            $getResults_Teacheer = $this->db->query("SELECT * FROM l2_result WHERE `UserId` = '" . $Teacher['Id'] . "'
                                                            AND UserType = 'Student'  AND `Action` = 'Home' ORDER BY `Time` DESC LIMIT 1")->result_array();
                                                            foreach ($getResults_Teacheer as $T_results) {
                                                                $lastReads = $this->db->query("SELECT * FROM l2_result WHERE `UserId` = '" . $Teacher['Id'] . "'
                                                                AND UserType = 'Student'  ORDER BY `Time` DESC LIMIT 1")->result_array();
                                                                $lastRead = $lastReads[0]['Result'];
                                                                $lastReadDate = $lastReads[0]['Result_Date'] . '<br>' . $lastReads[0]['Time'];
                                                                $listTeachers[] = array(
                                                                    "Username" => $Teachername, "Id" => $ID,
                                                                    "TestId" => $T_results['Id'], "Testtype" => $T_results['Device_Test'],
                                                                    "Result" => $T_results['Result'], "Creat" => (empty($Teacher['last_change_status_date']) ? "0000-00-00 00:00:00" : $Teacher['last_change_status_date']),
                                                                    "Class_OfSt" => $Teacher['StudentClass'], "LastRead" => $lastRead, "LastReadDate" => $lastReadDate
                                                                );
                                                            }
                                                        }
                                                        ?>
                                                        <table class="table table-borderless table-centered table-nowrap table_sites ">
                                                            <thead>
                                                                <th> Img </th>
                                                                <th> Name </th>
                                                                <th> Date &amp; Time </th>
                                                                <th> Result </th>
                                                                <th> Risk </th>
                                                                <th> Days </th>
                                                                <th> Action </th>
                                                            </thead>
                                                            <tbody>
                                                                <?php foreach ($listTeachers as $sn=>$TeacherRes) { ?>
                                                                    <tr>
                                                                        <td style="width: 20px;"><?php $avatar = $this->db->query("SELECT * FROM `l2_avatars`
                                                                            WHERE `For_User` = '" . $TeacherRes['Id'] . "' AND `Type_Of_User` = 'Student' LIMIT 1 ")->result_array(); ?>
                                                                            <?php if (empty($avatar)) {  ?>
                                                                                <img src="<?php echo base_url(); ?>uploads/avatars/default_avatar.jpg" class="avatar-xs rounded-circle " alt="...">
                                                                            <?php } else { ?>
                                                                                <img src="<?php echo base_url(); ?>uploads/avatars/<?php echo $avatar[0]['Link']; ?>" class="avatar-xs rounded-circle " alt="...">
                                                                            <?php } ?>
                                                                        </td>
                                                                        <td>
                                                                            <h6 class="mb-1 font-weight-normal" style="font-size: 15px;"><?php echo $TeacherRes['Username']; ?></h6>
                                                                            <p class="text-muted font-size-13 mb-0"><i class="mdi mdi-user"></i><?php echo $TeacherRes['Class_OfSt']; ?></p>
                                                                        </td>
                                                                        <td style="font-size: 12px;"><?php echo $TeacherRes['LastReadDate']; ?></td>
                                                                        <?php boxes_Colors($TeacherRes['LastRead']); ?>
                                                                        <td><?php
                                                                            $from_craet = $TeacherRes['Creat'];
                                                                            //echo $from_craet;
                                                                            //$toTime = $today-$from_craet;
                                                                            $finalDate = dateDiffInDays($from_craet, $today);
                                                                            if ($finalDate == 0) {
                                                                                echo "Today";
                                                                            } elseif ($finalDate > 2) {
                                                                                echo $finalDate . " Days";
                                                                            } else {
                                                                                echo $finalDate . " Day";
                                                                            }
                                                                            ?></td>
                                                                        <td class="out"><img src="<?php echo base_url(); ?>assets/images/icons/png_icons/cancel.png" onClick="RemoveThisMemberFrom(<?php echo $TeacherRes['Id']; ?>,'Student','School');" width="14px" data-toggle="tooltip" data-placement="top" title="" data-original-title="Exit"></td>
                                                                    </tr>
                                                                <?php } ?>
                                                                <?php StayHomeOf('Teacher'); ?>
                                                                <?php StayHomeOf('Staff'); ?>
                                                            </tbody>

                                                        </table>
                                                    </div>
                                                    <!-- end simpl_home_list  -->
                                                    <div id="New_home_List"></div>
                                                </div>
                                                <!-- data-sidebar-->
                                            </div>
                                            <!-- end card-body-->
                                        </div>