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
        //Hard work!! zZZ
        //echo "Uploading";
        // start export
        $config['upload_path'] = './uploads/Csv/';
        $config['allowed_types'] = 'csv|txt';
        $config['max_size'] = '2000';
        $config['max_width'] = '1024';
        $config['max_height'] = '768';
        $config['encrypt_name'] = true;
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('csvFile')) {
            $errors = array('error' => $this->upload->display_errors());
            //    //Hard work!! zZZ
            foreach ($errors as $error) {
                echo $error . "<br>"; ?>
                <script>
                    $('.loader').remove();
                    $('.progress').remove();
                </script>
                <button type="Submit" class="btn btn-primary btn-lg btn-block waves-effect waves-light mb-1 mt-2"
                        onclick="window.location.reload();">
                    Retry
                </button>
                <?php
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
                //echo "Importing Data.....";
                while (($data = fgetcsv($h, 1000, ",")) !== FALSE) {
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
                $Api_db = $this->load->database('Api_db', TRUE);
                // $oldDb2Staff = $Api_db->query("SELECT `phone` , `nationalId` 
                // FROM `userDetails` ")->result_array();
                unset($the_big_array[0]);
                // login arrays
                $saveDataArr = array();
                $passed = array();
                $requests = array();
                $saved = 0;
                // proccess
                $password = "12345678";
                $hash_pass = password_hash($password, PASSWORD_DEFAULT);
                //echo "<script>$('.progress').show();</script>";
                //echo "Processing Data....";
                foreach ($the_big_array as $i => $array) {
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
                            "Prefix" => $prefx,
                            "F_name_EN" => $array[0],
                            "M_name_EN" => $array[1],
                            "L_name_EN" => $array[2],
                            "F_name_AR" => $array[3],
                            "M_name_AR" => $array[4],
                            "L_name_AR" => $array[5],
                            "DOP" => date('d-m-Y', strtotime($array[6])),
                            "Phone" => $array[7],
                            "Gender" => $gender,
                            "Position" => $PositionId,
                            "martial_status" => $martialId,
                            "National_Id" => $array[9],
                            "Nationality" => $array[10],
                            "Email" => $array[12],
                            "UserName" => $array[9],
                            "Password" => $hash_pass,
                            "Added_By" => $sessiondata['admin_id'],
                        ];
                        
                        $passed[] = $array[9]; // set as passed
                        //echo  $p . ' of ' . sizeof($the_big_array) . ' complete ';  //get sent immediately
                    }
                }
                if (!empty($saveDataArr)) {
                    //echo "Saving data  ,Please wait ....";
                    $this->db->truncate('l2_temp_staff');
                    if ($this->db->insert_batch('l2_temp_staff', $saveDataArr)) { ?>
                        <script>
                            $('.loader').html('<div class="success-checkmark"> <div class="check-icon"> <span class="icon-line line-tip"></span>  <span class="icon-line line-long"></span> <div class="icon-circle"></div> <div class="icon-fix"></div> </div> </div>');
                            $('.loader').css('margin-top', " -60px");
                            // setTimeout(() => {
                            //     location.href = "<?= base_url("EN/schools/csv_users_check/staff"); ?>";
                            // }, 1000);
                        </script>
                        <?php
                        echo "<script>$('.progress').hide();</script>";
                        echo 'completed , ' . $saved . ' new users has been seved !!';
                    } else {
                        print_r($this->db->error());
                        echo "No new users in this 00 file , Please upload new data"; ?>
                        <script>
                            $('.loader').remove();
                            $('.progress').remove();
                        </script>
                        <button type="Submit"
                                class="btn btn-primary btn-lg btn-block waves-effect waves-light mb-1 mt-2"
                                onclick="window.location.reload();">
                            Retry
                        </button>
                        <?php
                    }
                } else {
                    echo "No new users in this file , Please upload new data"; ?>
                    <script>
                        $('.loader').remove();
                        $('.progress').remove();
                    </script>
                    <button type="Submit" class="btn btn-primary btn-lg btn-block waves-effect waves-light mb-1 mt-2"
                            onclick="window.location.reload();">
                        Retry
                    </button>
                    <?php
                }
            } else {
                echo 'unaccepted file , Please use this <a href="' . base_url("uploads/Csv/staff_template.xlsx") . '">Template</a>';
                ?>
                <script>
                    $('.loader').remove();
                    $('.progress').remove();
                </script>
                <button type="Submit" class="btn btn-primary btn-lg btn-block waves-effect waves-light mb-1 mt-2"
                        onclick="window.location.reload();">
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
        //Hard work!! zZZ
        //echo "Uploading";
        // start export
        $config['upload_path'] = './uploads/Csv/';
        $config['allowed_types'] = 'csv|txt';
        $config['max_size'] = '2000';
        $config['max_width'] = '1024';
        $config['max_height'] = '768';
        $config['encrypt_name'] = true;
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('csvFile')) {
            $errors = array('error' => $this->upload->display_errors());
            foreach ($errors as $error) {
                echo $error . "<br>";
            }
            ?>
            <script>
                $('.loader').remove();
                $('.progress').remove();
            </script>
            <button type="Submit" class="btn btn-primary btn-lg btn-block waves-effect waves-light mb-1 mt-2"
                    onclick="window.location.reload();">
                Retry
            </button>
            <?php
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
            $AllNationals = $this->db->select("National_Id")->get("v_nationalids")->result_array();
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
                //echo "Importing Data.....";
                while (($data = fgetcsv($h, 1000, ",")) !== FALSE) {
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
                // $Api_db = $this->load->database('Api_db', TRUE);
                // $oldDb2Teachers = $Api_db->query("SELECT `phone` , `nationalId` 
                // FROM `userDetails` ")->result_array();
                unset($the_big_array[0]);
                // login arrays
                $saveDataArr = array();
                $passed = array();
                $requests = array();
                $saved = 0;
                // proccess
                $password = "12345678";
                $hash_pass = password_hash($password, PASSWORD_DEFAULT);
                //echo "<script>$('.progress').show();</script>";
                //echo "Processing Data....";
                foreach ($the_big_array as $i => $array) {
                    //echo "<script>$('.Staffprogress').attr('style', 'width: " . $this->get_percentage((sizeof($the_big_array) - 1), $i + 1) . "%');</script>"; // animate bar
                    $martialId = str_replace(array_column($martialStatus, "name"), array_column($martialStatus, "Id"), trim(strtolower($array[13])));
                    $PositionId = str_replace(array_column($Positions, "Position"), array_column($Positions, "Id"), trim(strtolower($array[11])));
                    $gender = strtolower($array[8]) == "M" ? "M" : "F";
                    $prefix = strtolower($array[8]) == "M" ? "Mr." : "Ms.";
                    $maxId = $this->db->query("SELECT MAX(Id) AS Id FROM l2_teacher WHERE Added_By = '" . $sessiondata['admin_id'] . "' ")->result_array()[0]['Id'] ?? 0;
                    if (!in_array($array[9], $oldNationals) && !in_array($array[9], $passed)) {
                        $saved++; // count as saved
                        $maxId++;
                        $saveDataArr[] = [
                            "Prefix" => $prefix,
                            "F_name_EN" => $array[0],
                            "M_name_EN" => $array[1],
                            "L_name_EN" => $array[2],
                            "F_name_AR" => $array[3],
                            "M_name_AR" => $array[4],
                            "L_name_AR" => $array[5],
                            "DOP" => date('d-m-Y', strtotime($array[6])),
                            "Phone" => $array[7],
                            "Gender" => $gender,
                            "Position" => $PositionId,
                            "martial_status" => $martialId,
                            "National_Id" => $array[9],
                            "Nationality" => $array[10],
                            "Email" => $array[12],
                            "UserName" => $array[9],
                            "Password" => $hash_pass,
                            "Added_By" => $sessiondata['admin_id'],
                            "classes" => array_unique(explode(";", $array[14]))
                        ];
                        $passed[] = $array[9]; // set as passed 
                        $p = $i + 1;
                        //echo  $p . ' of ' . sizeof($the_big_array) . ' complete ';  //get sent immediately
                    }
                }
                if (!empty($saveDataArr)) {
                    if ($this->schoolHelper->InsertNewTeacher($saveDataArr)) { ?>
                        <script>
                            $('.loader').html('<div class="success-checkmark"> <div class="check-icon"> <span class="icon-line line-tip"></span>  <span class="icon-line line-long"></span> <div class="icon-circle"></div> <div class="icon-fix"></div> </div> </div>');
                            $('.loader').css('margin-top', " -60px");
                            setTimeout(() => {
                               // location.href = "<?= base_url("EN/schools/csv_users_check/teachers"); ?>";
                            }, 1000);
                        </script>
                        <?php
                        echo "<script>$('.progress').hide();</script>";
                        echo 'completed , ' . sizeof($saveDataArr) . ' new users has been seved !!';
                    } else {
                        echo "No new users in this file , Please upload new data"; ?>
                        <script>
                            $('.loader').remove();
                            $('.progress').remove();
                        </script>
                        <button type="Submit"
                                class="btn btn-primary btn-lg btn-block waves-effect waves-light mb-1 mt-2"
                                onclick="window.location.reload();">
                            Retry
                        </button>
                        <?php
                    }
                } else {
                    echo "No new users in this file , Please upload new data";
                    ?>
                    <script>
                        $('.loader').remove();
                        $('.progress').remove();
                    </script>
                    <button type="Submit" class="btn btn-primary btn-lg btn-block waves-effect waves-light mb-1 mt-2"
                            onclick="window.location.reload();">
                        Retry
                    </button>
                    <?php
                }
            } else {
                // print_r($the_big_array);
                echo 'unaccepted file , Please use this <a href="' . base_url("uploads/Csv/teachers_template.xlsx") . '">Template</a>' . sizeof($the_big_array[0]);
                ?>
                <script>
                    $('.loader').remove();
                    $('.progress').remove();
                </script>
                <button type="Submit" class="btn btn-primary btn-lg btn-block waves-effect waves-light mb-1 mt-2"
                        onclick="window.location.reload();">
                    Retry
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
        //Hard work!! zZZ
        //echo "Uploading";
        // start export
        $config['upload_path'] = './uploads/Csv/';
        $config['allowed_types'] = 'csv|txt';
        $config['max_size'] = '2000';
        $config['max_width'] = '1024';
        $config['max_height'] = '768';
        $config['encrypt_name'] = true;
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('csvFile')) {
            $errors = array('error' => $this->upload->display_errors());
            //    //Hard work!! zZZ
            foreach ($errors as $error) {
                echo $error . "<br>";
            }
            ?>
            <script>
                $('.loader').remove();
                $('.progress').remove();
            </script>
            <button type="Submit" class="btn btn-primary btn-lg btn-block waves-effect waves-light mb-1 mt-2"
                    onclick="window.location.reload();">
                Retry
            </button>
            <?php
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
                //echo "Importing Data.....";
                while (($data = fgetcsv($h, 1000, ",")) !== FALSE) {
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
                $school_data = $this->db->get_where('l1_school', ['Id' => $sessiondata['admin_id']])->result_array()[0];
                $Api_db = $this->load->database('Api_db', TRUE);
                // $oldDb2Students = $Api_db->query("SELECT `phone` , `nationalId` 
                // FROM `userDetails` ")->result_array();
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
                $password = "12345678";
                $hash_pass = password_hash($password, PASSWORD_DEFAULT);
                //echo "<script>$('.progress').show();</script>";
                //echo "Processing Data....";
                foreach ($the_big_array as $i => $array) {
                    //echo "<script>$('.Staffprogress').attr('style', 'width: " . $this->get_percentage((sizeof($the_big_array) - 1), $i + 1) . "%');</script>"; // animate bar
                    $martialId = str_replace(array_column($martialStatus, "name"), array_column($martialStatus, "Id"), trim(strtolower($array[12])));
                    $gender = strtolower($array[8]) == "M" ? "M" : "F";
                    $prefx = strtolower($array[8]) == "M" ? "Mr." : "Ms.";
                    $class_id = str_replace(array_column($r_levels, "Class"), array_column($r_levels, "Id"), trim($array[13]));
                    if (!in_array($array[9], $oldNationals) && !in_array($array[9], $passed)) {
                        $saved++; // count as saved
                        $maxid++;
                        $saveDataArr[] = [
                            "Prefix" => $prefx,
                            "F_name_EN" => $array[0],
                            "M_name_EN" => $array[1],
                            "L_name_EN" => $array[2],
                            "F_name_AR" => $array[3],
                            "M_name_AR" => $array[4],
                            "L_name_AR" => $array[5],
                            "DOP" => date('d-m-Y', strtotime($array[6])),
                            "Phone" => $array[7],
                            "Gender" => $array[8],
                            "martial_status" => $martialId,
                            "National_Id" => $array[9],
                            "Nationality" => $array[10],
                            "Email" => $array[11],
                            "UserName" => $array[9],
                            "Password" => $hash_pass,
                            "Added_By" => $sessiondata['admin_id'],
                            "class" => $class_id,
                            "Parent_NID" => $array[14],
                            "Parent_NID_2" => $array[15]
                        ];
                        
                        $passed[] = $array[14]; // set as passed 
                        $passed[] = $array[15]; // set as passed 
                        $p = $i + 1;
                        //echo  $p . ' of ' . sizeof($the_big_array) . ' complete ';  //get sent immediately
                    }
                }
                // 
                if (!empty($saveDataArr)) {
                    //echo "Saving data  ,Please wait ....";
                    $this->db->truncate('l2_temp_student');
                    if ($this->db->insert_batch("l2_temp_student", $saveDataArr)) { ?>
                        <script>
                            $('.loader').html('<div class="success-checkmark"> <div class="check-icon"> <span class="icon-line line-tip"></span>  <span class="icon-line line-long"></span> <div class="icon-circle"></div> <div class="icon-fix"></div> </div> </div>');
                            $('.loader').css('margin-top', " -60px");
                            setTimeout(() => {
                                //location.href = "<?= base_url("EN/schools/csv_users_check/students"); ?>";
                            }, 1000);
                        </script>
                    <?php } else {
                        echo "Error in Saving The Data"; ?>
                        <script>
                            $('.loader').remove();
                            $('.progress').remove();
                        </script>
                        <button type="Submit"
                                class="btn btn-primary btn-lg btn-block waves-effect waves-light mb-1 mt-2"
                                onclick="window.location.reload();">
                            Retry
                        </button>
                        <?php
                    }
                } else {
                    echo "No new users in this file , Please upload new data"; ?>
                    <script>
                        $('.loader').remove();
                        $('.progress').remove();
                    </script>
                    <button type="Submit" class="btn btn-primary btn-lg btn-block waves-effect waves-light mb-1 mt-2"
                            onclick="window.location.reload();">
                        Retry
                    </button>
                    <?php
                }
            } else {
                echo 'unaccepted file , Please use this <a href="' . base_url("uploads/Csv/students_template.xlsx") . '">Template</a>';
                ?>
                <script>
                    $('.loader').remove();
                    $('.progress').remove();
                </script>
                <button type="Submit" class="btn btn-primary btn-lg btn-block waves-effect waves-light mb-1 mt-2"
                        onclick="window.location.reload();">
                    Retrty
                </button>
                <?php
            }
        }
    }
    public function exportco_users()
    {
        set_time_limit(0);
        ob_implicit_flush(true);
        ob_end_flush();
        session_write_close(); // prevents session lockdowns
        //Hard work!! zZZ
        //echo "Uploading";
        // start export
        $config['upload_path'] = './uploads/Csv/';
        $config['allowed_types'] = 'csv|txt';
        $config['max_size'] = '2000';
        $config['max_width'] = '1024';
        $config['max_height'] = '768';
        $config['encrypt_name'] = true;
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('csvFile')) {
            $errors = array('error' => $this->upload->display_errors());
            //    //Hard work!! zZZ
            foreach ($errors as $error) {
                echo $error . "<br>"; ?>
                <script>
                    $('.loader').remove();
                    $('.progress').remove();
                </script>
                <button type="Submit" class="btn btn-primary btn-lg btn-block waves-effect waves-light mb-1 mt-2"
                        onclick="window.location.reload();">
                    Retry
                </button>
                <?php
            }
        } else {
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
                //echo "Importing Data.....";
                while (($data = fgetcsv($h, 1000, ",")) !== FALSE) {
                    $pendCount++;
                    //echo "Importing user " . $pendCount . " ....";
                    // Each individual array is being pushed into the nested array
                    $the_big_array[] = $data;
                }
                // Close the file
                fclose($h);
            }
            $s_ar = sizeof($the_big_array[0]);
            if ($s_ar == 14 && strtolower($the_big_array[0][0]) == "user type") {
                $school_data = $this->db->get_where('l1_school', ['Id' => $sessiondata['admin_id']])->result_array()[0];
                $Api_db = $this->load->database('Api_db', TRUE);
                // $oldDb2Staff = $Api_db->query("SELECT `phone` , `nationalId` 
                // FROM `userDetails` ")->result_array();
                unset($the_big_array[0]);
                // login arrays
                $saveDataArr = array();
                $login = array();
                $national = array();
                $passed = array();
                $requests = array();
                $saved = 0;
                // proccess
                $password = "12345678";
                $hash_pass = password_hash($password, PASSWORD_DEFAULT);
                //echo "<script>$('.progress').show();</script>";
                //echo "Processing Data....";
                foreach ($the_big_array as $i => $array) {
                    //echo "<script>$('.Staffprogress').attr('style', 'width: " . $this->get_percentage((sizeof($the_big_array) - 1), $i + 1) . "%');</script>"; // animate bar
                    $gender = strtolower($array[9]) == "M" ? "M" : "F";
                    $prefx = strtolower($array[9]) == "M" ? "Mr." : "Ms.";
                    $maxstaffid = $this->db->query("SELECT MAX(Id) AS Id FROM l2_co_patient WHERE Added_By = '" . $sessiondata['admin_id'] . "' ")->result_array()[0]['Id'] ?? 0;
                    echo "Na id :" . $array[10];
                    if (!in_array($array[10], $oldNationals) && !in_array($array[10], $passed)) {
                        $maxstaffid++;
                        $saved++; // count as saved
                        $saveDataArr[] = [
                            'UserType' => $array[0],
                            'Added_By' => $sessiondata['admin_id'],
                            'F_name_EN' => $array[1],
                            'F_name_AR' => $array[4],
                            'M_name_EN' => $array[2],
                            'M_name_AR' => $array[5],
                            'L_name_AR' => $array[6],
                            'L_name_EN' => $array[3],
                            'DOP' => date('d-m-Y', strtotime($array[7])),
                            'Phone' => $array[8],
                            'Gender' => $gender,
                            'National_id' => $array[10],
                            'UserName' => $array[10],
                            'Nationality' => $array[11],
                            'Position' => $array[12],
                            'Email' => $array[13],
                            'Password' => $hash_pass,
                            'Created' => date('Y-m-d'),
                        ];
                      
                        $passed[] = $array[9]; // set as passed 
                    }
                }
                if (!empty($saveDataArr)) {
                    //echo "Saving data  ,Please wait ....";
                    $this->db->truncate('l2_co_temp_patient');
                    if ($this->db->insert_batch('l2_co_temp_patient', $saveDataArr)) { ?>
                        <script>
                            $('.loader').html('<div class="success-checkmark"> <div class="check-icon"> <span class="icon-line line-tip"></span>  <span class="icon-line line-long"></span> <div class="icon-circle"></div> <div class="icon-fix"></div> </div> </div>');
                            $('.loader').css('margin-top', " -60px");
                            setTimeout(() => {
                                location.href = "<?= base_url("EN/Company_Departments/ListOfPatients"); ?>";
                            }, 1000);
                        </script>
                        <?php
                        echo "<script>$('.progress').hide();</script>";
                        echo 'completed , ' . $saved . ' new users has been seved !!';
                    } else {
                        echo "No new users 000 in this file , Please upload new data"; ?>
                        <script>
                            $('.loader').remove();
                            $('.progress').remove();
                        </script>
                        <button type="Submit"
                                class="btn btn-primary btn-lg btn-block waves-effect waves-light mb-1 mt-2"
                                onclick="window.location.reload();">
                            Retry
                        </button>
                        <?php
                    }
                } else {
                    echo "No new users in this file , Please upload new data"; ?>
                    <script>
                        $('.loader').remove();
                        $('.progress').remove();
                    </script>
                    <button type="Submit" class="btn btn-primary btn-lg btn-block waves-effect waves-light mb-1 mt-2"
                            onclick="window.location.reload();">
                        Retry
                    </button>
                    <?php
                }
            } else {
                echo 'unaccepted file , Please use this <a href="' . base_url("uploads/Csv/staff_template.xlsx") . '">Template</a>';
                ?>
                <script>
                    $('.loader').remove();
                    $('.progress').remove();
                </script>
                <button type="Submit" class="btn btn-primary btn-lg btn-block waves-effect waves-light mb-1 mt-2"
                        onclick="window.location.reload();">
                    Retry
                </button>
            <?php }
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
        if ($this->permissions->apicopy()) {
            $Api_db = $this->load->database('Api_db', TRUE);
            if (!empty($requests)) {
                if ($Api_db->insert_batch("userDetails", $requests)) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return true;
            }
        } else {
            return true;
        }
    }
    public function users_types()
    {
        $time_start = microtime(true);
        $updated = 0;
        echo "Working on it....";
        // getting the users types
        $ids = $this->db->get('r_usertype')->result_array();
        // grouping them
        $groupedids = array();
        for ($i = 0; $i < sizeof($ids); $i++) {
            $groupedids[strtolower($ids[$i]['UserType'])] = $ids[$i]['Id'];
        }
        // getting the old data
        $staffs = $this->db->get('l2_co_patient')->result_array();
        foreach ($staffs as $staff) {
            $type = strtolower($staff['UserType']);
            if (!is_numeric($type)) { // check if it's not updated already 
                if (isset($groupedids[$type])) {
                    $this->db->where('Id', $staff['Id'])->update("l2_co_patient", ['UserType' => $groupedids[$type]]); // updating the key instead
                } else {
                    $this->db->where('Id', $staff['Id'])->update("l2_co_patient", ['UserType' => 1]); // staff by default
                }
                $updated++;
            }
        }
        echo "<br/> Done 👍<br/><br/><br/><br/>";
        $time_end = microtime(true);
        $execution_time = ($time_end - $time_start);
        echo '<br/>Fixed <b>' . $updated . '</b> Record Out Of ' . sizeof($staffs);
        echo '<br/>Total Execution Time:  <b>' . ($execution_time * 1000) . '</b>  Milliseconds';
    }
}