<div class="main-content">
    <div class="page-content">
        <div class="col-12">
            <div id="FileUpload" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="FileUploadLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <form class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title mt-0" id="FileUploadLabel">Report Upload</h5>
                            <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-center">
                            <img src="<?= base_url("assets/images/uploadFilePlaceholder.png") ?>" class="selectFile btn" width="80" alt="">
                            <input type="hidden" name="cat_id">
                            <input type="hidden" name="userType">
                            <input type="hidden" name="lang">
                            <input type="file" accept="application/pdf" name="newFile" class="d-none">
                            <h3 class="mt-1">Click to select a file</h3>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light waves-effect" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary waves-effect waves-light">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title">LIST</h3>
                    <div class="overflow-auto">
                        <table class="table">
                            <thead>
                                <th>#</th>
                                <th>Category</th>
                                <th>Surveys in the Category</th>
                                <th>EN Staff Report</th>
                                <th>EN Teacher Report</th>
                                <th>EN Student Report</th>
                                <th>EN Parent Report</th>
								<th>AR Staff Report</th>
                                <th>AR Teacher Report</th>
                                <th>AR Student Report</th>
                                <th>AR Parent Report</th>
                            </thead>
                            <tbody>
                                <?php foreach ($categories as $sn => $category) { ?>
                                    <tr>
                                        <td><?= $sn + 1 ?></td>
                                        <td><?= $category['Cat_en'] ?></td>
                                        <td><?= $category['counter_of_using'] ?></td>
                                        <td class="text-center"><button type="button" data-toggle="modal" data-target="#FileUpload" class="btn btn-<?= $category['Staff_file_en'] == null ? "success" : "warning" ?> btn-rounded waves-effect OpenFileReport action-btn-staff-<?= $category['Id'] ?>-en" data-key="<?= $category['Id'] ?>" data-user-type="staff" data-lang="en"><i class="uil uil-file"></i></button></td>
                                        <td class="text-center"><button type="button" data-toggle="modal" data-target="#FileUpload" class="btn btn-<?= $category['Teacher_file_en'] == null ? "success" : "warning" ?> btn-rounded waves-effect OpenFileReport action-btn-teacher-<?= $category['Id'] ?>-en" data-key="<?= $category['Id'] ?>" data-user-type="teacher" data-lang="en"><i class="uil uil-file"></i></button></td>
                                        <td class="text-center"><button type="button" data-toggle="modal" data-target="#FileUpload" class="btn btn-<?= $category['Parent_file_en'] == null ? "success" : "warning" ?> btn-rounded waves-effect OpenFileReport action-btn-student-<?= $category['Id'] ?>-en" data-key="<?= $category['Id'] ?>" data-user-type="Student" data-lang="en"><i class="uil uil-file"></i></button></td>
                                        <td class="text-center"><button type="button" data-toggle="modal" data-target="#FileUpload" class="btn btn-<?= $category['Student_file_en'] == null ? "success" : "warning" ?> btn-rounded waves-effect OpenFileReport action-btn-parent-<?= $category['Id'] ?>-en" data-key="<?= $category['Id'] ?>" data-user-type="Parent" data-lang="en"><i class="uil uil-file"></i></button></td>
										<td class="text-center"><button type="button" data-toggle="modal" data-target="#FileUpload" class="btn btn-<?= $category['Staff_file_ar'] == null ? "success" : "warning" ?> btn-rounded waves-effect OpenFileReport action-btn-staff-<?= $category['Id'] ?>-ar" data-key="<?= $category['Id'] ?>" data-user-type="staff" data-lang="ar"><i class="uil uil-file"></i></button></td>
                                        <td class="text-center"><button type="button" data-toggle="modal" data-target="#FileUpload" class="btn btn-<?= $category['Teacher_file_ar'] == null ? "success" : "warning" ?> btn-rounded waves-effect OpenFileReport action-btn-teacher-<?= $category['Id'] ?>-ar" data-key="<?= $category['Id'] ?>" data-user-type="teacher" data-lang="ar"><i class="uil uil-file"></i></button></td>
                                        <td class="text-center"><button type="button" data-toggle="modal" data-target="#FileUpload" class="btn btn-<?= $category['Student_file_ar'] == null ? "success" : "warning" ?> btn-rounded waves-effect OpenFileReport action-btn-student-<?= $category['Id'] ?>-ar" data-key="<?= $category['Id'] ?>" data-user-type="Student" data-lang="ar"><i class="uil uil-file"></i></button></td>
                                        <td class="text-center"><button type="button" data-toggle="modal" data-target="#FileUpload" class="btn btn-<?= $category['Parent_file_ar'] == null ? "success" : "warning" ?> btn-rounded waves-effect OpenFileReport action-btn-parent-<?= $category['Id'] ?>-ar" data-key="<?= $category['Id'] ?>" data-user-type="Parent" data-lang="ar"><i class="uil uil-file"></i></button></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $('.table').DataTable();
    $('.table').on('click', '.OpenFileReport' ,function(){
        $('#FileUpload form input[name="cat_id"]').val($(this).attr('data-key'));
        $('#FileUpload form input[name="userType"]').val($(this).attr('data-user-type'));
        $('#FileUpload form input[name="lang"]').val($(this).attr('data-lang'));
        $('#FileUpload form input[name="newFile"]').val('');
        $('#FileUpload form h3').html('Click to select a file');
    });

    $('.selectFile').click(function() {
        $('#FileUpload form input[name="newFile"]').trigger('click');
    });


    $('#FileUpload form input[name="newFile"]').change(function(e) {
        $('#FileUpload form h3').html('Select File :' + e.target.files[0].name);
    });

    $('#FileUpload form').on('submit', function(e) {
        e.preventDefault();
        $('#FileUpload button[type="submit"]').attr('disabled', '');
        $('#FileUpload button[type="submit"]').html('Please wait...');
        $.ajax({
            type: "POST",
            url: "<?= current_url(); ?>",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(response) {
                $('#FileUpload button[type="submit"]').removeAttr('disabled');
                $('#FileUpload button[type="submit"]').html('Save Changes');
                if (response.status == "ok") {
                    $(".action-btn-" + $('#FileUpload form input[name="userType"]').val() + "-" + $('#FileUpload form input[name="cat_id"]').val()+ "-" + $('#FileUpload form input[name="lang"]').val()).removeClass("btn-success");
                    $(".action-btn-" + $('#FileUpload form input[name="userType"]').val() + "-" + $('#FileUpload form input[name="cat_id"]').val()+ "-" + $('#FileUpload form input[name="lang"]').val()).addClass("btn-warning");
                    console.log(".action-btn-" + $('#FileUpload form input[name="userType"]').val() + "-" + $('#FileUpload form input[name="cat_id"]').val());
                    $('#FileUpload').modal('hide');
                    Swal.fire({
                        title: "success",
                        text: "File uploaded successfully",
                        icon: "success"
                    });
                } else {
                    Swal.fire({
                        title: "error",
                        text: response.message,
                        icon: "error"
                    });
                }
            }
        });
    });
</script>