<?php


/**
 * @var array $locations
 * @var bool $isMinistry
 */
?>
<link href="<?= base_url("assets/libs/select2/css/select2.min.css"); ?>" rel="stylesheet" type="text/css"/>
<style>
    .loading-container {
        height: 250px;
        display: grid;
        width: 100%;
        align-items: center;
        justify-items: center;
    }
</style>
<div class="main-content">
    <div class="page-content">

        <div class="card">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-4 col-sm-12">
                        <h4 class="mb-0"><?= __("summary") ?></h4>
                    </div>
                    <div class="col-md-8 col-sm-12">
                        <?php $this->load->view("Shared/Schools/Incidents/reports/inc/" . ($isMinistry ? 'Ministry' : 'School') . "/filters") ?>
                    </div>
                    <button class="btn btn-primary w-100 mt-2" type="button" id="apply-filters">
                        <?= __("apply_filters") ?>
                    </button>
                </div>
            </div>
        </div>

        <div id="results"></div>

    </div>
</div>
<script src="<?= base_url("assets/libs/select2/js/select2.min.js"); ?>"></script>
<script>
    const loadingIndicator = `<div class="loading-container"><div class="spinner-border text-warning m-1" role="status" id="red1"><span class="sr-only"><?= __("loading") ?>...</span> </div></div>`;
    const results = $('#results');
    const getResults = () => {
        results.html(loadingIndicator);
        const data = {
            statuses: $('#incident-status').val(),
            categories: $('#category').val(),
            locations: $('#location').val(),
        };

        <?php if ($isMinistry) { ?>
            data['school'] = $("#schools").val()
        <?php } ?>

        $.ajax({
            type: 'POST',
            url: "<?= current_url() ?>",
            data,
            success: function (content) {
                results.html(content);
            },
            error: function () {
                results.html(`<div class=" alert alert-danger text-center w-100"><?= __("oops_error") ?></div>`);
            }
        });
    }

    document.addEventListener("DOMContentLoaded", getResults);
    $(".select-2").select2();

    $("#apply-filters").on("click", getResults);
</script>