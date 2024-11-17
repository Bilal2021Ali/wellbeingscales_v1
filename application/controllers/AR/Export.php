<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Export extends CI_Controller
{


    public function exportstaff()
    {
        set_time_limit(0);
        ob_implicit_flush(true);
        ob_end_flush();
        session_write_close(); // prevents session lockdowns
        sleep(1);   //Hard work!! zZZ
        //echo "Uploading";
        // start export
        $config['upload_path'] = './uploads/Csv/';
        $config['allowed_types'] = 'csv|txt';
        $config['max_size'] = '2000';
        $config['max_width'] = '1024';
        $config['max_height'] = '768';
        $config['encrypt_name']     = true;
        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('csvFile')) {
            $errors = array('error' => $this->upload->display_errors());
            sleep(1);   //Hard work!! zZZ
            foreach ($errors as $error) {
                //echo $error . "<br>";
            }
        } else {
            //echo "Preparing data....";
            // translating martial Status to id 
            $martialStatus = $this->db->get("l2_martial_status")->result_array();
            foreach ($martialStatus as $index => $martial) {
                $martialStatus[$index]['name'] = trim(strtolower($martial['name']));
            }
            // translating position to id 
            $Positions = $this->db->get("r_positions_sch")->result_array();
            foreach ($Positions as $index => $Position) {
                $Positions[$index]['Position'] = trim(strtolower($Position['Position']));
            }
            // national ids check
            $AllNationals = $this->db->get("v_nationalids")->result_array();
            $oldNationals = array_column($AllNationals, "National_Id");
            // start exporting
            $filename = $data = $this->upload->data()["file_name"];
            $this->load->library('session');
            $sessiondata = $this->session->userdata('admin_details');
            $pendCount = 0;
            // The nested array to hold all the arrays
            $the_big_array = [];
            // Open the file for reading
            if (($h = fopen("./uploads/Csv/{$filename}", "r")) !== FALSE) {
                sleep(1);
                //echo "Importing Data.....";
                while (($data = fgetcsv($h, 1000, ",")) !== FALSE) {
                    sleep(1);
                    $pendCount++;
                    //echo "Importing user " . $pendCount . " ....";
                    // Each individual array is being pushed into the nested array
                    $the_big_array[] = $data;
                }
                // Close the file
                fclose($h);
            }

            $s_ar = sizeof($the_big_array[0]);
            if ($s_ar == 14) {
                $school_data = $this->db->get_where('l1_school', ['Id' => $sessiondata['admin_id']])->result_array()[0];
                unset($the_big_array[0]);
                // login arrays
                $saveDataArr = array();
                $login = array();
                $national = array();
                $passed = array();
                $requests = array();
                $saved = 0;
                // proccess
                $password =  "NEWSTAFF";
                $hash_pass = password_hash("12345678", PASSWORD_DEFAULT);
                sleep(1);
                //echo "<script>$('.progress').show();</script>";
                //echo "Processing Data....";
                foreach ($the_big_array as $i => $array) {
                    sleep(0.5);
                    //echo "<script>$('.Staffprogress').attr('style', 'width: " . $this->get_percentage((sizeof($the_big_array) - 1), $i + 1) . "%');</script>"; // animate bar
                    $martialId = str_replace(array_column($martialStatus, "name"), array_column($martialStatus, "Id"), trim(strtolower($array[13])));
                    $PositionId = str_replace(array_column($Positions, "Position"), array_column($Positions, "Id"), trim(strtolower($array[11])));
                    $gender = strtolower($array[8]) == "M" ? "M" : "F";
                    $prefx = strtolower($array[8]) == "M" ? "Mr." : "Ms.";
                    $maxstaffid = $this->db->query("SELECT MAX(Id) AS Id FROM l2_staff WHERE Added_By = '" . $sessiondata['admin_id'] . "' ")->result_array()[0]['Id'] ?? 0;
                    if (!in_array($array[9], $oldNationals) && !in_array($array[9], $passed)) {
                        $maxstaffid++;
                        $saved++; // count as saved
                        $saveDataArr[] = [
                            "Prefix"         => $prefx,
                            "F_name_EN"      => $array[0],
                            "M_name_EN"      => $array[1],
                            "L_name_EN"      => $array[2],
                            "F_name_AR"      => $array[3],
                            "M_name_AR"      => $array[4],
                            "L_name_AR"      => $array[5],
                            "DOP"            => date('d-m-Y', strtotime($array[6])),
                            "Phone"          => $array[7],
                            "Gender"         => $gender,
                            "Position"       => $PositionId,
                            "martial_status" => $martialId,
                            "National_Id"    => $array[9],
                            "Nationality"    => $array[10],
                            "Email"          => $array[12],
                            "UserName"       => $array[9],
                            "Password"       => $hash_pass,
                            "Added_By"       => $sessiondata['admin_id'],
                            "adding_method"  => "csv",
                        ];

                        $login[] = [
                            'Username'    => $array[9],
                            'Password'    => $hash_pass,
                            'Type'        => 'Staff',
                        ];

                        $national[] = [
                            'National_Id' => $array[9],
                            'Geted_From'  => 'Staff',
                        ];

                        $requests[] = [
                            // "type"  => "" ,
                            "email" => $array[12],
                            "Phone" => $array[7],
                            "password" => "6da107edeae065bd6a3faaf8b7bbae28",
                            "reg_id" => $maxstaffid,
                            "device_type" => "IOS",
                            "language" => "English",
                            "lat" => "",
                            "log" => "",
                            "iso_from_registar" => "iso",
                            "city_name" => "city",
                            "tracksystem" => "1",
                            "country_id" => $array[10],
                            "companyName" => $school_data['School_Name_EN'] ?? "",
                            "nationalId" => $array[9],
                            "username" => $array[0] . " " . $array[1] . " " . $array[2],
                            "gender" => ($gender == "M" ? "Male" : "Female"),
                            "date_of_birth" =>  date('d-m-Y', strtotime($array[6])),
                            "watch_mac" => "",
                            "usertype" => "Staff",
                            "companytype" => "School",
                            "companyid" => $sessiondata['admin_id'],
                        ];

                        $passed[] = $array[9]; // set as passed 


                        sleep(1);
                        $p = $i + 1;
                        //echo  $p . ' of ' . sizeof($the_big_array) . ' complete ';  //get sent immediately
                    }
                }
                sleep(1);
                if (!empty($national) && !empty($login) && !empty($saveDataArr) && $this->api_copy($requests)) {
                    //echo "Saving data  ,Please wait ....";
                    if ($this->db->insert_batch('l2_staff', $saveDataArr)) {
                        sleep(1); ?>
                        <script>
                            $('.loader').html('<div class="success-checkmark"> <div class="check-icon"> <span class="icon-line line-tip"></span>  <span class="icon-line line-long"></span> <div class="icon-circle"></div> <div class="icon-fix"></div> </div> </div>');
                            $('.loader').css('margin-top', " -60px");
                            // setTimeout(() => {
                            //     location.href = "<?= base_url("AR/schools/csv_users_check/staff"); ?>";
                            // }, 1000);
                        </script>
                    <?php
                        echo "<script>$('.progress').hide();</script>";
                        echo 'completed , ' . $saved . ' new users has been seved !!';
                    } else {
                        sleep(1);
                        echo "No new users in this file , Please upload new data"; ?>
                        <script>
                            $('.loader').remove();
                            $('.progress').remove();
                        </script>
                        <button type="Submit" class="btn btn-primary btn-lg btn-block waves-effect waves-light mb-1 mt-2" onclick="window.location.reload();">
                            Retry
                        </button>
                    <?php
                    }
                } else {
                    sleep(1);
                    echo "No new users in this file , Please upload new data"; ?>
                    <script>
                        $('.loader').remove();
                        $('.progress').remove();
                    </script>
                    <button type="Submit" class="btn btn-primary btn-lg btn-block waves-effect waves-light mb-1 mt-2" onclick="window.location.reload();">
                        Retry
                    </button>
                <?php
                }
            } else {
                sleep(1);
                echo 'unaccepted file , Please use this <a href="' . base_url("uploads/Csv/staff_template.xlsx") . '">Template</a>';
                ?>
                <script>
                    $('.loader').remove();
                    $('.progress').remove();
                </script>
                <button type="Submit" class="btn btn-primary btn-lg btn-block waves-effect waves-light mb-1 mt-2" onclick="window.location.reload();">
                    Retrty
                </button>
                <?php
            }
        }
    }


    public function exportteachers()
    {
        set_time_limit(0);
        ob_implicit_flush(true);
        ob_end_flush();
        session_write_close(); // prevents session lockdowns
        sleep(1);   //Hard work!! zZZ
        //echo "Uploading";
        // start export
        $config['upload_path'] = './uploads/Csv/';
        $config['allowed_types'] = 'csv|txt';
        $config['max_size'] = '2000';
        $config['max_width'] = '1024';
        $config['max_height'] = '768';
        $config['encrypt_name']     = true;
        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('csvFile')) {
            $errors = array('error' => $this->upload->display_errors());
            sleep(1);   //Hard work!! zZZ
            foreach ($errors as $error) {
                //echo $error . "<br>";
            }
        } else {
            //echo "Preparing data....";
            // translating martial Status to id 
            $martialStatus = $this->db->get("l2_martial_status")->result_array();
            foreach ($martialStatus as $index => $martial) {
                $martialStatus[$index]['name'] = trim(strtolower($martial['name']));
            }
            // translating position to id 
            $Positions = $this->db->get("r_positions_tech")->result_array();
            foreach ($Positions as $index => $Position) {
                $Positions[$index]['Position'] = trim(strtolower($Position['Position']));
            }
            // national ids check
            $AllNationals = $this->db->get("v_nationalids")->result_array();
            $oldNationals = array_column($AllNationals, "National_Id");
            // start exporting
            $filename = $data = $this->upload->data()["file_name"];
            $this->load->library('session');
            $sessiondata = $this->session->userdata('admin_details');
            $pendCount = 0;
            // The nested array to hold all the arrays
            $the_big_array = [];
            // Open the file for reading
            if (($h = fopen("./uploads/Csv/{$filename}", "r")) !== FALSE) {
                sleep(1);
                //echo "Importing Data.....";
                while (($data = fgetcsv($h, 1000, ",")) !== FALSE) {
                    sleep(1);
                    $pendCount++;
                    //echo "Importing user " . $pendCount . " ....";
                    // Each individual array is being pushed into the nested array
                    $the_big_array[] = $data;
                }
                // Close the file
                fclose($h);
            }

            $s_ar = sizeof($the_big_array[0]);
            if ($s_ar == 15) {
                $school_data = $this->db->get_where('l1_school', ['Id' => $sessiondata['admin_id']])->result_array()[0];
                unset($the_big_array[0]);
                // login arrays
                $saveDataArr = array();
                $login = array();
                $national = array();
                $passed = array();
                $requests = array();
                $saved = 0;
                // proccess
                $password =  "NEWSTAFF";
                $hash_pass = password_hash("12345678", PASSWORD_DEFAULT);
                sleep(1);
                //echo "<script>$('.progress').show();</script>";
                //echo "Processing Data....";
                foreach ($the_big_array as $i => $array) {
                    sleep(0.5);
                    //echo "<script>$('.Staffprogress').attr('style', 'width: " . $this->get_percentage((sizeof($the_big_array) - 1), $i + 1) . "%');</script>"; // animate bar
                    $martialId = str_replace(array_column($martialStatus, "name"), array_column($martialStatus, "Id"), trim(strtolower($array[13])));
                    $PositionId = str_replace(array_column($Positions, "Position"), array_column($Positions, "Id"), trim(strtolower($array[11])));
                    $gender = strtolower($array[8]) == "M" ? 1 : 0;
                    $prefx = strtolower($array[8]) == "M" ? "Mr." : "Ms.";
                    $maxid = $this->db->query("SELECT MAX(Id) AS Id FROM l2_teacher WHERE Added_By = '" . $sessiondata['admin_id'] . "' ")->result_array()[0]['Id'] ?? 0;
                    if (!in_array($array[9], $oldNationals) && !in_array($array[9], $passed)) {
                        $saved++; // count as saved
                        $maxid++;
                        $saveDataArr[] = [
                            "Prefix"         => $prefx,
                            "F_name_EN"      => $array[0],
                            "M_name_EN"      => $array[1],
                            "L_name_EN"      => $array[2],
                            "F_name_AR"      => $array[3],
                            "M_name_AR"      => $array[4],
                            "L_name_AR"      => $array[5],
                            "DOP"            => date('d-m-Y', strtotime($array[6])),
                            "Phone"          => $array[7],
                            "Gender"         => $gender,
                            "Position"       => $PositionId,
                            "martial_status" => $martialId,
                            "National_Id"    => $array[9],
                            "Nationality"    => $array[10],
                            "Email"          => $array[12],
                            "UserName"       => $array[9],
                            "Password"       => $hash_pass,
                            "Added_By"       => $sessiondata['admin_id'],
                            "adding_method"  => "csv",
                            "classes"        => array_unique(explode(";", $array[14]))
                        ];

                        $login[] = [
                            'Username'    => $array[9],
                            'Password'    => $hash_pass,
                            'Type'        => 'Teacher',
                        ];

                        $national[] = [
                            'National_Id' => $array[9],
                            'Geted_From'  => 'Teacher',
                        ];


                        $requests[] = [
                            // "type"  => "" ,
                            "email" => $array[12],
                            "Phone" => $array[7],
                            "password" => "6da107edeae065bd6a3faaf8b7bbae28",
                            "reg_id" => $maxid,
                            "device_type" => "IOS",
                            "language" => "English",
                            "lat" => "",
                            "log" => "",
                            "iso_from_registar" => "iso",
                            "city_name" => "city",
                            "tracksystem" => "1",
                            "country_id" => $array[10],
                            "companyName" => $school_data['School_Name_EN'] ?? "",
                            "nationalId" => $array[9],
                            "username" => $array[0] . " " . $array[1] . " " . $array[2],
                            "gender" => ($gender == "M" ? "Male" : "Female"),
                            "date_of_birth" =>  date('d-m-Y', strtotime($array[6])),
                            "watch_mac" => "",
                            "usertype" => "Teacher",
                            "companytype" => "School",
                            "companyid" => $sessiondata['admin_id'],
                        ];

                        $passed[] = $array[9]; // set as passed 

                        sleep(1);
                        $p = $i + 1;
                        //echo  $p . ' of ' . sizeof($the_big_array) . ' complete ';  //get sent immediately
                    }
                }
                sleep(1);
                if (!empty($national) && !empty($login) && !empty($saveDataArr) && $this->api_copy($requests)) {
                    //echo "Saving data  ,Please wait ....";
                    if ($this->schoolHelper->InsertNewTeacher($saveDataArr) && $this->db->insert_batch('v_login', $login) && $this->db->insert_batch('v_nationalids', $national)) {
                        // print_r($this->db->error());
                        sleep(1); ?>
                        <script>
                            $('.loader').html('<div class="success-checkmark"> <div class="check-icon"> <span class="icon-line line-tip"></span>  <span class="icon-line line-long"></span> <div class="icon-circle"></div> <div class="icon-fix"></div> </div> </div>');
                            $('.loader').css('margin-top', " -60px");
                            setTimeout(() => {
                                location.href = "<?= base_url("AR/schools/csv_users_check/teachers"); ?>";
                            }, 1000);
                        </script>
                    <?php
                        echo "<script>$('.progress').hide();</script>";
                        echo 'completed , ' . $saved . ' new users has been seved !!';
                    } else {
                        sleep(1);
                        echo "No new users in this file , Please upload new data"; ?>
                        <script>
                            $('.loader').remove();
                            $('.progress').remove();
                        </script>
                        <button type="Submit" class="btn btn-primary btn-lg btn-block waves-effect waves-light mb-1 mt-2" onclick="window.location.reload();">
                            Retry
                        </button>
                    <?php
                    }
                } else {
                    sleep(1);
                    //echo "No new users in this file , Please upload new data"; 
                    ?>
                    <script>
                        $('.loader').remove();
                        $('.progress').remove();
                    </script>
                    <button type="Submit" class="btn btn-primary btn-lg btn-block waves-effect waves-light mb-1 mt-2" onclick="window.location.reload();">
                        Retry
                    </button>
                <?php
                }
            } else {
                sleep(1);
                echo 'unaccepted file , Please use this <a href="' . base_url("uploads/Csv/teachers_template.xlsx") . '">Template</a>' . sizeof($the_big_array[0]);
                ?>
                <script>
                    $('.loader').remove();
                    $('.progress').remove();
                </script>
                <button type="Submit" class="btn btn-primary btn-lg btn-block waves-effect waves-light mb-1 mt-2" onclick="window.location.reload();">
                    Retrty
                </button>
                <?php
            }
        }
    }

    public function exportstudents()
    {
        set_time_limit(0);
        ob_implicit_flush(true);
        ob_end_flush();
        session_write_close(); // prevents session lockdowns
        sleep(1);   //Hard work!! zZZ
        //echo "Uploading";
        // start export
        $config['upload_path'] = './uploads/Csv/';
        $config['allowed_types'] = 'csv|txt';
        $config['max_size'] = '2000';
        $config['max_width'] = '1024';
        $config['max_height'] = '768';
        $config['encrypt_name']     = true;
        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('csvFile')) {
            $errors = array('error' => $this->upload->display_errors());
            sleep(1);   //Hard work!! zZZ
            foreach ($errors as $error) {
                //echo $error . "<br>";
            }
        } else {
            //echo "Preparing data....";
            // translating martial Status to id 
            $martialStatus = $this->db->get("l2_martial_status")->result_array();
            foreach ($martialStatus as $index => $martial) {
                $martialStatus[$index]['name'] = trim(strtolower($martial['name']));
            }
            // translating position to id 
            $Positions = $this->db->get("r_positions_tech")->result_array();
            foreach ($Positions as $index => $Position) {
                $Positions[$index]['Position'] = trim(strtolower($Position['Position']));
            }
            // national ids check
            $AllNationals = $this->db->get("v_nationalids")->result_array();
            $oldNationals = array_column($AllNationals, "National_Id");
            $r_levels = $this->db->get("r_levels")->result_array();
            // parents check
            $parents_regestred = array_column($this->db->get_where('v_login', ["Type" => "Parent"])->result_array(), "Username");
            // start exporting
            $filename = $data = $this->upload->data()["file_name"];
            $this->load->library('session');
            $sessiondata = $this->session->userdata('admin_details');
            $pendCount = 0;
            // The nested array to hold all the arrays
            $the_big_array = [];
            // Open the file for reading
            if (($h = fopen("./uploads/Csv/{$filename}", "r")) !== FALSE) {
                sleep(1);
                //echo "Importing Data.....";
                while (($data = fgetcsv($h, 1000, ",")) !== FALSE) {
                    sleep(1);
                    $pendCount++;
                    //echo "Importing user " . $pendCount . " ....";
                    // Each individual array is being pushed into the nested array
                    $the_big_array[] = $data;
                }
                // Close the file
                fclose($h);
            }

            $s_ar = sizeof($the_big_array[0]);
            if ($s_ar == 16) {
                $maxid = $this->db->query("SELECT MAX(Id) AS Id FROM l2_student WHERE Added_By = '" . $sessiondata['admin_id'] . "' ")->result_array()[0]['Id'] ?? 0;
                unset($the_big_array[0]);
                // login arrays
                $saveDataArr = array();
                $login = array();
                $national = array();
                $passed = array();
                $saved = 0;
                $requests = array();
                // proccess
                $password =  "NEWUSER";
                $hash_pass = password_hash("12345678", PASSWORD_DEFAULT);
                sleep(1);
                //echo "<script>$('.progress').show();</script>";
                //echo "Processing Data....";
                foreach ($the_big_array as $i => $array) {
                    sleep(0.5);
                    //echo "<script>$('.Staffprogress').attr('style', 'width: " . $this->get_percentage((sizeof($the_big_array) - 1), $i + 1) . "%');</script>"; // animate bar
                    $martialId = str_replace(array_column($martialStatus, "name"), array_column($martialStatus, "Id"), trim(strtolower($array[12])));
                    $gender = strtolower($array[8]) == "M" ? 1 : 0;
                    $prefx = strtolower($array[8]) == "M" ? "Mr." : "Ms.";
                    $class_id = str_replace(array_column($r_levels, "Class"), array_column($r_levels, "Id"), trim($array[13]));
                    if (!in_array($array[9], $oldNationals) && !in_array($array[9], $passed)) {
                        $saved++; // count as saved
                        $maxid++;
                        $saveDataArr[] = [
                            "Prefix"         => $prefx,
                            "F_name_EN"      => $array[0],
                            "M_name_EN"      => $array[1],
                            "L_name_EN"      => $array[2],
                            "F_name_AR"      => $array[3],
                            "M_name_AR"      => $array[4],
                            "L_name_AR"      => $array[5],
                            "DOP"            => date('d-m-Y', strtotime($array[6])),
                            "Phone"          => $array[7],
                            "Gender"         => $gender,
                            "martial_status" => $martialId,
                            "National_Id"    => $array[9],
                            "Nationality"    => $array[10],
                            "Email"          => $array[11],
                            "UserName"       => $array[9],
                            "Password"       => $hash_pass,
                            "Added_By"       => $sessiondata['admin_id'],
                            "adding_method"  => "csv",
                            "class"          => $class_id,
                            "Parent_NID"     => $array[14],
                            "Parent_NID_2"   => $array[15]
                        ];

                        if (!in_array($array[14], $parents_regestred)) {
                            $login[] = [
                                'Username'    => $array[14],
                                'Password'    => $hash_pass,
                                'Type'        => 'Parent',
                            ];
                            $parents_regestred[] = $array[14];
                        }

                        if (!in_array($array[15], $parents_regestred)) {
                            $login[] = [
                                'Username'    => $array[15],
                                'Password'    => $hash_pass,
                                'Type'        => 'Parent',
                            ];
                            $parents_regestred[] = $array[15];
                        }

                        $national[] = [
                            'National_Id' => $array[9],
                            'Geted_From'  => 'Student',
                        ];

                        $age = explode('-', date('d-m-Y', strtotime($array[6])));
                        $thisyear = date('Y');
                        $finalyage = $thisyear - $age[2];
                        if ($finalyage > 12) {
                            $login[] = [
                                'Username'    => $array[9],
                                'Password'    => $hash_pass,
                                'Type'        => 'Student',
                            ];
                        }

                        $requests[] = [
                            // "type"  => "" ,
                            "email" => $array[9],
                            "Phone" => $array[9],
                            "password" => "6da107edeae065bd6a3faaf8b7bbae28",
                            "reg_id" => $maxid,
                            "device_type" => "IOS",
                            "language" => "English",
                            "lat" => "",
                            "log" => "",
                            "iso_from_registar" => "iso",
                            "city_name" => "city",
                            "tracksystem" => "1",
                            "country_id" => $array[10],
                            "companyName" => $school_data['School_Name_EN'] ?? "",
                            "nationalId" => $array[9],
                            "username" => $array[0] . " " . $array[1] . " " . $array[2],
                            "gender" => ($gender == "M" ? "Male" : "Female"),
                            "date_of_birth" =>  date('d-m-Y', strtotime($array[6])),
                            "watch_mac" => "",
                            "usertype" => "Student",
                            "companytype" => "School",
                            "companyid" => $sessiondata['admin_id'],
                        ];

                        $passed[] = $array[14]; // set as passed 
                        $passed[] = $array[15]; // set as passed 

                        sleep(1);
                        $p = $i + 1;
                        //echo  $p . ' of ' . sizeof($the_big_array) . ' complete ';  //get sent immediately
                    }
                }
                sleep(1);
                if (!empty($national) && !empty($login) && !empty($saveDataArr) && $this->api_copy($requests)) {
                    //echo "Saving data  ,Please wait ....";
                    if ($this->db->insert_batch("l2_student", $saveDataArr)) {
                        sleep(1);
                        //echo "<script>$('.progress').hide();</script>";
                        //echo 'completed , ' . $saved . ' new users has been seved !!';
                ?>
                        <script>
                            $('.loader').html('<div class="success-checkmark"> <div class="check-icon"> <span class="icon-line line-tip"></span>  <span class="icon-line line-long"></span> <div class="icon-circle"></div> <div class="icon-fix"></div> </div> </div>');
                            $('.loader').css('margin-top', " -60px");
                            setTimeout(() => {
                                location.href = "<?= base_url("AR/schools/csv_users_check/students"); ?>";
                            }, 1000);
                        </script>
                    <?php } else {
                        sleep(1);
                        echo "No new users in this file , Please upload new data"; ?>
                        <script>
                            $('.loader').remove();
                            $('.progress').remove();
                        </script>
                        <button type="Submit" class="btn btn-primary btn-lg btn-block waves-effect waves-light mb-1 mt-2" onclick="window.location.reload();">
                            Retry
                        </button>
                    <?php
                    }
                } else {
                    sleep(1);
                    echo "No new users in this file , Please upload new data"; ?>
                    <script>
                        $('.loader').remove();
                        $('.progress').remove();
                    </script>
                    <button type="Submit" class="btn btn-primary btn-lg btn-block waves-effect waves-light mb-1 mt-2" onclick="window.location.reload();">
                        Retry
                    </button>
                <?php
                }
            } else {
                sleep(1);
                echo 'unaccepted file , Please use this <a href="' . base_url("uploads/Csv/students_template.xlsx") . '">Template</a>';
                ?>
                <script>
                    $('.loader').remove();
                    $('.progress').remove();
                </script>
                <button type="Submit" class="btn btn-primary btn-lg btn-block waves-effect waves-light mb-1 mt-2" onclick="window.location.reload();">
                    Retrty
                </button>
<?php
            }
        }
    }

    private function get_percentage($total, $number)
    {
        if ($total > 0) {
            return round($number / ($total / 100), 2);
        } else {
            return 0;
        }
    }

    private function api_copy($requests)
    {
        if($this->permissions->apicopy()){
            foreach ($requests as $request) {
                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => 'https://qlickhealth.com/admin/api/user/OTPLogin',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => json_encode($request),
                ));
                $response = curl_exec($curl);
                $response = json_decode($response, true);
                curl_close($curl);
            }
            return true;
        }else{
            return true;
        }
    }
}
