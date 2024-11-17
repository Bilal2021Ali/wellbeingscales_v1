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

    .category-card .card-body .counter-element:nth-child(6) {
        color: #fff;
        background: #70ad47;
    }

    .category-card .card-body .counter-element:nth-child(7) {
        color: #fff;
        background: #ed7d31;
    }

    .category-card .card-body .counter-element:nth-child(8) {
        color: #fff;
        background: #4472c4;
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
        background-color: #ccc;
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
        background-color: #009624;
    }

    input:focus + .slider {
        box-shadow: 0 0 1px #009624;
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
<div class="main-content">
    <div class="page-content">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4"><?= $category['categoryTitle'] ?></h4>
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#navToLibrary" role="tab">
                            <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                            <span class="d-none d-sm-block"><?= __('library-of-courses') ?></span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#navToPublished" role="tab">
                            <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                            <span class="d-none d-sm-block"><?= __('published-courses') ?></span>
                        </a>
                    </li>
                </ul>
                <div class="tab-content p-3 text-muted">
                    <div class="tab-pane active" id="navToLibrary" role="tabpanel">
                        <div class="table-responsive mb-0" data-pattern="priority-columns">
                            <table class="table dt-responsive nowrap">
                                <thead>
                                <th>#</th>

                                <th><?= __("course-title") ?></th>

                                <th><?= __("total-topics") ?></th>
                                <th><?= __("total-resources") ?></th>
                                <th><?= __("actions") ?></th>
                                </thead>
                                <tbody>
                                <?php foreach ($courses as $key => $course) { ?>
                                    <tr>
                                        <td><?= $key + 1 ?></td>

                                        <td><?= $course['courseTitle'] ?></td>

                                        <td><?= $course['topicsCount'] ?></td>
                                        <td><?= $course['resourcesCount'] ?></td>
                                        <td>
                                            <a class="btn btn-primary"
                                               href="<?= base_url($activeLanguage . "/DashboardSystem/course/" . $course['courseId']) ?>">
                                                <?= __('Setting') ?>
                                            </a>
                                            <a class="btn btn-warning"
                                               href="<?= base_url($activeLanguage . "/DashboardSystem/publish-course/" . $course['courseId']) ?>">
                                                <?= __('Publish') ?>
                                            </a>
                                        </td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane" id="navToPublished" role="tabpanel">
                        <div class="table-responsive mb-0" data-pattern="priority-columns">
                            <table class="table dt-responsive nowrap">
                                <thead>
                                <th>#</th>
                                <th><?= __("created-date") ?></th>
                                <th><?= __("course-title") ?></th>
                                <th><?= __("start-date") ?></th>
                                <th><?= __("end-date") ?></th>
                                <th><?= __("total-topics") ?></th>
                                <th><?= __("school-used") ?></th>
                                <th><?= __("review") ?></th>
                                <th><?= __("actions") ?></th>
                                </thead>
                                <tbody>
                                <?php foreach ($publishedCourses as $key => $course) { ?>
                                    <tr>
                                        <td><?= $key + 1 ?></td>
                                        <td><?= $course['createdAt'] ?></td>
                                        <td><?= $course['courseTitle'] ?></td>
                                        <td><?= $course['startAt'] ?></td>
                                        <td><?= $course['endDate'] ?></td>
                                        <td><?= $course['topicsCount'] ?></td>
                                        <td><?= $course['publishedCount'] ?></td>
                                        <td><?= $course['reviews'] ?></td>
                                        <td class="text-center ps-relative">
                                            <!-- <a href="-->
                                            <?php //= base_url($activeLanguage . "/DashboardSystem/course/" . $course['courseId']) ?><!--">-->
                                            <!-- <i style="font-size: 18px" class="uil uil-eye"></i>-->
                                            <!-- </a>-->
                                            <label class="switch">
                                                <input type="checkbox" class="status-switch"
                                                       data-id="<?= $course['publishId'] ?>" <?= intval($course["publishStatus"]) == 1 ? "checked" : "" ?>>
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
<script>
    $(".table").DataTable();
    $("table").on("change", '.status-switch', function () {
        const id = $(this).data("id");
        $.ajax({
            type: 'POST',
            url: '<?= current_url(); ?>',
            data: {id},
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