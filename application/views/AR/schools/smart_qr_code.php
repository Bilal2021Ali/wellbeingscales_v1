<link href="<?= base_url("assets/libs/select2/css/select2.min.css") ?>" rel="stylesheet" type="text/css" />
<style>
    .spinner-border {
        float: left;
        color: white !important;
        font-size: 4px;
        width: 1rem;
        height: 1rem;
    }

    .select2-container {
        width: 100% !important;
    }
</style>
<div class="main-content">
    <div class="page-content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs nav-justified" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link byuser active" data-toggle="tab" href="#navtabs2-home" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                    <span class="d-none d-sm-block"> حسب المستخدمين </span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link byclasses" data-toggle="tab" href="#navtabs2-profile" role="tab">
                                    <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                    <span class="d-none d-sm-block"> حسب الصفوف </span>
                                </a>
                            </li>
                        </ul>

                        <div class="tab-content p-3 text-muted">
                            <div class="tab-pane active" id="navtabs2-home" role="tabpanel">
                                <label for="by_user">إختر مستخدما أو أكثر :</label>
                                <select class="select2 form-control select2-multiple" name="by_user" multiple="multiple" data-placeholder="إختر ...">
                                    <optgroup label="موظفين">
                                        <?php foreach ($staffs as $staff) { ?>
                                            <option value="staff:<?= $staff['Id'] ?>"><?= $staff['F_name_AR'] . " " . $staff['L_name_AR'] ?></option>
                                        <?php } ?>
                                    </optgroup>
                                    <optgroup label="معلمين">
                                        <?php foreach ($teachers as $teacher) { ?>
                                            <option value="teacher:<?= $teacher['Id'] ?>"><?= $teacher['F_name_AR'] . " " . $teacher['L_name_AR'] ?></option>
                                        <?php } ?>
                                    </optgroup>
                                    <optgroup label="تلاميذ">
                                        <?php foreach ($students as $student) { ?>
                                            <option value="student:<?= $student['Id'] ?>"><?= $student['F_name_AR'] . " " . $student['L_name_AR'] ?></option>
                                        <?php } ?>
                                    </optgroup>
                                </select>
                                <div class="byuser-error text-danger"></div>
                            </div>
                            <div class="tab-pane" id="navtabs2-profile" role="tabpanel">
                                <label for="class"> الصف : </label><br>
                                <select class="select2 form-control select2-multiple " name="class" id="class" multiple="multiple" data-placeholder="إختر ...">
                                    <?php foreach ($this->schoolHelper->getActiveSchoolClassesByStudents() as $class) { ?>
                                        <option value="<?= $class['Id'] ?>"><?= $class['Class'] ?> ( <?= $class['student_count'] ?> <?= $class['student_count'] > 2 ? "طلبة" : "طالب" ?>)</option>
                                    <?php } ?>
                                </select>
                                <div class="byclasses-error text-danger"></div>
                            </div>
                        </div>
                        <div class="col-12">
                            <button class="btn btn-primary waves-effect waves-light w-100 mt-1 btn-brimary showQr">إنشاء رمز (رموز) QR</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row results">
            <!-- show results -->
        </div>
    </div>
</div>
<script src="<?= base_url("assets/libs/select2/js/select2.min.js"); ?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/jspdf.min.js"></script>
<script src="<?= base_url(); ?>assets/js/jquery-qrcode-min.js"></script>
<script src="<?= base_url(); ?>assets/js/jquery-barcode.min.js"></script>

<script>
    $('.select2').select2({
        closeOnSelect: false,
    });

    $('.showQr').click(function() {
        var data = 0;
        $('.text-danger').html("");
        if ($('.byuser').hasClass('active')) {
            if ($('select[name="by_user"]').val().length <= 0) {
                $('.byuser-error').html("الرجاء تحديد مستخدم واحد على الأقل !!");
            } else {
                var data = {
                    users: $('select[name="by_user"]').val(),
                };
            }
        } else {
            if ($('select[name="class"]').val().length <= 0) {
                $('.byclasses-error').html("الرجاء تحديد صف واحد على الأقل !!");
            } else {
                var data = {
                    classes: $('select[name="class"]').val()
                };
            }
        }
        if (data !== 0) {
            $.ajax({
                type: 'POST',
                url: '<?= current_url(); ?>',
                data: data,
                beforeSend: function() {
                    $('.btn-brimary').attr('disabled');
                    $('.btn-brimary').html('<div class="spinner-border text-dark m-1" role="status"> <span class="sr-only">الرجاء الإنتظار...</span></div> الرجاء الإنتظار');
                },
                success: function(data) {
                    $('.btn-brimary').removeAttr('disabled');
                    $('.btn-brimary').html('إنشاء رمز (رموز) QR');
                    $('.results').html(`<div class="page-title-box col-12 text-center"><button type="button" class="btn btn-primary btn-block waves-effect waves-light mt-2 mr-1" onClick="Save_all_page_as_Pdf('smartqrcode_<?= time(); ?>')" style="width: 340px;"><i class="uil uil-file mr-2"></i> احفظ كملف PDF</button></div>`);
                    $('.results').append(data);
                },
                ajaxError: function() {
                    $('#ResultsTableStudents').css('background-color', '#DB0404');
                    $('#ResultsTableStudents').html("oops!! لدينا خطأ");
                }
            });
        }
    });

    function Save_all_page_as_Pdf(name) {
        html2canvas($('.results:not(.page-title-box)')).then(function(canvas) {
            //document.body.appendChild(canvas);
            var imgdata = canvas.toDataURL('image/png');
            /*var imgdata_bar = html2canvas($('#bcTarget')).then(function(img){
                img.toDataURL('image/png');
            });	*/
            var doc = new jsPDF();
            //var pr = document.querySelector('#fOR8pRINT');
            //console.log(imgdata_bar);
            //doc.fromHTML(pr,15,15);
            doc.addImage(imgdata, 'PNG', 0, 10, 210, 210);
            //doc.addImage(imgdata_bar, 'PNG' , 120, 80);
            /* Add new page
            doc.addPage();
            doc.text(20, 20, 'Visit CodexWorld.com');*/

            // Save the PDF
            doc.save(name + '.pdf');
        });
    }
</script>