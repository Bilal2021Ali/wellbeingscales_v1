<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <link href="<?= base_url(); ?>assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url(); ?>assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url(); ?>assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link href="<?= base_url(); ?>assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url(); ?>assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url() ?>assets/css/app.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/animate.css" />

</head>
<style>
    .hidden_inp {
        background-color: transparent;
        outline: none;
        border: 0px;
    }

    .spinner-grow {
        color: #fff !important;
    }

    .btnloder {
        display: none;
    }

    #red1 {
        animation-delay: 0.2s;
        ;
    }

    #red2 {
        animation-delay: 0.7s;
        ;
    }

    #red3 {
        animation-delay: 1s;
        ;
    }
</style>

<body>
    <pre class="hidden">
<?php print_r($serv_data);  ?>
</pre>
    <div class="main-content">
        <div class="page-content">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="text-uppercase text-center">أسئلة الرفاهية</h3>
                            <hr>
                            <form id="use_serv" class="custom-validation">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <label for="en_title">الفئة بالانجليزي:</label>
                                        <input id="en_title" type="text" class="form-control" value="<?= $serv_data[0]['Cat_en'];  ?>" name="title_en" readonly>
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="ar_title">الفئة بالعربي:</label>
                                        <input id="ar_title" type="text" class="form-control" value="<?= $serv_data[0]['Cat_ar'];  ?>" name="title_ar" readonly>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group"><br>
                                            <label>صلاحية السؤال:</label>
                                            <div>
                                                <div class="input-daterange input-group" data-provide="datepicker" data-date-format="yyyy-mm-dd" data-date-autoclose="true">
                                                    <input type="text" class="form-control" placeholder="from" name="Start" autocomplete="off" required>
                                                    <input type="text" class="form-control" placeholder="to" name="End" autocomplete="off" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="avalable_to">فئة السؤال:</label>
                                        <select name="avalaible_to" id="avalable_to" class="form-control" required>
                                            <option value="1">الجميع</option>
                                            <option value="3">الحكومة</option>
                                            <option value="3">الخاص</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="avalable_to">حالة السؤال (يمكن تعديلها مستقبلا):</label>
                                        <select name="status" id="avalable_to" class="form-control" required>
                                            <option value="1">معطلة</option>
                                            <option value="2">مفعلة</option>
                                        </select>
                                    </div>
                                    <input type="hidden" name="serv_id" value="<?= $serv_data[0]['survey_id']; ?>">
                                    <div class="col-lg-12">
                                        <button type="Submit" class="btn btn-primary btn-lg btn-block waves-effect waves-light mb-1 mt-2">
                                            <div class="text"> إنشاء السؤال </div>
                                            <div class="btnloder">
                                                <div class="spinner-grow text-secondary m-1" role="status" id="red1">
                                                    <span class="sr-only">تحميل ...</span>
                                                </div>
                                                <div class="spinner-grow text-secondary m-1" role="status" id="red2">
                                                    <span class="sr-only">تحميل ...</span>
                                                </div>
                                                <div class="spinner-grow text-secondary m-1" role="status" id="red3">
                                                    <span class="sr-only">تحميل ...</span>
                                                </div>
                                            </div>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="<?= base_url() ?>assets/js/datetimepicker.js"></script>
    <script src="<?= base_url(); ?>assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>

    <script>
        $('.table').DataTable();


        function getcurrdate(sp) {
            var today = new Date();
            var dd = today.getDate();
            var mm = today.getMonth() + 1; //As January is 0.
            var yyyy = today.getFullYear();
            if (dd < 10) dd = '0' + dd;
            if (mm < 10) mm = '0' + mm;
            //return (mm+sp+dd+sp+yyyy);
            return (yyyy + sp + mm + sp + dd);
        };
        $('input[name="Start"]').val(getcurrdate('-'));
        $('input[name="End"]').val(getcurrdate('-'));

        $("#use_serv").on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: '<?= current_url(); ?>',
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function() {
                    $('button .text').hide();
                    $('.btnloder').show();
                },
                success: function(data) {
                    $('button .text').show();
                    $('.btnloder').hide();
                    if (data == "ok_enabled") {
                        Swal.fire({
                            title: 'Done',
                            text: 'This survey will be shown in schools.',
                            icon: 'success',
                            showCancelButton: true,
                            confirmButtonColor: '#5b8ce8',
                            cancelButtonColor: "#f46a6a"
                        });
                        setTimeout(() => {
                            location.href = "<?= base_url("AR/Company/ClimateSurveys"); ?>";
                        }, 800);
                    } else if (data == "ok_disabled") {
                        Swal.fire({
                            title: 'added successfully',
                            html: 'You can <b>active</b> it ' + '<a href="<?= base_url("AR/Company/ClimateSurveys"); ?>">here</a> ',
                            icon: 'success',
                            confirmButtonColor: '#5b8ce8',
							
                        });
                        setTimeout(() => {
                            location.href = "<?= base_url("AR/Company/ClimateSurveys"); ?>";
                        }, 800);
                    } else {
                        Swal.fire({
                            title: 'we have error , Kindly check the input.',
                            icon: 'error',
                            confirmButtonColor: '#5b8ce8',
                        });
                    }
                },
                ajaxError: function() {
                    Swal.fire({
                        title: 'Sorry. we have error ',
                        icon: 'error',
                        confirmButtonColor: '#5b8ce8',
                    });
                }
            });
        });
    </script>
</body>

</html>