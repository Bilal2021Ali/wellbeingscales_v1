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
</style>
<div class="main-content">
    <div class="page-content">
        <div class="card">
            <div class="card-body overflow-auto">
                <table class="table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th><?= $this->lang->line('start-date') ?></th>
                        <th><?= $this->lang->line('end-date') ?></th>
                        <th><?= $this->lang->line('available-to') ?></th>
                        <th><?= $this->lang->line('users-types') ?></th>
                        <th><?= $this->lang->line('class-levels') ?></th>
                        <th><?= $this->lang->line('genders') ?></th>
                        <th><?= $this->lang->line('notes') ?></th>
                        <th><?= $this->lang->line('status') ?></th>
                        <th><?= $this->lang->line('actions') ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($published_courses as $key => $course) { ?>
                        <?php $gendersList = explode(",", $course['gendersList'] ?? ""); ?>
                        <tr id="course-tr-<?= $course['Id'] ?>">
                            <td><?= $key + 1 ?></td>
                            <td><?= $course['Startting_date'] ?></td>
                            <td><?= $course['End_date'] ?></td>
                            <td><?= $schoolsTypes[$course['Avalaible_to']] ?></td>
                            <td><?= $course['typesList'] ?? "" ?></td>
                            <td><?= $course['levelsList'] ?? "" ?></td>
                            <td><?= $course['gendersList'] ?? "" ?></td>
                            <td><?= $course['Guidance_Notes'] ?? "" ?></td>
                            <td>
                                <label class="switch">
                                    <input type="checkbox" class="status-item"
                                           data-key="<?= $course['Id']; ?>" <?= intval($course['status']) == 1 ? "checked" : "" ?>>
                                    <span class="slider round"></span>
                                </label>
                            </td>
                            <td class="text-center">
                                <a href="<?= base_url("" . $activeLanguage . "/schools/course/" . $course['Courses_Id'] . "/" . $course['Id']) ?>">
                                    <i class="uil uil-pen edit-item action-icon"></i>
                                </a>
                                <i class="uil uil-trash delete-item action-icon"
                                   data-key="<?= $course['Id']; ?>"></i>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    $('.table').DataTable();

    $(".table").on('click', '.delete-item', function (e) {
        const id = $(this).attr("data-key");
        Swal.fire({
            title: '<?= $this->lang->line('are-you-sure-you-want-to-delete-this-topic') ?>',
            showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: `<?= $this->lang->line('yes') ?>`,
            cancelButtonText: `<?= $this->lang->line('cancel') ?>`,
            icon: 'warning',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'DELETE',
                    url: '<?= current_url(); ?>',
                    data: {id},
                    success: function (data) {
                        if (data.status === "ok") {
                            Swal.fire('success', '<?= $this->lang->line('the-item-has-been-deleted-successfully') ?>', 'success');
                            $('#course-tr-' + id).remove();
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