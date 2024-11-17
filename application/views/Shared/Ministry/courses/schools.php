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
<div class="main-content">
    <div class="page-content">
        <div class="card">
            <div class="card-body">
                <table class="table dt-responsive nowrap">
                    <thead>
                    <th>#</th>
                    <th><?= $this->lang->line("school-name") ?></th>
                    <th><?= $this->lang->line("published") ?></th>
                    <th><?= $this->lang->line("publish-date") ?></th>
                    <th><?= $this->lang->line("status") ?></th>
                    </thead>
                    <tbody>
                    <?php foreach ($courses as $key => $course) { ?>
                        <?php $isPublished = $course['publishedCount'] > 0; ?>
                        <tr>
                            <td><?= $key + 1 ?></td>
                            <td><?= $course['schoolName'] ?></td>
                            <td>
                                <?php if ($isPublished) { ?>
                                    <div class="btn btn-success w-100">
                                        <?= $this->lang->line("published") ?>
                                    </div>
                                <?php } else { ?>
                                    <div class="btn btn-danger w-100">
                                        <?= $this->lang->line("unpublished") ?>
                                    </div>
                                <?php } ?>
                            </td>
                            <td><?= $course['publishedAt'] ?? "" ?></td>
                            <td>
                                <label class="switch">
                                    <input type="checkbox" disabled
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