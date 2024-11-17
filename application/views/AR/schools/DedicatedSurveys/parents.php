<link href="<?= base_url('assets/libs/select2/css/select2.min.css'); ?>" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="<?= base_url("assets/libs/toastr/build/toastr.min.css") ?>">

<style>
    .centered {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    .card {
        border-color: transparent;
    }

    .btn-close {
        -webkit-box-sizing: content-box;
        box-sizing: content-box;
        width: 1em;
        height: 1em;
        padding: .25em .25em;
        color: #000;
        background: transparent url(data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23000'%3e%3cpath d='M.293.293a1 1 0 011.414 0L8 6.586 14.293.293a1 1 0 111.414 1.414L9.414 8l6.293 6.293a1 1 0 01-1.414 1.414L8 9.414l-6.293 6.293a1 1 0 01-1.414-1.414L6.586 8 .293 1.707a1 1 0 010-1.414z'/%3e%3c/svg%3e) center/1em auto no-repeat;
        border: 0;
        border-radius: .25rem;
        opacity: .5;
    }

    .alert-dismissible .btn-close {
        position: absolute;
        top: 0;
        right: 0;
        z-index: 2;
        padding: 0px;
        font-size: 35px;
    }

    .alert-dismissible .btn-close {
        position: absolute;
        top: 0;
        right: 0;
        z-index: 2;
        padding: .9375rem 1.25rem;
    }
</style>
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="col-lg-8 offset-lg-1">
                <div class="card">
                    <form class="card-body" method="post" action="<?= current_url(); ?>">
                        <?php if (isset($errors)) { ?>
                            <div class="alert alert-danger alert-dismissible fade show mt-4 px-4 mb-0 text-center" role="alert">
                                <i class="uil uil-exclamation-octagon d-block display-4 mt-2 mb-3 text-danger"></i>
                                <h5 class="text-danger">خطأ</h5>
                                <?= $errors  ?>
                                <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span></button>
                            </div>
                        <?php } ?>
                        <h3 class="card-title text-center mt-3"> نشر الاستبيان: </h3>
                        <hr>
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label class="form-label">الاستبيان:</label>
                                <select class="form-control select2" name="survey">
                                    <?php foreach ($surveys as $survey) { ?>
                                        <option value="<?= $survey['survey_id'] ?>"><?= $survey['set_name_en'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label class="form-label">لأولياء الأمور:</label>
                                <select class="form-control select2" name="Parent">
                                    <option>حدد أحد الوالدين</option>
                                    <?php foreach ($parents as $parent) { ?>
                                        <option value="<?= $parent['Id'] ?>"><?= $parent['name_en'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label class="form-label">الطلاب:</label>
                                <select class="form-control select2 select2-multiple" name="students[]" multiple="multiple" data-placeholder="select receiver students ... (select the class first)">
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label class="form-label">الرسالة:</label>
                                <textarea required="" name="message" class="form-control" placeholder="Hints.." rows="5" spellcheck="false"></textarea>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <button type="submit" class="btn btn-primary waves-effect waves-light me-1 w-100">
                                اعتمد
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?= base_url('assets/libs/select2/js/select2.min.js'); ?>"></script>
<script src="<?= base_url('assets/libs/toastr/build/toastr.min.js'); ?>"></script>
<script>
    $('.select2').select2();
    $('select[name="Parent"]').change(function() {
        $('select[name="students[]"]').empty();
        var parent_id = $(this).val();
        $('select[name="students[]"]').select2({
            closeOnSelect: false,
            allowClear: true,
            placeholder: 'Select schools',
            ajax: {
                url: '<?= base_url("AR/schools/av_students_for_parent"); ?>',
                dataType: 'json',
                type: 'POST',
                data: {
                    parent_id: parent_id,
                },
                processResults: function(response) {
                    return {
                        results: response
                    };
                },
            }
        });
    });
</script>