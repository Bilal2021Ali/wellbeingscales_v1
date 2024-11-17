<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="preconnect" href="https:/fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Almarai:wght@700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link rel="stylesheet" type="text/css" href="<?= base_url("assets/libs/toastr/build/toastr.min.css") ?>">
    <link href="<?= base_url("assets/libs/select2/css/select2.min.css") ?>" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" type="text/css" href="<?= base_url("assets/libs/toastr/build/toastr.min.css") ?>">
</head>

<style>
    /* The switch - the box around the slider */
    .switch {
        position: relative;
        display: inline-block;
        width: 60px;
        height: 34px;
    }

    /* Hide default HTML checkbox */
    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    /* The slider */
    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #CB0002;
        -webkit-transition: .4s;
        transition: .4s;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 26px;
        width: 26px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        -webkit-transition: .4s;
        transition: .4s;
    }

    input:checked + .slider {
        background-color: #4caf50;
    }

    input:focus + .slider {
        box-shadow: 0 0 1px #2196F3;
    }

    input:checked + .slider:before {
        -webkit-transform: translateX(26px);
        -ms-transform: translateX(26px);
        transform: translateX(26px);
    }

    /* Rounded sliders */
    .slider.round {
        border-radius: 34px;
    }

    .slider.round:before {
        border-radius: 50%;
    }

    .floating_action_btn {
        position: fixed !important;
        bottom: 70px;
        right: 10px;
        border: 0px;
        width: 50px;
        height: 50px;
        background: #fff;
        border-radius: 100%;
        z-index: 1000;
        -webkit-box-shadow: 0 2px 4px rgba(15, 34, 58, 0.12);
        box-shadow: 0 2px 4px rgba(15, 34, 58, 0.12);
    }

    .odd {
        background: #ffeaf1 !important;
    }

    .arabic, .arabic * {
        font-family: 'Almarai', sans-serif;
    }

    .delete {
        font-size: 23px;
        color: #fd0000;
        cursor: pointer;
    }

    .delete_question {
        font-size: 23px;
        color: #fd0000;
        cursor: pointer;
        float: right;
        margin-bottom: 20px;
    }

    .questions {
        font-size: 23px;
        color: #3c40c6;
        cursor: pointer;
    }

    .modal.fade .modal-dialog {
        -webkit-transform: translate(0, 0);
        transform: translate(0, 0);
    }

    .zoom-in {
        transform: scale(0) !important;
        opacity: 0;
        -webkit-transition: 0.5s all 0s;
        -moz-transition: 0.5s all 0s;
        -ms-transition: 0.5s all 0s;
        -o-transition: 0.5s all 0s;
        transition: 0.5s all 0s;
        display: block !important;
    }

    .zoom-in.show {
        opacity: 1;
        transform: scale(1) !important;
        transform: none;
    }

    .ADD {
        color: green;
        cursor: pointer;
        font-size: 20px;
    }

    .add_q_btn {
        transition: 0.2s all;
    }

    .disabled-ic {
        font-size: 22px;
        cursor: default !important;
    }
</style>

<body>
<div class="main-content">
    <div class="page-content">
        <h4 class="card-title" style="background: #800080; padding: 10px;color: #ffffff;border-radius: 4px;">SU 014:
            Manage Surveys</h4>
        <h4 class="card-title" style="background: #307D7E; padding: 10px;color: #ffffff;border-radius: 4px;"> 0001: List
            all published surveys <br>
            0002: List arabic, english questions in all published surveys <br>
            0003: Add new arabic, english questions to any published surveys <br>
            0004: Delete any published surveys forever <br>
            0005: Create groups for surveys, then add questions<br>
        </h4>
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Published surveys list
                    <div class="flex float-right">
                        <button class="btn btn-success mr-1 status-filter" data-status="1">Enabled</button>
                        <button class="btn status-filter" data-status="0">Disabled</button>
                    </div>
                </h4>
                <p class="card-title-desc">With choices surveys & fillable surveys</p>
                <div id="surveys-list">
                </div>

            </div>
        </div>
        <h4 class="card-title" style="background: #7D0552; padding: 10px;color: #ffffff;border-radius: 4px;">SU 001:
            Protected by QlickHealth </h4>
        <div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title mt-0" id="myModalLabel"> English Arabic Questions in the Survey </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="card" style="border: 0px;box-shadow: 0px 0px 0px;">
                            <div class="card-body">
                                <div class="showquestions text-center mb-5" style="display: none;"> Loading...</div>
                                <div class="question_list"></div>
                            </div>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
        </div>
        <div class="modal fade zoom-in" id="exampleModal" tabindex="-1" role="dialog"
             aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Questions</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="push_questions">
                        <div class="modal-body addquestions_div">
                            <h3 class="text-center">Please wait ...<span id="wait">.</span></h3>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="Submit" class="btn btn-primary add_q_btn">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade zoom-in" id="targetedaccountmodal" tabindex="-1" role="dialog"
             aria-labelledby="targetedaccountmodalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="targetedaccountmodalLabel">Targeted Accounts:</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="list-content p-2"></div>
                </div>
            </div>
        </div>


    </div>
</body>
<script src="<?php echo base_url(); ?>assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo base_url('assets/libs/select2/js/select2.min.js'); ?>"></script>
<script src="<?php echo base_url() ?>assets/libs/toastr/build/toastr.min.js"></script>
<script src="<?php echo base_url() ?>assets/libs/datatables.net-autoFill/js/dataTables.autoFill.min.js"></script>
<script src="<?php echo base_url() ?>assets/libs/datatables.net-autoFill-bs4/js/autoFill.bootstrap4.min.js"></script>
<script src="<?php echo base_url() ?>assets/libs/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
<script src="<?php echo base_url() ?>assets/libs/bootstrap-editable/js/index.js"></script>
<script>
    $('.table').DataTable();

    if (document.getElementById("wait").length > 0) {
        var dots = window.setInterval(function () {
            var wait = document.getElementById("wait");
            if (wait.innerHTML.length > 3)
                wait.innerHTML = "";
            else
                wait.innerHTML += ".";
        }, 200);
    }


    function get_avalaible_questions(surv_id, type = "notfillable") {
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>EN/Dashboard/change_serv_status',
            data: {
                requestFor: 'av_questions',
                group_id: surv_id,
                sv_type: type,
            },
            beforeSend: function () {
                $('.add_q_btn').hide();
                $('.addquestions_div').html(`<h3 class="text-center">Please wait<span id="wait">.</span></h3>`);
            },
            success: function (data) {
                $('.add_q_btn').show();
                $('.addquestions_div').html(data);
            },
            ajaxError: function () {
                Swal.fire(
                    'error',
                    'oops!! we have a error',
                    'error'
                );
            }
        });
    }

    $("#push_questions").on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>EN/Dashboard/push_new_questions',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                $('.add_q_btn').attr('disabled', '');
                $('.add_q_btn').html('Plase wait ...');
            },
            success: function (data) {
                $('#statusbox').html(data);
                $('.add_q_btn').removeAttr('disabled');
                $('.add_q_btn').html('save changes ');
                if (data == "ok") {
                    $('#exampleModal').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'The Questions you Selected was added Successfully to this Survey , you can check that',
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'oops...',
                        text: 'Sorry we have error Now !! Please Try Later',
                    });
                }
            },
            ajaxError: function () {
                $('.alert.alert-info').css('background-color', '#DB0404');
                $('.alert.alert-info').html("Ooops! Error was found.");
            }
        });
    });

    // enable disable code
    function update_status(Id, surveytype = "notfillable") {
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>EN/Dashboard/change_serv_status',
            data: {
                serv_id: Id,
                type: 'change',
                sv_type: surveytype
            },
            success: function (data) {
                if (data === "ok") {
                    fetchSurveys($(".status-filter.active").data("status") === 1);
                } else {
                    Swal.fire(
                        'error',
                        'Oops! We have an unexpected error.',
                        'error'
                    );
                }
            },
            ajaxError: function () {
                Swal.fire(
                    'error',
                    'oops!! we have a error',
                    'error'
                );
            }
        });
    }

    $('.card').on('click', '.delete', function () {
        var Id = $(this).attr('for');
        var key = $(this).attr('key');
        var svtype = $(this).attr('data-type');
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to Revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel!',
            confirmButtonClass: 'btn btn-success mt-2',
            cancelButtonClass: 'btn btn-danger ml-2 mt-2',
            buttonsStyling: false
        }).then(function (result) {
            if (result.value) {
                //DELETE 	
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url(); ?>EN/Dashboard/change_serv_status',
                    data: {
                        serv_id: Id,
                        type: "delete",
                        sv_type: svtype
                    },
                    success: function (data) {
                        if (data === "ok") {
                            Swal.fire({
                                title: 'Deleted!',
                                text: 'Your Question has been Deleted.',
                                icon: 'success'
                            }).then(function (result) {
                                $('#serv_' + Id).addClass('animate__flipOutX');
                                setTimeout(function () {
                                    $('#serv_' + Id).remove();
                                }, 800);
                            });
                            reset_count(key);
                        } else {
                            Swal.fire(
                                'error',
                                'Oops! We have an unexpected error.',
                                'error'
                            );
                        }
                    },
                    ajaxError: function () {
                        Swal.fire(
                            'error',
                            'oops!! we have a error',
                            'error'
                        );
                    }
                });
            }
        });
    });


    function reset_count(id) {
        $('.count').each(function () {
            var oldval = Number($(this).text());
            if (oldval > id) {
                var newval = oldval - 1;
                $(this).html(newval)
            }
        });
    }

    // show questions	
    function showquestions(groupid, surveytype = "not_fillable") {
        $('.question_list').html("");
        $('.showquestions').fadeIn();
        getquestions(groupid, surveytype);
    }

    //question_list
    function getquestions(roupid, svtype) {
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>EN/Dashboard/change_serv_status',
            data: {
                requestFor: 'All_questions',
                group_id: roupid,
                sv_type: svtype
            },
            success: function (data) {
                if (data.length > 0) {
                    $('.showquestions').fadeOut();
                    setTimeout(function () {
                        $('.question_list').html(data);
                    }, 800);
                }
            },
            ajaxError: function () {
                Swal.fire(
                    'error',
                    'oops!! we have a error',
                    'error'
                );
            }
        });
    }

    $('.card').on('click', '.targetedaccounts', function () {
        const key = $(this).attr('data-key');
        $('#targetedaccountmodal').modal('show');
        $.ajax({
            type: "GET",
            url: "<?= base_url("EN/Dashboard/TargetedAccounts/Survey/") ?>" + key,
            success: function (response) {
                $('#targetedaccountmodal .list-content').html(response);
            }
        });
    });

    function fetchSurveys(status = true) {
        $.ajax({
            type: "GET",
            url: "<?= base_url("EN/Dashboard/surveys-list/") ?>?status=" + (status ? 1 : 0),
            beforeSend: function () {
                $('#surveys-list').html(`<h3 class="text-center">Please wait....</h3>`);
            },
            success: function (response) {
                $('#surveys-list').html(response);
            },
            error: function () {
                $('#surveys-list').html("Sorry We Had An Error , try refreshing the page");
            }
        });
    }

    $(document).ready(function () {
        fetchSurveys(true);
    });

    const statusFilter = $(".status-filter")
    statusFilter.click(function () {
        statusFilter.removeClass("active").removeClass("btn-danger").removeClass("btn-success");
        $(this).addClass("active");
        const isTrue = $(this).data("status") === 1;

        if (isTrue) {
            $(this).removeClass("btn-outline-success");
            $(this).addClass("btn-success");
        } else {
            $(this).removeClass("btn-outline-danger");
            $(this).addClass("btn-danger");
        }

        fetchSurveys(isTrue);
    });
</script>
</html>