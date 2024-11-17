<?php
/**
 * @var array $classes
 * @var callable $incidentsAction
 */
?>
<style>
    .loading-container {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 5rem;
    }
</style>
<link href="<?= base_url("assets/libs/select2/css/select2.min.css"); ?>" rel="stylesheet" type="text/css"/>
<div class="main-content">
    <div class="page-content">

        <div class="card">
            <div class="card-body">
                <label><?= __("select_the_class") ?></label>
                <select class="form-control" id="select_the_class">
                    <option value="" disabled selected><?= __("select_the_class") ?></option>
                    <?php foreach ($classes as $class) { ?>
                        <option value="<?= $class['Id'] ?>"><?= $class['Class'] ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="card students-card" style="display: none"></div>
        <div class="card results-card" style="display: none">
            <div class="card-body">

            </div>
        </div>
    </div>
</div>
<script src="<?= base_url("assets/libs/select2/js/select2.min.js"); ?>"></script>
<script>
    const selectStudent = $(".select-student");
    const studentsCard = $(".students-card");
    const loadingIndicator = `<div class="loading-container"><div class="spinner-border text-warning m-1" role="status" id="red1"><span class="sr-only"><?= __("loading") ?>...</span> </div></div>`;
    const resultsCard = $(".results-card");
    const results = $(".results-card .card-body");

    $(document).ready(function () {
        $('#select_the_class').change(function () {
            studentsCard.html(loadingIndicator);
            studentsCard.show();
            resultsCard.hide();
            $.ajax({
                type: 'POST',
                url: "<?= $incidentsAction("reports/students-list") ?>",
                data: {
                    class: $(this).val()
                },
                success: function (content) {
                    studentsCard.html(content);

                    $(".select-student").select2().on("change", function (e) {
                        fetchResultForStudent($(this).val());
                    });
                },
                error: function () {
                    studentsCard.html(`<div class=" alert alert-danger text-center w-100"><?= __("oops_error") ?></div>`);
                }
            });
        });
    });


    function fetchResultForStudent(studentId) {
        resultsCard.show();
        results.html(loadingIndicator);
        $.ajax({
            type: 'POST',
            url: "<?= current_url() ?>",
            data: {
                student: studentId
            },
            success: function (content) {
                results.html(content);
            },
            error: function () {
                results.html(`<div class=" alert alert-danger text-center w-100"><?= __("oops_error") ?></div>`);
            }
        });
    }
</script>