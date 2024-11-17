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

    .add-card {
        text-align: center;
        min-height: 310px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 30px;
    }

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

    .action-icon {
        font-size: 20px;
    }

    .delete-item {
        cursor: pointer;
        color: #ff4b4b;
    }

    .back-btn {
        font-size: 18px;
        width: 100%;
        display: block;
        text-align: right;
        padding-bottom: 10px;
    }
</style>
<div class="main-content">
    <div class="page-content">
        <div class="row">
            <?php foreach ($topics as $key => $topic) { ?>
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="card category-card">
                        <div class="card-body">
                            <div class="counter-element"><?= $key + 1 ?></div>
                            <div class="counter-element"><?= $topic['categoryTitle'] ?></div>
                            <div class="counter-element"><?= $topic['courseTitle'] ?></div>
                            <div class="counter-element"><?= $topic['topicTitle'] ?></div>
                            <a href="<?= base_url("EN/Courses/resources-list/" . $topic['topicId']) ?>"
                               class="counter-element"><?= $topic['resourcesCount'] ?> Resources</a>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="card category-card">
                    <div class="card-body add-card">
                        <a href="<?= base_url("EN/Courses/topic/" . $courseId) ?>">
                            <i class="uil uil-plus"></i>
                            <p>Add</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body overflow-auto">
                <table class="table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Topic Title</th>
                        <th>Topic Description</th>
                        <th>File Type</th>
                        <th>Actions</th>
                        <th>Status</th>
                        <th>Add Resource</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($topics as $key => $topic) { ?>
                        <tr id="topic-tr-<?= $topic['topicId'] ?>">
                            <td><?= $key + 1 ?></td>
                            <td><?= $topic['topicTitle'] ?></td>
                            <td><?= $topic['topicDescription'] ?></td>
                            <td><?= $topic['topicFileUrlType'] ?> | <?= $topic['topicComments'] ?></td>
                            <td class="text-center">
                                <a href="<?= base_url("EN/Courses/topic/" . $topic['courseId'] . "/" . $topic['topicId']) ?>">
                                    <i class="uil uil-pen edit-item action-icon"></i>
                                </a>
                                <i class="uil uil-trash delete-item action-icon"
                                   data-key="<?= $topic['topicId']; ?>"></i>
                            </td>
                            <td>
                                <label class="switch">
                                    <input type="checkbox" class="status-item"
                                           data-key="<?= $topic['topicId']; ?>" <?= intval($topic['Status']) == 1 ? "checked" : "" ?>>
                                    <span class="slider round"></span>
                                </label>
                            </td>
                            <td>
                                <a class="btn btn-primary w-100"
                                   href="<?= base_url("EN/Courses/resources-list/" . $topic['topicId']) ?>">
                                    <i class="uil uil-plus"></i>
                                    Add Resource
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
        <a href="<?= base_url("EN/Courses/courses-list/" . $course['Category_Id']) ?>" class="text-muted back-btn">
            <i class="uil uil-arrow-left"></i> | Back
        </a>
    </div>
</div>
<script>
    $(".table").on('click', '.delete-item', function (e) {
        const id = $(this).attr("data-key");
        Swal.fire({
            title: 'Are you sure you want to delete this topic ?',
            showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: `yes`,
            cancelButtonText: `cancel`,
            icon: 'warning',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'DELETE',
                    url: '<?= current_url(); ?>',
                    data: {id},
                    success: function (data) {
                        if (data.status === "ok") {
                            Swal.fire('success', 'The Item has been deleted successfully', 'success');
                            $('#topic-tr-' + id).remove();
                        } else {
                            Swal.fire('error', data.message, 'error');
                        }
                    },
                    ajaxError: function () {
                        Swal.fire(
                            'error',
                            'oops!! we have an unexpected error',
                            'error'
                        )
                    }
                });
            }
        })
    });

    $(".table").on('change', '.status-item', function (e) {
        const id = $(this).attr("data-key");
        $.ajax({
            type: 'POST',
            url: '<?= current_url(); ?>',
            data: {id},
            success: function (data) {
                Swal.fire(
                    'success',
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