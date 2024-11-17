<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="<?= base_url("assets/libs/select2/css/select2.min.css") ?>" rel="stylesheet" type="text/css" />
    <style>
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
            transition: 0.2s all;
            }
            
        .floating_action_btn:hover {
            transform: rotateZ(45deg);
        }

        .empty{
            width: 100%;
            text-align: center;
        }

        .empty img {
            width: 240px;
            margin-bottom: 10px;
        }

        .group_content {
            height: 500px;
            overflow: auto;
        }

    </style>
</head>

<body>
    <div class="main-content">
        <div class="page-content"><!-- AddGroup -->
            <button type="button" data-toggle="modal" data-target="#AddGroup"  class="floating_action_btn waves-effect waves-light">
                <i class="uil uil-plus"></i>
            </button>
            <?php if(!empty($used_groups)) { ?>
            <div class="row">
                <?php foreach ($used_groups as $key => $group) { ?>
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body" >          
                                <h3 class="card-title"><?= $group['title_en'] ?>
                                    <button data-toggle="modal" data-target="#exampleModal" onclick="addToThisGroup(<?= $group['Id']; ?>)" style="width: 30px;height: 30px;border-radius: 100%;padding: 1px;" class="btn btn-ronded float-right"><i class="uil uil-plus"></i></button>
                                    <button data-toggle="modal" data-target="#editetitleGroup" onclick="chnageid(<?= $group['Id']; ?>)" style="width: 30px;height: 30px;border-radius: 100%;padding: 1px;" class="btn btn-ronded float-right"><i class="uil uil-edit"></i></button>
                                    <button onclick="deletegroup(<?= $group['Id']; ?>)" style="width: 30px;height: 30px;border-radius: 100%;padding: 1px;" class="btn btn-ronded float-right"><i class="uil uil-trash"></i></button>
                                </h3>
                                <br>
                                <div id="accordion_<?= $key; ?>" class="custom-accordion group_content" data-simplebar="init">
                                    <?php $questions_of_grop  = $this->db->query("SELECT 
                                    `sv_st_questions`.*, `sv_questions_library`.*, `sv_st_questions`.`Id` AS Id ,
                                    (SELECT Id FROM `sv_standard_questions_groups` WHERE `Question_id` = `sv_st_questions`.`Id` AND `results_standard_group` = '".$group['Id']."' GROUP BY `Question_id`,`results_standard_group` ) AS ConnectId 
                                    FROM 
                                    `sv_st_questions`
                                    INNER JOIN `sv_questions_library` ON `sv_questions_library`.`Id` = `sv_st_questions`.`question_id`
                                    WHERE EXISTS (SELECT Id FROM `sv_standard_questions_groups` WHERE `Question_id` = `sv_st_questions`.`Id` AND `results_standard_group` = '".$group['Id']."' )  ")->result_array(); ?>
                                    <?php if(!empty($questions_of_grop)){ ?>
                                        <?php foreach ($questions_of_grop as $sn => $questions) { ?>
                                            <div class="card mb-1 shadow-none notstatic">
                                                <a href="#collapse_<?= $questions['Id'] ?>" class="text-dark" data-toggle="collapse" aria-expanded="true" aria-controls="collapse_<?= $questions['Id'] ?>">
                                                    <div class="card-header" id="<?= 'Hd_' . $questions['Id'] . '__' . $sn ?>">
                                                        <h6 class="m-0">
                                                            <?= $questions['en_title']; ?>
                                                            <i class="mdi mdi-chevron-up float-right accor-down-icon"></i>
                                                            <i class="uil-share float-right mr-1" data-toggle="modal" data-target="#change_the_group" onclick="transferequestion(<?= $group['Id']; ?>,<?= $questions['ConnectId']; ?>)"></i>
                                                        </h6>
                                                    </div>
                                                </a>
                                                <div id="collapse_<?= $questions['Id'] ?>" class="collapse <?= $sn == 0 ? "show" : "" ?>" aria-labelledby="<?= 'Hd_' . $questions['Id'] . '__' . $sn ?>" data-parent="#accordion_<?= $key; ?>" style="">
                                                    <div class="card-body">
                                                        <?= $questions['en_desc']; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    <?php }else{ ?>
                                        <div class="empty">
                                            <img src="<?= base_url('assets/images/empty.svg') ?>" class="empty" alt="">
                                            <h5>There is no questions here yet !!</h5>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <div class="modal fade zoom-in" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Add questions : </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form id="push_questions">
                                <input type="hidden" name="group_id" id="group_id" value="">
                                <input type="hidden" name="for" value="ADD_to">
                                <div class="modal-body addquestions_div">
                                    <h3 class="text-center">Please wait<span id="wait">.</span></h3>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="Submit" class="btn btn-primary add_q_btn">Save changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="modal fade zoom-in" id="change_the_group" tabindex="-1" role="dialog" aria-labelledby="change_the_groupLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="change_the_groupLabel">Transfer questions : </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form id="transfere_to">
                                <input type="hidden" name="quastion_id" id="quastion_id" value="">
                                <input type="hidden" name="for" value="trans">
                                <input type="hidden" name="__serv__" value="<?= $serv_id ?>">
                                <div class="modal-body groups_list">
                                    <h3 class="text-center">Please wait...</h3>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="Submit" class="btn btn-primary add_g_btn">Transfer</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="modal fade zoom-in" id="editetitleGroup" tabindex="-1" role="dialog" aria-labelledby="editetitleGroupLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editetitleGroupLabel">Edite group titles : </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form id="update_title" class="p-2">
                                <input type="hidden" name="for" value="update_g_title">
                                <input type="hidden" name="group_upg_id" id="group_upg_id" value="">
                                <label for="">Title en</label>
                                <input type="text" name="group_title_en" id="group_title_en" class="form-control mb-1" placeholder="title en" >
                                <label for="">Title AR</label>
                                <input type="text" name="group_title_ar" id="group_title_ar" class="form-control" placeholder="title ar" >
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="Submit" class="btn btn-primary add_tp_btn">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="modal fade zoom-in" id="AddGroup" tabindex="-1" role="dialog" aria-labelledby="AddGroupLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="AddGroupLabel">Transfer questions : </h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form id="creat_new" class="p-2">
                                    <input type="hidden" name="for" value="new">
                                    <input type="hidden" name="__serv__" value="<?= $serv_id ?>">
                                    <label for="">Title en</label>
                                    <input type="text" name="title_en" id="" class="form-control mb-1" placeholder="title en" >
                                    <label for="">Title AR</label>
                                    <input type="text" name="title_ar" id="" class="form-control" placeholder="title ar" >
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="Submit" class="btn btn-primary add_c_btn">Create</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

            </div>
            <?php }else{ ?>
                <div class="row">
                    <div class="modal fade zoom-in" id="AddGroup" tabindex="-1" role="dialog" aria-labelledby="AddGroupLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="AddGroupLabel">Transfer questions : </h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form id="creat_new" class="p-2">
                                    <input type="hidden" name="for" value="new">
                                    <input type="hidden" name="__serv__" value="<?= $serv_id ?>">
                                    <label for="">Title en</label>
                                    <input type="text" name="title_en" id="" class="form-control mb-1" placeholder="title en" >
                                    <label for="">Title AR</label>
                                    <input type="text" name="title_ar" id="" class="form-control" placeholder="title ar" >
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="Submit" class="btn btn-primary add_c_btn">Create</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 offset-lg-3 text-center pt-2">
                            <img src="<?= base_url('assets/images/empty.svg') ?>" class="w-100 mb-1" alt="">
                            <h3 class="mt-5">There is no groups here yet</h3>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</body>
<script src="<?= base_url('assets/libs/select2/js/select2.min.js'); ?>"></script>
<script>
function chnageid(id) {
    $('#group_upg_id').val(id);
    $.ajax({
        type: 'POST',
        url: '<?= base_url(); ?>EN/Dashboard/add_questions_to_standar_group?survtype=<?= $surv_type ?>',
        data: {
            serv_id  : <?= $serv_id ?>,
            group_id : id,
            for      : 'titles_get',
        },
        beforeSend: function() {
            $('.add_tp_btn').hide();
        },
        success: function(data) {
            $('.add_tp_btn').show();
            if(data.status == "ok"){
                $('#group_title_ar').val(data.title_ar)
                $('#group_title_en').val(data.title_en)
            }
        },
        ajaxError: function() {
            Swal.fire(
                'error',
                'oops!! we have a error',
                'error'
            );
        }
    });
}

function addToThisGroup(id) {
    $('#group_id').val(id)
    $.ajax({
        type: 'POST',
        url: '<?= base_url(); ?>EN/Dashboard/standarsGrouping?survtype=<?= $surv_type ?>',
        data: {
            serv_id: <?= $serv_id ?>,
            group_id: id,
        },
        beforeSend: function() {
            $('.add_q_btn').hide();
            $('.addquestions_div').html(`<h3 class="text-center">Please wait<span id="wait">.</span></h3>`);
        },
        success: function(data) {
            $('.add_q_btn').show();
            $('.addquestions_div').html(data);
        },
        ajaxError: function() {
            Swal.fire(
                'error',
                'oops!! we have a error',
                'error'
            );
        }
    });
}

    function transferequestion(id, quastion_id) {
        $('#quastion_id').val(quastion_id);
        $.ajax({
            type: 'POST',
            url: '<?= base_url(); ?>EN/Dashboard/standarsGrouping?survtype=<?= $surv_type ?>',
            data: {
                serv_id: <?= $serv_id ?>,
                question_id: quastion_id,
                group_key: id,
            },
            beforeSend: function() {
                $('.add_g_btn').hide();
                $('.groups_list').html(`<h3 class="text-center">Please wait<span id="wait">.</span></h3>`);
            },
            success: function(data) {
                $('.add_g_btn').show();
                $('.groups_list').html(data);
            },
            ajaxError: function() {
                Swal.fire(
                    'error',
                    'oops!! we have a error',
                    'error'
                );
            }
        });
    }
    $("#push_questions").on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: '<?= base_url(); ?>EN/Dashboard/add_questions_to_standar_group?survtype=<?= $surv_type ?>',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function() {
                $('.add_q_btn').attr('disabled', '');
                $('.add_q_btn').html('Plase wait ...');
            },
            success: function(data) {
                $('#statusbox').html(data);
                $('.add_q_btn').removeAttr('disabled');
                $('.add_q_btn').html('save changes ');
                if (data == "ok") {
                    $('#change_the_group').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'The questions you choised was added successfully to this survey , you can chechk it from the questions icon',
                    });
                    location.reload();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'oops...',
                        text: 'sorry we have error now !! please try later',
                    });
                }
            },
            ajaxError: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'oops...',
                    text: 'sorry we have error now !! please try later',
                });
            }
        });
    });


    $("#transfere_to").on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: '<?= base_url(); ?>EN/Dashboard/add_questions_to_standar_group?survtype=<?= $surv_type ?>',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function() {
                $('.add_g_btn').attr('disabled', '');
                $('.add_g_btn').html('Plase wait ...');
            },
            success: function(data) {
                $('#statusbox').html(data);
                $('.add_g_btn').removeAttr('disabled');
                $('.add_g_btn').html('save changes ');
                if (data == "ok") {
                    $('#exampleModal').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'The questions you choised was added successfully to this survey , you can chechk it from the questions icon',
                    });
                    location.reload();
                } else if(data == "not_valid"){
                    Swal.fire({
                        icon: 'error',
                        title: 'inputs error',
                        text: 'Please check your inputs and try again',
                    });
                }else{
                    Swal.fire({
                        icon: 'error',
                        title: 'oops...',
                        text: 'sorry we have error now !! please try later',
                    });
                }
            },
            ajaxError: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'oops...',
                    text: 'sorry we have error now !! please try later',
                });
            }
        });
    });

    $("#creat_new").on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: '<?= base_url(); ?>EN/Dashboard/add_questions_to_standar_group?survtype=<?= $surv_type ?>&standard_id=<?= $group_id ?? 0 ?>',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function() {
                $('.add_c_btn').attr('disabled', '');
                $('.add_c_btn').html('Plase wait ...');
            },
            success: function(data) {
                $('#statusbox').html(data);
                $('.add_c_btn').removeAttr('disabled');
                $('.add_c_btn').html('save changes ');
                if (data == "ok") {
                    $('#AddGroup').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'The group added successfully !',
                    });
                    location.reload();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'oops...',
                        text: 'sorry we have error now !! please try later',
                    });
                }
            },
            ajaxError: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'oops...',
                    text: 'sorry we have error now !! please try later',
                });
            }
        });
    });


    $("#update_title").on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: '<?= base_url(); ?>EN/Dashboard/add_questions_to_standar_group?survtype=<?= $surv_type ?>',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function() {
                $('.add_tp_btn').attr('disabled', '');
                $('.add_tp_btn').html('Plase wait ...');
            },
            success: function(data) {
                $('#statusbox').html(data);
                $('.add_tp_btn').removeAttr('disabled');
                $('.add_tp_btn').html('save changes ');
                if (data == "ok") {
                    $('#editetitleGroup').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'The group added successfully !',
                    });
                    location.reload();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'oops...',
                        text: 'sorry we have error now !! please try later',
                    });
                }
            },
            ajaxError: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'oops...',
                    text: 'sorry we have error now !! please try later',
                });
            }
        });
    });

    function deletegroup(id) {
        Swal.fire({
			title: 'Are you sure?',
			text: "You won't be able to revert this!",
			icon: 'warning',
			showCancelButton: true,
			confirmButtonText: 'Yes, delete it!',
			cancelButtonText: 'No, cancel!',
			confirmButtonClass: 'btn btn-success mt-2',
			cancelButtonClass: 'btn btn-danger ml-2 mt-2',
			buttonsStyling: false
		}).then(function(result) {
			if (result.value) {
                $.ajax({
					type: 'POST',
					url: '<?= base_url(); ?>EN/Dashboard/add_questions_to_standar_group?survtype=<?= $surv_type ?>',
					data: {
						group_id : id,
						for      : "delete"
					},
					success: function(data) {
                        if(data == "ok"){
                            Swal.fire(
                            'success',
                            'The group deleted successfully',
                            'success'
                            );
                            location.reload();
                        }else{
                        Swal.fire(
							'error',
							'oops!! we have a error',
							'error'
						);

                        }
					},
					ajaxError: function() {
						Swal.fire(
							'error',
							'oops!! we have a error',
							'error'
						);
					}
				});
            } // end start delete
        }); // end the result
    }

</script>

</html>