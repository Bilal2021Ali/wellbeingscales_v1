<style>
    .category-card .card-body .counter-element {
        padding: 10px;
        font-size: 15px;
        text-align: center;
        border-radius: 5px;
        margin: 10px 0px;
        font-weight: 700;
        color: #404040;
        width: 100%;
        display: block;
        border: 0;
    }

    .category-card .card-body .counter-element:nth-child(1), .category-card .card-body .counter-element:nth-child(4) {
        background: #fbe5d6;
    }

    .category-card .card-body .counter-element:nth-child(2) {
        background: #ffc000;
    }

    .category-card .card-body .counter-element:nth-child(3) {
        background: #5b9bd5;
    }

    .category-card .card-body .counter-element:nth-child(5) {
        background: #f6ac8d;
    }

    .category-card .card-body .counter-element:nth-child(6) {
        color: #fff;
        background: #70ad47;
    }

    .category-card .card-body .counter-element:nth-child(7) {
        color: #fff;
        background: #00b0f0;
    }

    .category-card .card-body .counter-element:nth-child(8) {
        color: #fff;
        background: #ed7d31;
    }

    .add-card {
        text-align: center;
        min-height: 310px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 30px;
    }

    .select2-container {
        width: 100% !important;
    }
</style>
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
        cursor: default;
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
        background-color: #00bd06;
    }

    input:focus + .slider {
        box-shadow: 0 0 1px #00bd06;
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

</style>
<?php
function formatNumber($number)
{
    return number_format((float)$number, 1, '.', '');
}

?>
<link rel="stylesheet" type="text/css" href="<?= base_url("assets/libs/toastr/build/toastr.min.css") ?>">
<div class="main-content">
    <div class="page-content">
        <div id="publishCourse" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="publishCourseLabel"
             aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="subAccountFormLabel"><?= $this->lang->line('Publish') ?> :</h5>
                        <button type="button" class="btn-close btn-rounded text-danger btn" data-dismiss="modal"
                                aria-label="Close">
                            <i class="uil uil-times"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="publish-course" class="row">
                            <input type="hidden" name="_course">
                            <?php $this->load->view("Shared/Schools/courses/inc/publish-form", ['full' => true]) ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <?php /*?><h4 class="card-title mb-4"><?= $category['categoryTitle'] ?></h4><?php */?>
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#navToLibrary" role="tab">
                            <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                            <span class="d-none d-sm-block"><?= $this->lang->line('library-of-courses') ?></span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#navToPublished" role="tab">
                            <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                            <span class="d-none d-sm-block"><?= $this->lang->line('published-courses') ?></span>
                        </a>
                    </li>
                </ul>
                <div class="tab-content p-3 text-muted">
                    <div class="tab-pane active" id="navToLibrary" role="tabpanel">
                        <div class="table-responsive mb-0" data-pattern="priority-columns">
                            <table class="table dt-responsive nowrap">
                                <thead>
                                <th>#</th>
                                <th><?= $this->lang->line("created-date") ?></th>
                                <th><?= $this->lang->line("course-title") ?></th>
                                <th><?= $this->lang->line("total-topics") ?></th>
                                <th><?= $this->lang->line("total-resources") ?></th>
                                <th><?= $this->lang->line("actions") ?></th>
                                </thead>
                                <tbody>
                                <?php foreach ($courses as $key => $course) { ?>
                                    <tr>
                                        <td><?= $key + 1 ?></td>
                                        <td><?= $course['createdAt'] ?></td>
                                        <td><?= $course['courseTitle'] ?></td>
                                        <td><?= $course['topicsCount'] ?></td>
                                        <td><?= $course['resourcesCount'] ?></td>
                                        <td>
                                            <a class="btn btn-primary"
                                               href="<?= base_url($activeLanguage . "/schools/course/" . $course['courseId']) ?>">
                                                <?= $this->lang->line('Setting') ?>
                                            </a>
                                            <button class="btn btn-warning publish-btn"
                                                    data-key="<?= $course['courseId'] ?>">
                                                <?= $this->lang->line('Publish') ?>
                                            </button>
                                        </td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane" id="navToPublished" role="tabpanel">
                        <div class="table-responsive">
                            <table class="table dt-responsive nowrap">
                                <thead>
                                <th>#</th>
                                <th><?= $this->lang->line("published-courses") ?></th>
                                <th><?= $this->lang->line("course-title") ?></th>
                                <th><?= $this->lang->line("total-topics") ?></th>
                                <th><?= $this->lang->line("start-date") ?></th>
                                <th><?= $this->lang->line("end-date") ?></th>
                                <th><?= $this->lang->line("targeted-genders") ?></th>
                                <th><?= $this->lang->line("targeted-levels") ?></th>
                                <th><?= $this->lang->line("targeted-users-types") ?></th>
                                <th><?= $this->lang->line("status") ?></th>
                                </thead>
                                <tbody>
                                <?php foreach ($publishedCourses as $key => $course) { ?>
                                    <tr>
                                        <td><?= $key + 1 ?></td>
                                        <td><?= $course['publishedAt'] ?></td>
                                        <td><?= $course['courseTitle'] ?></td>
                                        <td><?= $course['topicsCount'] ?></td>
                                        <td><?= $course['from'] ?></td>
                                        <td><?= $course['to'] ?></td>
                                        <td>
                                            <?php foreach (explode(',', $course['gendersList'] ?? "") as $gender) { ?>
                                                <span
                                                    class="badge rounded-pill bg-primary text-white p-2"><?= $gender; ?></span>
                                            <?php } ?>
                                        </td>
                                        <td>
                                            <?php foreach ($this->labels_formatter->format($course['levelsList']) as $level) { ?>
                                                <span
                                                    class="badge rounded-pill bg-success text-white p-2 badge-m-1"><?= $level ?></span>
                                            <?php } ?>
                                            <?php if ($this->labels_formatter->hasMore($course['levelsList'])) { ?>
                                                <span data-value="<?= $course['levelsList'] ?>"
                                                      class="badge rounded-pill bg-success text-white p-2 badge-m-1 show-more-labels">Show More...</span>
                                            <?php } ?>
                                        </td>
                                        <td>
                                            <?php foreach ($this->labels_formatter->format($course['typesList']) as $type) { ?>
                                                <span
                                                    class="badge rounded-pill bg-danger text-white p-2 badge-m-1"><?= str_replace(['1', '2', '3', '4'], ['Staff', 'Students', 'Teachers', 'Parents'], $type); ?></span>
                                            <?php } ?>
                                            <?php if ($this->labels_formatter->hasMore($course['typesList'])) { ?>
                                                <span data-value="<?= translate_types_codes($course['typesList']) ?>"
                                                      class="badge rounded-pill bg-danger text-white p-2 badge-m-1 show-more-labels">Show More...</span>
                                            <?php } ?>
                                        </td>
                                        <td>
                                            <label class="switch">
                                                <input type="checkbox" data-key="<?= $course['courseKey'] ?>"
                                                       class="status-item" <?= intval($course['status']) == 1 ? "checked" : "" ?>>
                                                <span class="slider round"></span>
                                            </label>
                                        </td>
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
</div>
<script src="<?= base_url("assets/libs/toastr/build/toastr.min.js") ?>"></script>
<script>
    $(".publish-btn").click(function () {
        const key = $(this).data("key");
        $('#publishCourse input[name="_course"]').val(key);
        $("#publishCourse").modal("show");
    });

    $("form#publish-course").on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: '<?= base_url("index.php/" . $activeLanguage . "/schools/publish-course/"); ?>' + $('#publishCourse input[name="_course"]').val(),
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                $('#publish-course button[type="Submit"]').attr('disabled', '').html('...');
            },
            success: function (data) {
                if (data.status === "error") {
                    toastr["error"](data.message);
                } else {
                    toastr["success"]("<?= $this->lang->line('saved') ?>");
                    setTimeout(() => {
                        location.reload();
                    }, 200);
                }
                $('#publish-course button[type="Submit"]').removeAttr('disabled', '').html('<?= $this->lang->line('Publish') ?>');
            },
            ajaxError: function () {
                toastr["success"]("<?= $this->lang->line('general-error') ?>");
            }
        });
    });

    $(".table").on('change', '.status-item', function (e) {
        const id = $(this).attr("data-key");
        $.ajax({
            type: 'POST',
            url: '<?= base_url("index.php/" . $activeLanguage . "/schools/published_courses/"); ?>' + id,
            data: {id},
            success: function (data) {
                Swal.fire(
                    '<?= $this->lang->line('success') ?>',
                    data,
                    'success'
                )
            },
            ajaxError: function () {
                Swal.fire(
                    'error',
                    'oops!! we have a error',
                    'error'
                )
            }
        });
    });
</script>
<?php $this->load->view("Shared/inc/show-more-labels") ?>