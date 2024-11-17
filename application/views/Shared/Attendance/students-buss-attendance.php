<?php
/**
 * @var array $vehicles
 * @var bool $isMinistry
 * @var array $schools
 * @var Carbon $date
 */

use Carbon\Carbon;

$cols = $isMinistry ? '4' : '6';
?>
<link href="<?= base_url("assets/libs/select2/css/select2.min.css"); ?>" rel="stylesheet" type="text/css"/>
<link href="<?= base_url("assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css"); ?>" rel="stylesheet">

<div class="main-content">
    <div class="page-content">
        <div class="card">
            <form id="filters" class="card-body">
                <div class="row">
                    <div class="col-lg-<?= $cols ?>">
                        <label><?= __("vehicles") ?></label>
                        <select class="form-control select2" multiple id="vehicles">
                            <?php foreach ($vehicles as $vehicle) { ?>
                                <option value="<?= $vehicle['Id'] ?>"><?= $vehicle['No_vehicle'] ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="col-lg-<?= $cols ?>">
                        <label><?= __("date") ?></label>
                        <input type="text" class="form-control" value="<?= $date->format('Y-m-d') ?>"
                               data-provide="datepicker" data-date-autoclose="true" id="date" required
                               data-date-format="yyyy-mm-dd" name="DOP">
                    </div>

                    <?php if ($isMinistry) { ?>
                        <div class="col-lg-<?= $cols ?>">
                            <label><?= __("schools") ?></label>
                            <select class="form-control select2" multiple name="vehicles" id="schools">
                                <?php foreach ($schools as $school) { ?>
                                    <option value="<?= $school['Id'] ?>"><?= $school['name'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    <?php } ?>

                </div>
                <button type="submit" class="btn btn-primary w-100 mt-2"><?= __("apply") ?></button>
            </form>
        </div>
        <div class="card">
            <div id="results-container" class="card-body">
            </div>
        </div>
    </div>
</div>

<script src="<?= base_url("assets/libs/select2/js/select2.min.js") ?>"></script>
<script src="<?= base_url("assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js") ?>"></script>
<script src="<?= base_url("assets/libs/datatables.net-buttons/js/buttons.html5.min.js"); ?>"></script>
<script src="<?= base_url("assets/libs/datatables.net-buttons/js/buttons.print.min.js"); ?>"></script>
<script src="<?= base_url("assets/libs/datatables.net-buttons/js/buttons.colVis.min.js"); ?>"></script>

<script>
    const loadingContent = `<div class="text-center"><div class="spinner-border text-info m-1" role="status"><span class="sr-only">Loading...</span></div></div>`;
    const resultsContainer = $("#results-container");

    const getFilters = () => {
        const results = {
            vehicles: [],
            schools: [],
            date: '',
        };

        const vehicles = $("#vehicles");
        if (vehicles) {
            results.vehicles = vehicles.val();
        }

        const schools = $("#schools");
        if (schools) {
            results.schools = schools.val();
        }

        results.date = $("#date").val();
        return results;
    }

    const getResults = () => {
        const data = getFilters();
        $.ajax({
            type: 'POST',
            url: '<?= current_url(); ?>',
            data,
            beforeSend: function () {
                resultsContainer.html(loadingContent);
            },
            success: function (data) {
                resultsContainer.html(data);
            },
            error: function (request, status, error) {
                if (request.status === 400) {
                    resultsContainer.html(`<div class="alert alert-danger text-center w-100"><?= __("the date can't be in the future") ?></div>`);
                    return;
                }
                resultsContainer.html(`<div class="alert alert-danger text-center w-100"><?= __("oops_error") ?></div>`);
            }
        });
    }


    $(document).ready(function () {
        $(".select2").select2({
            closeOnSelect: false,
            allowClear: true
        });
        getResults();
    });

    $("#filters").submit(function (e) {
        e.preventDefault();
        getResults();
    });
</script>
