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
                        <br>
                        <div class="row image_container">
                            <img src="<?php echo base_url(); ?>assets/images/banners/SCHOOL102.png" alt="schools">
                        </div>
                        <br>
                    </div>
                </div>
            </div>	<br>
            <h4 class="card-title" style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">CH P015: Create QR for Users and Classes</h4>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs nav-justified" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link byuser active" data-toggle="tab" href="#navtabs2-home" role="tab">
                                    <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                    <span class="d-none d-sm-block"> By users </span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link byclasses" data-toggle="tab" href="#navtabs2-profile" role="tab">
                                    <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                    <span class="d-none d-sm-block"> By classes  </span>
                                </a>
                            </li>
                        </ul>

                        <div class="tab-content p-3 text-muted">
                            <div class="tab-pane active" id="navtabs2-home" role="tabpanel">
                                <label for="by_user">Select User/Users :</label>
                                <select class="select2 form-control select2-multiple" name="by_user" multiple="multiple" data-placeholder="Choose ...">
                                    <optgroup label="Staff">
                                        <?php foreach ($staffs as $staff) { ?>
                                            <option value="staff:<?= $staff['Id'] ?>"><?= $staff['F_name_EN'] . " " . $staff['L_name_EN'] ?></option>
                                        <?php } ?>
                                    </optgroup>
                                    <optgroup label="Teacher">
                                        <?php foreach ($teachers as $teacher) { ?>
                                            <option value="teacher:<?= $teacher['Id'] ?>"><?= $teacher['F_name_EN'] . " " . $teacher['L_name_EN'] ?></option>
                                        <?php } ?>
                                    </optgroup>
                                    <optgroup label="Student">
                                        <?php foreach ($students as $student) { ?>
                                            <option value="student:<?= $student['Id'] ?>"><?= $student['F_name_EN'] . " " . $student['L_name_EN'] ?></option>
                                        <?php } ?>
                                    </optgroup>
                                </select>
                                <div class="byuser-error text-danger"></div>
                            </div>
                            <div class="tab-pane" id="navtabs2-profile" role="tabpanel">
                                <label for="class"> Class : </label><br>
                                <select class="select2 form-control select2-multiple " name="class" id="class" multiple="multiple" data-placeholder="Choose ...">
                                    <?php foreach ($this->schoolHelper->getActiveSchoolClassesByStudents() as $class) { ?>
                                        <option value="<?= $class['Id'] ?>"><?= $class['Class'] ?> ( <?= $class['student_count'] ?> student<?= $class['student_count'] > 1 ? "s" : "" ?>)</option>
                                    <?php } ?>
                                </select>
                                <div class="byclasses-error text-danger"></div>
                            </div>
                        </div>
                        <div class="col-12">
                            <button class="btn btn-primary waves-effect waves-light w-100 mt-1 btn-brimary showQr">Generate QR code(s)</button>
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
                $('.byuser-error').html("Please select at least one user.");
            } else {
                var data = {
                    users: $('select[name="by_user"]').val(),
                };
            }
        } else {
            if ($('select[name="class"]').val().length <= 0) {
                $('.byclasses-error').html("Please select at least one class.");
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
                    $('.btn-brimary').html('<div class="spinner-border text-dark m-1" role="status"> <span class="sr-only">Loading...</span></div> Please wait...');
                },
                success: function(data) {
                    $('.btn-brimary').removeAttr('disabled');
                    $('.btn-brimary').html('Generate QR code(s)');
                    $('.results').html(`<div class="page-title-box col-12 text-center"><button type="button" class="btn btn-primary btn-block waves-effect waves-light mt-2 mr-1" onClick="Save_all_page_as_Pdf('smartqrcode_<?= time(); ?>')" style="width: 340px;"><i class="uil uil-file mr-2"></i> Save as PDF</button></div>`);
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