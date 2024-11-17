    <link href="<?= base_url('assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css'); ?>" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url("assets/libs/@chenfengyuan/datepicker/datepicker.min.css"); ?>">
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    <!-- jsFiddle will insert css and js -->
    <style>
        /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
        #gmaps-overlay {
            height: 900px;
        }

        .br-r {
            border-right: 1px solid #e2e2e2;
        }

        .infowindowcontent-result {
            height: 422px !important;
            overflow: auto;
        }

        .gm-style-iw-d {
            overflow: auto;
            height: 422px !important;
        }

        .gmaps-overlay {
            line-height: 20px !important;
            box-shadow: 1px 3px 10px 0px rgb(0 0 0 / 31%);
        }

        .gmaps-overlay.background-success {
            background-color: #34c38f !important;
        }

        .gmaps-overlay.background-danger {
            background-color: #f46a6a !important;
        }

        .gmaps-overlay p {
            margin: 0px;
            font-size: 12px;
        }

        .gmaps-overlay.background-success .above {
            border-top: 16px solid #34c38f !important;
        }

        .gmaps-overlay.background-danger .above {
            border-top: 16px solid #f46a6a !important;
        }
    </style>

    <div class="main-content">
        <div class="page-content">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">خارطة النتائج</h4>
                    <p class="card-title-desc"> انقر فوق المدرسة لرؤية نتائج اليوم</p>
                    <hr>
                    <form action="" method="post">
                        <div class="row">
                            <div class="col-lg-6">
                                <label class="form-label">الفترة الزمنية (للنتائج) <span class="text-danger">*</span>:</label>
                                <div class="input-daterange input-group" id="datepicker6" data-date-format="yyyy-mm-dd" data-date-autoclose="true" data-provide="datepicker" data-date-container='#datepicker6'>
                                    <input type="text" class="form-control" name="start" autocomplete="off" value="<?= $startdate ?>" placeholder="من تاريخ" />
                                    <input type="text" class="form-control" name="end" autocomplete="off" value="<?= $enddate ?>" placeholder="إلى تاريخ" />
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label class="form-label">عرض (علامات الألوان) <span class="text-danger">*</span>:</label>
                                <select class="form-control" name="colorsInOrderBy" id="colorsInOrderBy">
                                    <option value="Temperature" <?= $alertby == "Temperature" ? "selected" : "" ?>>درجات الحرارة</option>
                                    <option value="Lab" <?= $alertby == "Lab" ? "selected" : "" ?>>الفحوصات المخبرية</option>
                                    <option value="الحجر الصحي" <?= $alertby == "الحجر الصحي" ? "selected" : "" ?>>الحجر الصحي</option>
                                    <option value="الحجر المنزلي" <?= $alertby == "الحجر المنزلي" ? "selected" : "" ?>>الحجر المنزلي</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-primary w-100 mt-2" type="submit"> العرض </button>
                            </div>
                        </div>
                    </form>
                    <hr>
                    <div id="gmaps-overlay" class="gmaps"></div>
                </div>
            </div>
            <div class="col-12 hidden">
                <?php foreach ($schools as $sn => $school) { ?>
                    <?php
                    $results = array(
                        "low" => GetTotalIn_all($school['Id'], 0, 36.2, $startdate, $enddate),
                        "normal" => GetTotalIn_all($school['Id'], 36.3, 37.5, $startdate, $enddate),
                        "moderate" => GetTotalIn_all($school['Id'], 37.6, 38.4, $startdate, $enddate),
                        "high" => GetTotalIn_all($school['Id'], 38.5, 45, $startdate, $enddate),
                    );
                    ?>
                    <div class="row infowindowcontent-result result-<?= $school['Id'] ?>">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <h3 class="card-title text-center">Temperature</h3>
                                    <hr>
                                    <div class="p-4">
                                        <div class="col-xl-12 InfosCards text-center">
                                            <div class="card">
                                                <div class="card-body" style="padding: 0px;border: 6px solid #387cea;">
                                                    <div class="card-body badge-soft-info">
                                                        <div class="float-left mt-2"> <img src="<?= base_url() ?>assets/images/icons/png_icons/Blue.png" alt="Temperature" style="width: 30px;margin-top: -12px;"> </div>
                                                        <div class="col-lg-10">
                                                            <h4 class="mb-1 mt-1" style="color: #033067;"> <span data-plugin="counterup"><?= $results['low'] ?></span> </h4>
                                                            <p class="mb-0" style="color: #033067;"> Low Temperature </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-12 InfosCards text-center alerts_count">
                                            <div class="card">
                                                <div class="card-body" style="padding: 0px;border: 6px solid #34ccc7;">
                                                    <div class="card-body badge-soft-success">
                                                        <div class="float-left mt-2"> <img src="<?= base_url() ?>assets/images/icons/png_icons/green.png" alt="Temperature" style="width: 30px;"> </div>
                                                        <div class="col-xl-10">
                                                            <h4 class="mb-1 mt-1" style="color: #044300;"><span data-plugin="counterup"><?= $results['normal'] ?></span></h4>
                                                            <p class="mb-0" style="color: #044300;"> Normal Temperature </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-12 InfosCards text-center">
                                            <div class="card">
                                                <div class="card-body" style="padding: 0px;border: 6px solid #FF9600;">
                                                    <div class="card-body badge-soft-warning">
                                                        <div class="float-left mt-2"> <img src="<?= base_url() ?>assets/images/icons/png_icons/orange.png" alt="Temperature" style="width: 30px;"> </div>
                                                        <div class="col-xl-10">
                                                            <h4 class="mb-1 mt-1" style="color: #674403;"> <span data-plugin="counterup"><?= $results['moderate'] ?></span> </h4>
                                                            <p class="mb-0" style="color: #674403;"> Moderate Temperature</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-12 InfosCards text-center">
                                            <div class="card">
                                                <div class="card-body" style="padding: 0px;border: 6px solid #f57d6a;">
                                                    <div class="card-body badge-soft-danger">
                                                        <div class="float-left mt-2"> <img src="<?= base_url() ?>assets/images/icons/png_icons/red.png" alt="Temperature" style="width: 30px;"> </div>
                                                        <div class="col-xl-10">
                                                            <h4 class="mb-1 mt-1"> <span data-plugin="counterup" style="color: #670303;"><?= $results['high'] ?></span> </h4>
                                                            <p class="mb-0" style="color: #670303;"> High Temperature </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <h3 class="card-title text-center">Lab tests</h3>
                                    <hr>
                                    <div class="col-xl-12 InfosCards text-center">
                                        <div class="card">
                                            <div class="card-body" style="padding: 0px;border: 6px solid #f57d6a;">
                                                <div class="card-body badge-soft-danger">
                                                    <div class="float-left mt-2"> <img src="<?= base_url("assets/images/icons/png_icons/red.png") ?>" alt="Temperature" style="width: 30px;"> </div>
                                                    <div class="col-xl-10">
                                                        <h4 class="mb-1 mt-1"> <span data-plugin="counterup" style="color: #670303;"><?= GetTotal($school['Id'], "1", "", $startdate, $enddate) ?></span> </h4>
                                                        <p class="mb-0" style="color: #670303;"> Positive </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-12 InfosCards text-center alerts_count">
                                        <div class="card">
                                            <div class="card-body" style="padding: 0px;border: 6px solid #34ccc7;">
                                                <div class="card-body badge-soft-success">
                                                    <div class="float-left mt-2"> <img src="<?= base_url() ?>assets/images/icons/png_icons/green.png" alt="Temperature" style="width: 30px;"> </div>
                                                    <div class="col-xl-10">
                                                        <h4 class="mb-1 mt-1" style="color: #044300;"><span data-plugin="counterup"><?= GetTotal($school['Id'], "0", "", $startdate, $enddate) ?></span></h4>
                                                        <p class="mb-0" style="color: #044300;"> Negative </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <h3 class="card-title text-center">users counters </h3>
                                    <hr>
                                    <div class="row">
                                        <div class="col-4 text-center br-r">
                                            <p>Teachers</p>
                                            <h3 class="text-center"><?= $this->db->get_where("l2_teacher", ["Added_By" => $school['Id']])->num_rows() ?></h3>
                                        </div>
                                        <div class="col-4 text-center br-r">
                                            <p>Staff</p>
                                            <h3 class="text-center"><?= $this->db->get_where("l2_staff", ["Added_By" => $school['Id']])->num_rows() ?></h3>
                                        </div>
                                        <div class="col-4 text-center">
                                            <p>Students</p>
                                            <h3 class="text-center"><?= $this->db->get_where("l2_student", ["Added_By" => $school['Id']])->num_rows() ?></h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <h3 class="card-title text-center">users in actions </h3>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <?php
                                    $q_results = array();
                                    $quarantine_arr = $this->db->query("SELECT COUNT(Id) AS counter FROM l2_teacher WHERE Added_By = '" . $school['Id'] . "' AND `Action` = 'Quarantine'
                                    UNION SELECT COUNT(Id) AS counter FROM l2_staff WHERE Added_By = '" . $school['Id'] . "' AND `Action` = 'Quarantine'
                                    UNION SELECT COUNT(Id) AS counter FROM l2_student WHERE Added_By = '" . $school['Id'] . "' AND `Action` = 'Quarantine' ")->result_array();
                                    $q_results['Teachers'] = $quarantine_arr[0]['counter'] ?? 0;
                                    $q_results['staff'] = $quarantine_arr[1]['counter'] ?? 0;
                                    $q_results['students'] = $quarantine_arr[2]['counter'] ?? 0;
                                    $q_results['total'] = ($quarantine_arr[0]['counter'] ?? 0) + ($quarantine_arr[1]['counter'] ?? 0) + ($quarantine_arr[2]['counter'] ?? 0);
                                    $h_results = array();
                                    $Home_arr = $this->db->query("SELECT COUNT(Id) AS counter FROM l2_teacher WHERE Added_By = '" . $school['Id'] . "' AND `Action` = 'Home'
                                    UNION SELECT COUNT(Id) AS counter FROM l2_staff WHERE Added_By = '" . $school['Id'] . "' AND `Action` = 'Home'
                                    UNION SELECT COUNT(Id) AS counter FROM l2_student WHERE Added_By = '" . $school['Id'] . "' AND `Action` = 'Home' ")->result_array();
                                    $h_results['Teachers'] = $Home_arr[0]['counter'] ?? 0;
                                    $h_results['staff'] = $Home_arr[1]['counter'] ?? 0;
                                    $h_results['students'] = $Home_arr[2]['counter'] ?? 0;
                                    $h_results['total'] = ($Home_arr[0]['counter'] ?? 0) + ($Home_arr[1]['counter'] ?? 0) + ($Home_arr[2]['counter'] ?? 0);
                                    ?>
                                    <div class="col-12 text-center">
                                        <p class="text-center"> Quarantine </p>
                                        <h3 class="text-center"><?= $q_results['total']; ?></h3>
                                        <hr>
                                        <div class="row">
                                            <div class="col-4">
                                                <p class="text-center">Teachers</p>
                                                <h3 class="text-center"><?= $q_results['Teachers'] ?></h3>
                                            </div>
                                            <div class="col-4">
                                                <p class="text-center">Staff</p>
                                                <h3 class="text-center"><?= $q_results['staff'] ?></h3>
                                            </div>
                                            <div class="col-4">
                                                <p class="text-center">students</p>
                                                <h3 class="text-center"><?= $q_results['students'] ?></h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <div class="col-12 text-center">
                                        <p class="text-center"> Home </p>
                                        <h3 class="text-center"><?= $h_results['total']; ?></h3>
                                        <hr>
                                        <div class="row">
                                            <div class="col-4">
                                                <p class="text-center">Teachers</p>
                                                <h3 class="text-center"><?= $h_results['Teachers'] ?></h3>
                                            </div>
                                            <div class="col-4">
                                                <p class="text-center">Staff</p>
                                                <h3 class="text-center"><?= $h_results['staff'] ?></h3>
                                            </div>
                                            <div class="col-4">
                                                <p class="text-center">students</p>
                                                <h3 class="text-center"><?= $h_results['students'] ?></h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    if ($alertby == "Temperature") {
                        if ($results['high'] > 0) {
                            $schools[$sn]['alertType'] = "danger";
                            $schools[$sn]['alerttext'] = $results['high'] . " users with high results";
                        } else {
                            $schools[$sn]['alertType'] = "success";
                            $schools[$sn]['alerttext'] = "no users has high results";
                        }
                    } elseif ($alertby == "Lab") {
                        if (GetTotal($school['Id'], "1", "", $startdate, $enddate) > 0) {
                            $schools[$sn]['alertType'] = "danger";
                            $schools[$sn]['alerttext'] = GetTotal($school['Id'], "1", "", $startdate, $enddate) . " users with positive results";
                        } else {
                            $schools[$sn]['alertType'] = "success";
                            $schools[$sn]['alerttext'] = "no users has positive results";
                        }
                    } elseif ($alertby == "الحجر الصحي") {
                        if ($q_results['total'] > 0) {
                            $schools[$sn]['alertType'] = "danger";
                            $schools[$sn]['alerttext'] = $q_results['total'] . " users in Quarantine";
                        } else {
                            $schools[$sn]['alertType'] = "success";
                            $schools[$sn]['alerttext'] = "no users in Quarantine";
                        }
                    } elseif ($alertby == "الحجر المنزلي") {
                        if ($h_results['total'] > 0) {
                            $schools[$sn]['alertType'] = "danger";
                            $schools[$sn]['alerttext'] = $h_results['total'] . " users in Home";
                        } else {
                            $schools[$sn]['alertType'] = "success";
                            $schools[$sn]['alerttext'] = "no users in Quarantine";
                        }
                    }
                    ?>
                <?php } ?>
            </div>
        </div>
    </div>
    <!-- Async script executes immediately and must be after any DOM elements used in callback. -->
    <script src="https://maps.google.com/maps/api/js?key=AIzaSyAU4Pg_I5BGHHIrJ5WBF8neXPYfYut9A-8"></script>
    <script src="<?= base_url("assets/libs/gmaps/gmaps.min.js") ?>"></script>
    <script src="<?= base_url("assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js"); ?>"></script>
    <script src="<?= base_url("assets/libs/@chenfengyuan/datepicker/datepicker.min.js"); ?>"></script>

    <script>
        var GLOBE_WIDTH = 256; // a constant in Google's map projection
        var west = <?= $maxLat ?>;
        var east = <?= $maxLong ?>;
        var angle = east - west;
        if (angle < 0) {
            angle += 360;
        }
        var pixelWidth = window.innerWidth;
        var zoom = (Math.round(Math.log(pixelWidth * 360 / angle / GLOBE_WIDTH) / Math.LN2) -1);

        console.log("zoom :" + zoom);

        var map;
        $(document).ready(function() {
            const avatarBase = "<?= base_url("Proxy/imageTosmall?img_url=") ?>";
            const schools = [
                <?php foreach ($schools as $key => $school) {  ?> {
                        lat: <?= $school['Latitude'] ?>,
                        long: <?= $school['Longitude'] ?>,
                        position: new google.maps.LatLng(<?= $school['Latitude'] ?>, <?= $school['Longitude'] ?>),
                        avatar: "<?= $school['Avatar'] ?? "default_avatar.jpg" ?>",
                        title: "<?= $school['School_Name_EN'] ?>",
                        id: <?= $school["Id"] ?>,
                        status: "<?= $school['alertType']  ?>",
                        statusText: "<?= $school['alerttext']  ?>",
                    },
                <?php } ?>
            ];
            const ids = [<?= implode(',', array_column($schools, "Id")); ?>];

            var myOptions = {
                center: new google.maps.LatLng(33.890542, 151.274856),
                zoom: zoom,
                mapTypeId: google.maps.MapTypeId.ROADMAP

            };
            // var map = new google.maps.Map(document.getElementById("gmaps-overlay"),
            //     myOptions);
            map = new GMaps({
                div: '#gmaps-overlay',
                lat: -33.890542,
                lng: -151.274856,
                zoom: zoom,
            });
            for (i = 0; i < schools.length; i++) {
                var latlngset = new google.maps.LatLng(schools[i].latt, schools[i].long);
                var position = new google.maps.LatLng((schools[i].latt), (schools[i].long));
                var content = $('.result-' + schools[i].id).html();
                var infowindow = new google.maps.InfoWindow({
                    content: content,
                    position: position,
                    shouldFocus: true
                }); // google.maps.event.addListener(marker, 'click', (function(marker, content, infowindow) {
                //     return function() {

                //     };
                // })(marker, content, infowindow));
                var marker = new google.maps.Marker({
                    map: map,
                    title: schools[i].title,
                    position: latlngset
                });
                map.drawOverlay({
                    lat: schools[i].lat,
                    lng: schools[i].long,
                    content: '<div class="gmaps-overlay background-' + schools[i].status + '">' + schools[i].title + '<br><p>' + schools[i].statusText + '</p><div class="gmaps-overlay_arrow above"></div></div>',
                    verticalAlign: 'top',
                    horizontalAlign: 'center',
                    click: function() {
                        infowindow.open(map, this);
                    }
                });
            }
            //setMarkers(map, schools) // set markers functions
            function setMarkers() {
                for (i = 0; i < schools.length; i++) {

                    var avatar = schools[i].avatar;
                    var lat = schools[i].lat;
                    var long = schools[i].long;
                    var title = schools[i].title;
                    var id = schools[i].id;

                    latlngset = new google.maps.LatLng(lat, long);

                    var marker = new google.maps.Marker({
                        icon: avatarBase + avatar,
                        map: map,
                        title: title,
                        position: latlngset
                    });

                    // map.setCenter(marker.getPosition())

                    var content = $('.result-' + id).html();

                    var infowindow = new google.maps.InfoWindow()

                    google.maps.event.addListener(marker, 'click', (function(marker, content, infowindow) {
                        return function() {
                            infowindow.setContent(content);
                            infowindow.open(map, marker);
                        };
                    })(marker, content, infowindow));

                }
            }

            function showresults(schoolId) {
                if (!$('body').hasClass('right-bar-enabled')) {
                    $('body').addClass('right-bar-enabled');
                }
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url() ?>AR/DashboardSystem/schoolResults',
                    data: {
                        schoolId: schoolId,
                    },
                    success: function(json_data) {
                        closeFullscreen();
                        if (json_data.status == "ok") {
                            $('.right-bar h5.m-0.me-2').html(json_data.schoolname);
                            $('#LowTemperature').html(json_data.low);
                            $('#NormalTemperature').html(json_data.normal);
                            $('#ModerateTemperature').html(json_data.moderate);
                            $('#HighTemperature').html(json_data.high);
                        } else {
                            $('body').removeClass('right-bar-enabled');
                            Swal.fire({
                                title: "Sorry.",
                                text: ' We have an error. Please refresh the page and try again.',
                                icon: 'error',
                                confirmButtonColor: '#5b73e8'
                            })
                        }
                    }
                });
            }
            /* Close fullscreen */
            function closeFullscreen() {
                if (document.exitFullscreen) {
                    document.exitFullscreen();
                } else if (document.webkitExitFullscreen) {
                    /* Safari */
                    document.webkitExitFullscreen();
                } else if (document.msExitFullscreen) {
                    /* IE11 */
                    document.msExitFullscreen();
                }
            }
            $('img[src="https://maps.gstatic.com/mapfiles/transparent.png"]').css('border-radius', "50%")
        });
    </script>


    <?php
    // php functions

    function GetTotalIn_all($schoolId, $from, $To, $startdate = "", $enddate = "")
    {
        $ci = &get_instance();
        $counter = 0;
        $Ourstaffs = $ci->db->query("SELECT * FROM l2_staff WHERE `Added_By` = '" . $schoolId . "'")->result_array();
        foreach ($Ourstaffs as $staff) {
            $getResults = $ci->db->query("SELECT * FROM l2_result WHERE `UserId` = '" . $staff['Id'] . "'
            AND UserType = 'Staff'  AND Result_Date BETWEEN  '" . $startdate . "' AND '" . $enddate . "'  ORDER BY `Id` DESC LIMIT 1")->result_array();
            foreach ($getResults as $results) {
                if ($results['Result'] >= $from && $results['Result'] <= $To) {
                    $counter++;
                }
            }
        }

        $OurTeachers = $ci->db->query("SELECT * FROM l2_teacher WHERE `Added_By` = '" . $schoolId . "' ")->result_array();
        foreach ($OurTeachers as $Teacher) {
            $getResultsT = $ci->db->query("SELECT * FROM l2_result WHERE `UserId` = '" . $Teacher['Id'] . "' 
            AND UserType = 'Teacher'  AND Result_Date BETWEEN  '" . $startdate . "' AND '" . $enddate . "'  ORDER BY `Id` DESC LIMIT 1")->result_array();
            foreach ($getResultsT as $results) {
                if ($results['Result'] >= $from && $results['Result'] <= $To) {
                    $counter++;
                }
            }
        }

        $OurStudents = $ci->db->query("SELECT * FROM l2_student WHERE `Added_By` = '" . $schoolId . "' ")->result_array();
        foreach ($OurStudents as $Student_çJDJD) {
            $getResults_Student = $ci->db->query("SELECT * FROM l2_result WHERE `UserId` = '" . $Student_çJDJD['Id'] . "' 
            AND Result_Date BETWEEN  '" . $startdate . "' AND '" . $enddate . "' AND UserType = 'Student' ORDER BY `Id` DESC LIMIT 1 ")->result_array();
            foreach ($getResults_Student as $results) {
                if ($results['Result'] >= $from && $results['Result'] <= $To) {
                    $counter++;
                }
            }
        }
        return ($counter);
    }

    function GetTotal($schoolId, $where, $action = "", $startdate = "", $enddate = "")
    {
        $ci = &get_instance();
        $counter = 0;
        $today = date("Y-m-d");
        $Ourstaffs = $ci->db->query("SELECT * FROM l2_staff WHERE `Added_By` = '" . $schoolId . "' ")->result_array();
        foreach ($Ourstaffs as $staff) {
            if (!empty($action)) {
                $getResults = $ci->db->query("SELECT * FROM l2_labtests WHERE `UserId` = '" . $staff['Id'] . "'
                AND Created BETWEEN  '" . $startdate . "' AND '" . $enddate . "' AND UserType = 'Staff' AND `Result` = '" . $where . "' AND `Action` = '" . $action . "' ORDER BY `Id` DESC LIMIT 1")->result_array();
            } else {
                $getResults = $ci->db->query("SELECT * FROM l2_labtests WHERE `UserId` = '" . $staff['Id'] . "'
                AND Created BETWEEN  '" . $startdate . "' AND '" . $enddate . "' AND UserType = 'Staff' AND `Result` = '" . $where . "' ORDER BY `Id` DESC LIMIT 1")->result_array();
            }

            foreach ($getResults as $results) {
                $counter++;
            }
        }

        $OurTeachers = $ci->db->query("SELECT * FROM l2_teacher WHERE `Added_By` = '" . $schoolId . "' ")->result_array();
        foreach ($OurTeachers as $Teacher) {
            if (!empty($action)) {
                $getResultsT = $ci->db->query("SELECT * FROM l2_labtests WHERE `UserId` = '" . $Teacher['Id'] . "'
                AND Created BETWEEN  '" . $startdate . "' AND '" . $enddate . "' AND UserType = 'Teacher'  AND `Result` = '" . $where . "'  AND `Action` = '" . $action . "' ORDER BY `Id` DESC LIMIT 1")->result_array();
            } else {
                $getResultsT = $ci->db->query("SELECT * FROM l2_labtests WHERE `UserId` = '" . $Teacher['Id'] . "'
                AND Created BETWEEN  '" . $startdate . "' AND '" . $enddate . "' AND UserType = 'Teacher'  AND `Result` = '" . $where . "' ORDER BY `Id` DESC LIMIT 1")->result_array();
            }
            foreach ($getResultsT as $results) {
                $counter++;
            }
        }

        $OurStudents = $ci->db->query("SELECT * FROM l2_student WHERE `Added_By` = '" . $schoolId . "' ")->result_array();
        foreach ($OurStudents as $Student) {
            if (!empty($action)) {
                $getResultsT = $ci->db->query("SELECT * FROM l2_labtests WHERE `UserId` = '" . $Student['Id'] . "'
                AND Created BETWEEN  '" . $startdate . "' AND '" . $enddate . "'  AND UserType = 'Student'  AND `Result` = '" . $where . "'  AND `Action` = '" . $action . "' ORDER BY `Id` DESC LIMIT 1")->result_array();
            } else {
                $getResultsT = $ci->db->query("SELECT * FROM l2_labtests WHERE `UserId` = '" . $Student['Id'] . "'
                AND Created BETWEEN  '" . $startdate . "' AND '" . $enddate . "'  AND UserType = 'Student'  AND `Result` = '" . $where . "' ORDER BY `Id` DESC LIMIT 1")->result_array();
            }
            foreach ($getResultsT as $results) {
                $counter++;
            }
        }

        return ($counter);
    }
    ?>