<!-- Loader style -->
<style>
    .loader {
        position: relative;
        margin: 0px auto;
        width: 100px;
    }

    .loader:before {
        content: '';
        display: block;
        padding-top: 100%;
    }

    .circular {
        -webkit-animation: rotate 2s linear infinite;
        animation: rotate 2s linear infinite;
        height: 100%;
        -webkit-transform-origin: center center;
        -ms-transform-origin: center center;
        transform-origin: center center;
        width: 100%;
        position: absolute;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        margin: auto;
    }

    .path {
        stroke-dasharray: 1, 200;
        stroke-dashoffset: 0;
        -webkit-animation: dash 1.5s ease-in-out infinite, color 6s ease-in-out infinite;
        animation: dash 1.5s ease-in-out infinite, color 6s ease-in-out infinite;
        stroke-linecap: round;
    }

    @-webkit-keyframes rotate {
        100% {
            -webkit-transform: rotate(360deg);
            transform: rotate(360deg);
        }
    }

    @keyframes rotate {
        100% {
            -webkit-transform: rotate(360deg);
            transform: rotate(360deg);
        }
    }

    @-webkit-keyframes dash {
        0% {
            stroke-dasharray: 1, 200;
            stroke-dashoffset: 0;
        }

        50% {
            stroke-dasharray: 89, 200;
            stroke-dashoffset: -35;
        }

        100% {
            stroke-dasharray: 89, 200;
            stroke-dashoffset: -124;
        }
    }

    @keyframes dash {
        0% {
            stroke-dasharray: 1, 200;
            stroke-dashoffset: 0;
        }

        50% {
            stroke-dasharray: 89, 200;
            stroke-dashoffset: -35;
        }

        100% {
            stroke-dasharray: 89, 200;
            stroke-dashoffset: -124;
        }
    }

    @-webkit-keyframes color {

        100%,
        0% {
            stroke: #d62d20;
        }

        40% {
            stroke: #0057e7;
        }

        66% {
            stroke: #008744;
        }

        80%,
        90% {
            stroke: #ffa700;
        }
    }

    @keyframes color {

        100%,
        0% {
            stroke: #d62d20;
        }

        40% {
            stroke: #0057e7;
        }

        66% {
            stroke: #008744;
        }

        80%,
        90% {
            stroke: #ffa700;
        }
    }
</style>
<!-- Success style -->
<style>
    /** * Extracted from: SweetAlert * Modified by: Istiak Tridip */
    .success-checkmark {
        width: 80px;
        height: 115px;
        margin: 0 auto;
    }

    .success-checkmark .check-icon {
        width: 80px;
        height: 80px;
        position: relative;
        border-radius: 50%;
        box-sizing: content-box;
        border: 4px solid #4caf50;
    }

    .success-checkmark .check-icon::before {
        top: 3px;
        left: -2px;
        width: 30px;
        transform-origin: 100% 50%;
        border-radius: 100px 0 0 100px;
    }

    .success-checkmark .check-icon::after {
        top: 0;
        left: 30px;
        width: 60px;
        transform-origin: 0 50%;
        border-radius: 0 100px 100px 0;
        animation: rotate-circle 4.25s ease-in;
    }

    .success-checkmark .check-icon::before,
    .success-checkmark .check-icon::after {
        content: '';
        height: 100px;
        position: absolute;
        background: #fff;
        transform: rotate(-45deg);
    }

    .success-checkmark .check-icon .icon-line {
        height: 5px;
        background-color: #4caf50;
        display: block;
        border-radius: 2px;
        position: absolute;
        z-index: 10;
    }

    .success-checkmark .check-icon .icon-line.line-tip {
        top: 46px;
        left: 14px;
        width: 25px;
        transform: rotate(45deg);
        animation: icon-line-tip 0.75s;
    }

    .success-checkmark .check-icon .icon-line.line-long {
        top: 38px;
        right: 8px;
        width: 47px;
        transform: rotate(-45deg);
        animation: icon-line-long 0.75s;
    }

    .success-checkmark .check-icon .icon-circle {
        top: -4px;
        left: -4px;
        z-index: 10;
        width: 80px;
        height: 80px;
        border-radius: 50%;
        position: absolute;
        box-sizing: content-box;
        border: 4px solid rgba(76, 175, 80, .5);
    }

    .success-checkmark .check-icon .icon-fix {
        top: 8px;
        width: 5px;
        left: 26px;
        z-index: 1;
        height: 85px;
        position: absolute;
        transform: rotate(-45deg);
        background-color: #fff;
    }

    @keyframes rotate-circle {
        0% {
            transform: rotate(-45deg);
        }

        5% {
            transform: rotate(-45deg);
        }

        12% {
            transform: rotate(-405deg);
        }

        100% {
            transform: rotate(-405deg);
        }
    }

    @keyframes icon-line-tip {
        0% {
            width: 0;
            left: 1px;
            top: 19px;
        }

        54% {
            width: 0;
            left: 1px;
            top: 19px;
        }

        70% {
            width: 50px;
            left: -8px;
            top: 37px;
        }

        84% {
            width: 17px;
            left: 21px;
            top: 48px;
        }

        100% {
            width: 25px;
            left: 14px;
            top: 45px;
        }
    }

    @keyframes icon-line-long {
        0% {
            width: 0;
            right: 46px;
            top: 54px;
        }

        65% {
            width: 0;
            right: 46px;
            top: 54px;
        }

        84% {
            width: 55px;
            right: 0px;
            top: 35px;
        }

        100% {
            width: 47px;
            right: 8px;
            top: 38px;
        }
    }
</style>
<!-- page style -->
<style>
    .centered {
        position: fixed;
        top: 50%;
        left: 50%;
        /* bring your own prefixes */
        transform: translate(-50%, -50%);
    }
</style>
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

    .uploadtype {
        background: #007E15;
        color: #fff;
        padding: 10px;
        border-radius: 6px;
        text-align: center;
        margin-bottom: 10px;
    }
</style>
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row" id="uploadSection">
                <div class="col-xl-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">كيفية تحميل بياناتك:</h4>
                            <p class="card-title-desc">اقرأ الخطوات أدناه.</p>
                            <div id="accordion" class="custom-accordion">
                                <div class="card mb-1 shadow-none">
                                    <a href="#collapseOne" class="text-dark collapsed" data-toggle="collapse" aria-expanded="true" aria-controls="collapseOne">
                                        <div class="card-header" id="headingOne">
                                            <h6 class="m-0">
                                                <strong>For <?= $userType ?></strong><i class="mdi mdi-chevron-up float-right accor-down-icon"></i>
                                            </h6>
                                        </div>
                                    </a>
                                    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion" style="">
                                        <div class="card-body">
                                            <h6 style="background-color:yellow"> <b><?= $userType ?> Steps</b></h6>
                                            1- تنزيل <a href="<?php echo base_url(); ?>uploads/Csv/<?= $userType ?>_template.xlsx" onClick="DownloadStart();"><?= $userType ?> Excell Template</a> <br>
                                            2-  يرجى حفظ الملف على القرص الصلب الخاص بك.<br>
                                            3- افتح الملف الذي تم تنزيله وقم بتحميله على الفور باستخدام البرنامج المحدد.<br>
                                            4- املأ بياناتك داخل قالب Excel باتباع نموذج تنسيق البيانات.<br>
                                            5- احفظ قالب Excel كملف "SCV" بعد إدراج البيانات.<br>
                                            6- استيراد ملف "CSV". <br>
                                            7- قم بتحميل ملفك. <br>
                                            <strong>يرجى الانتظار حتى يكتمل التحميل.</strong><br>
                                            <h6 style="background-color:yellow"> كل <?= $userType ?> يجب على جميع المعلمين تضمين بطاقات الهوية الوطنية الخاصة بهم. لاحظ أنه لا يمكنك تعديل أو تحرير لاحقا.</h6> <br>
                                            <strong>لا تقلق بشأن البيانات المكررة. سنقوم بإزالة الملف المنسوخ بناء على بيانات الهوية الوطنية التي تم جمعها.</strong><br>
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
                            <h4 class="card-title uploadtype"> رفع <strong><?= $userType ?></strong> ملف CSV </h4>
                            <!-- Nav tabs -->
                            <div class="wrapper staffUpload">
                                <div class="file_upload_list">
                                    <i class="display-4 text-muted uil uil-cloud-upload"></i>
                                    <h3 class="StatusBoxStaff"> من فضلك إختر <?= $userType ?> ملف CSV </h3>
                                    <div id="exportinSatff"></div>
                                </div>
                                <form id="CsvUpload" name="Staff">
                                    <div class="choose_file">
                                        <label for="choose_file">
                                            <input type="file" id="choose_file" name="csvFile">
                                            <span>اختر ملف</span>
                                        </label>
                                    </div>
                                    <button type="Submit" class="btn btn-primary btn-lg btn-block waves-effect waves-light mb-1 StatusbtnStaff">
                                        ابدأ تحميل ملف CSV!
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row " id="responseSection" style="display: none;">
                <div class="col-lg-8 centered">
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
                            <h5 class="text-center" id="responsetext">الرجاء الانتظار....</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $("#CsvUpload").on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: '<?= base_url('AR/Export/export'.$userType); ?>',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            xhr: function() {
                var prevResponse = '';
                var req = $.ajaxSettings.xhr();
                req.onreadystatechange = function() {
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