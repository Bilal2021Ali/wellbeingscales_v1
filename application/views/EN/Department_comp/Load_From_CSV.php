<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <link href="<?= base_url(); ?>assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" />
    <link href="<?= base_url(); ?>assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url(); ?>assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />

    <link href="<?= base_url(); ?>assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />

</head>
<style>
    * {
        list-style: none;
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    .title {
        background: #f3f4f8;
        padding: 15px;
        font-size: 18px;
        text-align: center;
        text-transform: uppercase;
        letter-spacing: 3px;
    }

    .file_upload_list li .file_item {
        display: flex;
        border-bottom: 1px solid #f3f4f8;
        padding: 15px 20px;
    }

    .file_item .format {
        background: #8178d3;
        border-radius: 10px;
        width: 45px;
        height: 40px;
        line-height: 40px;
        color: #fff;
        text-align: center;
        font-size: 12px;
        margin-right: 15px;
    }

    .file_item .file_progress {
        width: calc(100% - 60px);
        font-size: 14px;
    }

    .file_item .file_info,
    .file_item .file_size_wrap {
        display: flex;
        align-items: center;
    }

    .file_item .file_info {
        justify-content: space-between;
    }

    .file_item .file_progress .progress {
        width: 100%;
        height: 4px;
        background: #efefef;
        overflow: hidden;
        border-radius: 5px;
        margin-top: 8px;
        position: relative;
    }

    .file_item .file_progress .progress .inner_progress {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: #58e380;
    }

    .file_item .file_size_wrap .file_size {
        margin-right: 15px;
    }

    .file_item .file_size_wrap .file_close {
        border: 1px solid #8178d3;
        color: #8178d3;
        width: 20px;
        height: 20px;
        line-height: 18px;
        text-align: center;
        border-radius: 50%;
        font-size: 10px;
        font-weight: bold;
        cursor: pointer;
    }

    .file_item .file_size_wrap .file_close:hover {
        background: #8178d3;
        color: #fff;
    }

    .choose_file label {
        display: block;
        border: 2px dashed #8178d3;
        padding: 15px;
        width: calc(100% - 20px);
        margin: 10px;
        text-align: center;
        cursor: pointer;
    }

    .choose_file #choose_file {
        outline: none;
        opacity: 0;
        width: 0;
    }

    .choose_file span {
        font-size: 14px;
        color: #8178d3;
    }

    .choose_file label:hover span {
        text-decoration: underline;
    }
</style>
<style>
    .file_upload_list {
        text-align: center;
    }

    .card {
        border: 0px;
    }

    .progress {
        margin-top: 10px;
    }

    h6 {
        padding: 5px;
    }
</style>

<body>
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <div class="row" id="uploadSection">
                    <div class="col-xl-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">How to upload information</h4>
                                <p class="card-title-desc">Read the steps below </p>
                                <div id="accordion" class="custom-accordion">
                                    <div class="card mb-1 shadow-none">
                                        <a href="#collapseOne" class="text-dark collapsed" data-toggle="collapse" aria-expanded="true" aria-controls="collapseOne">
                                            <div class="card-header" id="headingOne">
                                                <h6 class="m-0">
                                                    <strong>Users</strong><i class="mdi mdi-chevron-up float-right accor-down-icon"></i>
                                                </h6>
                                            </div>
                                        </a>
                                        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion" style="">
                                            <div class="card-body">
                                                <h6 style="background-color:yellow"> <b>Steps</b></h6>
                                                <p>1- downloade <a href="<?= base_url(); ?>uploads/Csv/users_template.xlsx" onClick="DownloadStart();">Users template</a> <br>
                                                    2- Please save the file to your hard drive.<br>
                                                    3- Open the downloaded file and load it immediately using the specified program.<br>
                                                    4- Fill your data inside the Excel Template following the sample data format.<br>
                                                    5- Save the Excel Template as an "SCV" file after you have inserted the data.<br>
                                                    6- Import the "CSV" file. <br>
                                                    7- Upload your file. <br>
                                                    <strong>Please wait until the upload is completed.</strong><br>
                                                <h6 style="background-color:yellow"> All teachers must include their National IDs. Note that you cannot modify or edit later.</h6> <br>
                                                <strong>Do not worry about duplicated data. We will remove the copied file based on the National ID data collected.</strong><br>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="card">
                            <div class="card-body">

                                <h4 class="card-title"> Upload the csv file</h4>
                                <!-- Nav tabs -->
                                <div class="wrapper staffUpload">
                                    <div class="file_upload_list">
                                        <i class="display-4 text-muted uil uil-cloud-upload"></i>
                                        <h3 class="StatusBoxStaff">Please select the CSV File </h3>
                                        <div id="exportinSatff"></div>
                                        <div class="progress mb-4">
                                            <div class="progress-bar Staffprogress" role="progressbar" style="width: 0%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                    <form id="CsvUpload" name="Staff">
                                        <div class="choose_file">
                                            <label for="choose_file">
                                                <input type="file" id="choose_file" name="csvFile">
                                                <span>Choose a file</span>
                                            </label>
                                        </div>
                                        <button type="Submit" class="btn btn-primary btn-lg btn-block waves-effect waves-light mb-1 
																			StatusbtnStaff">
                                            start upload
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row " id="responseSection" style="display: none;">
                    <div class="col-lg-8 offset-lg-2 centered">
                        <div class="card">
                            <div class="card-body">
                                <div class="text-center">
                                    <div class="loader">
                                        <svg class="circular" viewBox="25 25 50 50">
                                            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />
                                        </svg>
                                    </div>
                                </div>
                                <hr>
                                <div class="progress mb-4" style="display: none;">
                                    <div class="progress-bar bg-success Staffprogress" role="progressbar" style="width: 0%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <h5 class="text-center" id="responsetext">Please wait....</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- container-fluid -->
        </div>
        <!-- End Page-content -->

    </div>
</body>
<script src="<?= base_url(); ?>assets/libs/sweetalert2/sweetalert2.all.min.js"></script>

<script src="<?= base_url(); ?>assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/metismenu/metisMenu.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/simplebar/simplebar.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/node-waves/waves.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/waypoints/lib/jquery.waypoints.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/jquery.counterup/jquery.counterup.min.js"></script>
<!-- Required datatable js -->
<script src="<?= base_url(); ?>assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
<!-- Buttons examples -->
<script src="<?= base_url(); ?>assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/jszip/jszip.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/pdfmake/build/pdfmake.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/pdfmake/build/vfs_fonts.js"></script>
<script src="<?= base_url(); ?>assets/libs/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/datatables.net-buttons/js/buttons.print.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/datatables.net-buttons/js/buttons.colVis.min.js"></script>
<!-- Responsive examples -->
<script src="<?= base_url(); ?>assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
<script>
    $('#choose_file').change(function() {
        var val = $('#choose_file').val();
        if (val !== "") {
            $('#choose_file').attr('readonly', '');
            $('.choose_file span').html('The file has been selected successfully, start uploading');
        }
    });

    function DownloadStart() {
        Swal.fire(
            'Download start',
            ' The download has started, please wait a few moments for it to complete',
            'info'
        )
    }

    $("#CsvUpload").on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: '<?= base_url('EN/Export/exportco_users'); ?>',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            xhr: function() {
                var prevResponse = '';
                var req = $.ajaxSettings.xhr();
                req.onreadystatechange = function() {
                    console.log("changed");
                    if (this.readyState == 4) {
                        //stuff you want to do when ajax completes   
                    } else if (this.readyState > 2) {
                        console.log(this);
                        var newResponse = this.responseText.substring(prevResponse.length);
                        $("#responsetext").html(newResponse);
                        prevResponse = this.response;
                    }
                }
                return req;
            },
            beforeSend: function() {
                $('#uploadSection').hide();
                $('#responseSection').show();
            },
            //other options
        });
    });
</script>

</html>