<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="<?php echo base_url("assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css"); ?>" rel="stylesheet">

    <style>
        .top-bar {
            width: 100%;
            background: url(<?php echo base_url("assets/images/user_bar_bg.jpg"); ?>);
            height: 190px;
            border-radius: 10px;
            border-bottom-left-radius: 0px;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }


        .user_puc_v {
            margin-top: 120px;
            position: relative;
            z-index: 1000;
        }

        .user_puc_v img {
            -webkit-box-shadow: 0 2px 4px rgb(15 34 58 / 12%);
            box-shadow: 0 2px 4px rgb(15 34 58 / 12%);
        }


        .edit_image {
            position: absolute;
            bottom: 0px;
            width: 40px;
            height: 40px;
            background: rgb(0 0 0 / 70%);
            z-index: 1001;
            border-radius: 100%;
            font-size: 21px;
            padding-top: 10px;
            color: #fff;
            right: 30%;
            cursor: pointer;
            transition: 0.2s all;
        }

        .edit_image:hover {
            transition: 0.2s all;
            transform: scale(1.2);
        }

        .user_bar {
            background-color: #5b73e8;
        }

        .user_bar .content {
            max-height: 80vh;
            overflow: auto;
        }

        .user_bar *:not(input, select, option) {
            color: #fff;
        }

        .group-ar {
            display: none;
        }

        .loding {
            display: none;
        }

        .loding {
            width: 100%;
            transition: 0.3s all;
            height: 100%;
            position: absolute;
            display: grid;
            align-items: center;
            align-content: center;
            background: #5b73e8;
            z-index: 999;
            top: 0px;
            left: 0px;
        }

        .loding .spinner-border {
            position: absolute;
            left: 43%;
            font-size: 19px;
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

    body {
        background-color: #eee !important;
    }

    .parsley-minlength {
        color: #ffe500 !important;
    }

    </style>
</head>

<body>
    <?php if ($rerquest_type == "view") { ?>
        <div class="main-content">
            <div class="page-content">
			<h4 class="card-title" style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">الملف الشخصي</h4>
                <!-- the top bar -->
            <div class="col-lg-12 top-bar">
                <div class="top-bar-image"></div>
                <div class="row">
                    <div class="col-lg-3 text-center">
                        <i class="uil uil-camera edit_image"  data-toggle="modal" data-target="#editImage"></i>
                        <img src="<?php echo base_url("uploads/avatars/".$img_url); ?>" class="avatar-xl rounded-circle user_puc_v" alt="...">
                    </div>
                </div>
            </div>

            <div id="editImage" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="editImageLabel" aria-hidden="true">
				<div class="modal-dialog modal-dialog-scrollable">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<div class="card" style="border: 0px;box-shadow: 0px 0px 0px;">
								<div class="card-body text-center">
									<?php $this->load->view('AR/Global/inc_imageForm'); ?>
								</div>
							</div>
						</div><!-- /.modal-content -->
					</div><!-- /.modal-dialog -->
				</div>
			</div>
            <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-3 user_bar">
                            <div class="loding" style="display: none;">
                                <div class="spinner-border text-warning m-1" role="status">
                                    <span class="sr-only">تحميل...</span>
                                </div>
                            </div>
                            <div class="content mt-10 text-center" data-pattern="priority-columns" data-simplebar="init">
                                <h3 class="text-white"><?php echo $student_name; ?></h3>
                                <p><?php echo $school_name ?></p>
                                <div class="container">
                                <div class="container">
                                    <button type="button" class="btn btn-link waves-effect font-size-12 float-right showEdite mt-3">تعديل ملفي الشخصي</button>
                                    <hr class="d-block">
                                </div>
                                <form action="" class="needs-validation custom-validation" id="edite_my_data" novalidate>
                                    <div class="form-group">
                                        <label for="f_n" class="float-left">الاسم الأول بالانجليزي:</label>
                                        <input class="form-control" type="text" id="f_n" name="f_n_e" placeholder="الاسم الأول بالانجليزي" value="<?php echo $all_user_data['F_name_EN']; ?>" readonly required data-parsley-minlength="3" data-parsley-maxlength="200">
                                    </div>
                                    <div class="form-group group-ar">
                                        <label for="f_n_a" class="float-left">الاسم الأول بالعربي:</label>
                                        <input class="form-control" type="text" id="f_n_a" name="f_n_a" placeholder="الاسم الأول بالعربي" value="<?php echo $all_user_data['F_name_AR']; ?>" readonly required data-parsley-minlength="3" data-parsley-maxlength="200">
                                    </div>
                                    <div class="form-group">
                                        <label for="m_n" class="float-left">الاسم الثاني بالانجليزي:</label>
                                        <input class="form-control" type="text" id="m_n" name="m_n_e" placeholder="الاسم الثاني بالانجليزي" value="<?php echo $all_user_data['M_name_EN']; ?>" readonly required data-parsley-minlength="3" data-parsley-maxlength="200">
                                    </div>
                                    <div class="form-group group-ar">
                                        <label for="m_n_a" class="float-left">الاسم الثاني بالعربي:</label>
                                        <input class="form-control" type="text" id="m_n_a" name="m_n_a" placeholder="الاسم الثاني بالعربي" value="<?php echo $all_user_data['M_name_AR']; ?>" readonly required data-parsley-minlength="3" data-parsley-maxlength="200">
                                    </div>
                                    <div class="form-group">
                                        <label for="l_2" class="float-left">الاسم الأخير بالانجليزي:</label>
                                        <input class="form-control" type="text" id="l_n" name="l_n_e" placeholder="الاسم الأخير بالانجليزي" value="<?php echo $all_user_data['L_name_EN']; ?>" readonly required data-parsley-minlength="3" data-parsley-maxlength="200">
                                    </div>
                                    <div class="form-group group-ar">
                                        <label for="l_2_a" class="float-left">الاسم الاخير بالعربي:</label>
                                        <input class="form-control" type="text" id="l_n_a" name="l_n_a" placeholder="الاسم الاخير بالعربي" value="<?php echo $all_user_data['L_name_AR']; ?>" readonly required data-parsley-minlength="3" data-parsley-maxlength="200">
                                    </div>
                                    <div class="form-group">
                                        <label for="ph" class="float-left">رقم الموبايل:</label>
                                        <input class="form-control" type="text" id="ph" name="phone" placeholder="رقم الموبايل" value="<?php echo $all_user_data['Phone']; ?>" readonly required data-parsley-minlength="10">
                                    </div>
                                    <div class="form-group">
                                        <label for="l_2_a" class="float-left">الجنس:</label>
                                        <select class="custom-select text-muted" name="Gender" disabled>
                                            <option value="1" <?php echo $all_user_data['Gender'] == '1' ? "selected" : ""; ?>>ذكر</option>
                                            <option value="0" <?php echo $all_user_data['Gender'] == '0' ? "selected" : ""; ?>>أنثى</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="lem" class="float-left">البريد الإلكتروني:</label>
                                        <input class="form-control" name="email" type="email"  id="lem" placeholder="البريد الإلكتروني" value="<?php echo $all_user_data['Email']; ?>" readonly required>
                                    </div>
                                    <div class="form-group">
                                        <label class="float-left">الجنسية:</label>
                                        <select class="custom-select" name="Nationality" disabled>
                                            <?php foreach ($contriesarray as $contries) { ?>
                                                <option value="<?php echo $contries['name']; ?>" <?php echo  $all_user_data['Nationality'] == $contries['name'] ? 'selected' : ""; ?> class="option">
                                                    <?php echo $contries['name']; ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="float-left" for="dop">تاريخ الميلاد:</label>
                                        <div class="input-group">
                                            <input type="text" autocomplete="off" class="form-control" id="dop" name="DOP" placeholder="<?php echo $all_user_data['DOP']; ?>" data-provide="datepicker" data-date-format="dd-mm-yyyy" disabled required data-parsley-maxlength="10" data-parsley-minlength="10">
                                        </div><!-- input-group -->
                                        <button type="Submit" disabled class="mt-2 btn btn-primary btn-sm btn-block waves-effect waves-light GoEdit">تحديث</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } else { ?>
        <!-- edite profile -->
        <div class="main-content">
            <div class="page-content">

            </div>
        </div>
    <?php } ?>
</body>
<script src="<?php echo base_url("assets/libs/simplebar/simplebar.min.js"); ?>"></script>
<script src="<?php echo base_url("assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js"); ?>"></script>
<script src="<?php echo base_url("assets/libs/parsleyjs/parsley.min.js"); ?>"></script>
<script src="<?php echo base_url("assets/js/pages/form-validation.init.js") ?>"></script>

<script>
    $('.showEdite').click(function() {
        $('#edite_my_data .group-ar').slideDown();
        $('#edite_my_data input').removeAttr('readonly');
        $('#edite_my_data input').removeAttr('disabled');
        $('select').removeAttr('disabled');
        $('.GoEdit').removeAttr('disabled');
    });


    $("#edite_my_data").on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>AR/Students/Profile',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function() {
                $('.loding').show();
            },
            success: function(data) {
                $('.loding').hide();
                if (data == "ok") {
                    Swal.fire({
                        title: "Done",
                        text: 'تم تحديث كلمة المرور بنجاح !! يمكنك الذهاب لتسجيل الدخول',
                        icon: 'success',
                        confirmButtonColor: '#5b8ce8'
                    }).then(function(result) {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        title: "للأسف",
                        text: 'يرجى التحقق من المدخلات.',
                        icon: 'error',
                        confirmButtonColor: '#5b8ce8'
                    });
                }
            },
            ajaxError: function() {
                Swal.fire({
                    title: "للأسف",
                    text: 'لدينا مشكلة في هذا الطلب',
                    icon: 'error',
                    confirmButtonColor: '#5b8ce8'
                });
            }
        });
    });
</script>

</html>