<link href="<?= base_url("assets/libs/select2/css/select2.min.css"); ?>" rel="stylesheet" type="text/css"/>
<script src="<?= base_url("assets/libs/apexcharts/apexcharts.min.js") ?>"></script>
<script src="<?= base_url("assets/libs/select2/js/select2.min.js"); ?>"></script>
<style>
    .loading-container {
        height: 350px;
        display: grid;
        width: 100%;
        align-items: center;
        justify-items: center;
    }

    .rounded-container {
        height: 10rem;
        border-radius: 100%;
        border-width: 0.6rem;
        border-style: solid;
        width: 10rem;
        display: grid;
        align-items: center;
        justify-items: center;
        align-content: center;
    }

    .rounded-container p {
        margin: 0;
        font-weight: bold;
    }

    #results_statuses .col-lg-4:not(.last) {
        border-right: 1px solid #ececec;
    }
</style>
<div class="main-content">
    <div class="page-content">

        <h4 class="card-title"
            style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px"><?= __("speak-out-dashboard") ?> </h4>
        <?php if ($isMinistry) { ?>
            <?php $this->load->view("Shared/Schools/speak-out/inc/filters") ?>
        <?php } ?>
        <div class="card">
            <div class="card-body">
                <h3 class="card-title"><?= __("monthly-reports-by-category") ?></h3>
                <div class="row">
                    <div class="col-lg-9" id="results_categories"></div>
                    <div class="col-lg-3">
                        <label><?= __("school-year") ?>:</label>
                        <select class="form-control" name="school-year">
                            <?php foreach ($years as $year) { ?>
                                <option value="<?= $year ?>"><?= $year ?></option>
                            <?php } ?>
                        </select>

                        <label><?= __("incident-type") ?>:</label>
                        <div class="categories-container">
                            <?php foreach ($categories as $key => $category) { ?>
                                <div class="custom-control custom-checkbox">
                                    <input value="<?= $category['id'] ?>" type="checkbox" name="categories[]"
                                           class="custom-control-input"
                                           id="category_<?= $key ?>">
                                    <label class="custom-control-label"
                                           for="category_<?= $key ?>"><?= $category['name'] ?></label>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h3 class="card-title"><?= __("total-created-speak-out") ?></h3>
                <div class="row">
                    <div class="col-lg-9" id="results_categories_line"></div>
                    <div class="col-lg-3">
                        <label><?= __("school-year") ?>:</label>
                        <select class="form-control" name="school-year-line">
                            <?php foreach ($years as $year) { ?>
                                <option value="<?= $year ?>"><?= $year ?></option>
                            <?php } ?>
                        </select>

                        <label><?= __("incident-type") ?>:</label>
                        <div class="categories-container">
                            <?php foreach ($categories as $key => $category) { ?>
                                <div class="custom-control custom-checkbox">
                                    <input value="<?= $category['id'] ?>" type="checkbox" name="line_categories[]"
                                           class="custom-control-input"
                                           id="line_report_category_<?= $key ?>">
                                    <label class="custom-control-label"
                                           for="line_report_category_<?= $key ?>"><?= $category['name'] ?></label>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6 col-sm-12">
                                <h3 class="card-title"><?= __("reports-by-status") ?></h3>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <select class="form-control" name="opening-status-month">
                                    <?php foreach ($months as $key => $month) { ?>
                                        <option <?= $key === 0 ? "selected" : "" ?>
                                                value="<?= $key + 1 ?>"><?= $month ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div id="results_opening_status"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6 col-sm-12">
                                <h3 class="card-title"><?= __("reports-by-locations") ?></h3>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <select class="form-control" name="choice-month">
                                    <?php foreach ($months as $key => $month) { ?>
                                        <option <?= $key === 0 ? "selected" : "" ?>
                                                value="<?= $key + 1 ?>"><?= $month ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div id="choices_results"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6 col-sm-12">
                                <h3 class="card-title"><?= __("reports-by-gender") ?></h3>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <select class="form-control" name="month">
                                    <?php foreach ($months as $key => $month) { ?>
                                        <option <?= $key === 0 ? "selected" : "" ?>
                                                value="<?= $key + 1 ?>"><?= $month ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div id="results_genders"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6 col-sm-12">
                                <h3 class="card-title"><?= __("reports-by-identity") ?></h3>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <select class="form-control" name="identity-month">
                                    <?php foreach ($months as $key => $month) { ?>
                                        <option <?= $key === 0 ? "selected" : "" ?>
                                                value="<?= $key + 1 ?>"><?= $month ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div id="results_identity"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h3 class="card-title"><?= __("monthly-reports-by-class") ?></h3>
                <div class="row">
                    <div class="col-lg-9" id="results_classes"></div>
                    <div class="col-lg-3">
                        <label><?= __("school-year") ?>:</label>
                        <select class="form-control" name="classes-school-year">
                            <?php foreach ($years as $year) { ?>
                                <option value="<?= $year ?>"><?= $year ?></option>
                            <?php } ?>
                        </select>

                        <label> <?= __("incident-type") ?> :</label>
                        <div class="categories-container">
                            <?php foreach ($categories as $key => $category) { ?>
                                <div class="custom-control custom-checkbox">
                                    <input value="<?= $category['id'] ?>" type="checkbox"
                                           name="classes_categories[]"
                                           class="custom-control-input"
                                           id="classes_category_<?= $key ?>">
                                    <label class="custom-control-label"
                                           for="classes_category_<?= $key ?>"><?= $category['name'] ?></label>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php $this->load->view("Shared/Schools/speak-out/sections/by-status") ?>
        <?php $this->load->view("Shared/Schools/speak-out/sections/by-priority") ?>
    </div>
</div>
<script>
    const loadingDiv = `<div class="loading-container"><div class="spinner-border text-warning m-1" role="status" id="red1"><span class="sr-only"><?= __("loading") ?>...</span> </div></div>`;
    const errorContent = `<div class="alert alert-danger w-100"><?= __("error") ?></div>`;

    const yearSelect = $('select[name="school-year"]');
    const yearLineSelect = $('select[name="school-year-line"]');
    const monthSelect = $('select[name="month"]');
    const classSelect = $('select[name="classes[]"]');
    const statusMonthSelect = $('select[name="status-month"]');
    const priorityMonthSelect = $('select[name="priority-month"]');

    const url = '<?= base_url("/index.php/" . $language . "/" . ($isMinistry ? "DashboardSystem" : "schools") . "/speak-out-dashboard"); ?>';
    const TYPES = {
        category: "category",
        gender: "gender",
        class: "class",
        status: "status",
        openingStatus: "openingStatus",
        choice: "choice",
        identity: "identity",
        PRIORITY: "priority"
    };

    function getDefaultOptions() {
        <?php if ($isMinistry){ ?>
        return {
            school: $('select[name="school"]').val(),
            defaultGender: $('select[name="global-gender"]').val() ?? "",
        };
        <?php } else{ ?>
        return {};
        <?php } ?>
    }

    $(".select2").select2();
</script>
<script>
    function resultsCategories(isLine = false) {
        const results = $(isLine ? '#results_categories_line' : '#results_categories');
        const yearInput = isLine ? yearLineSelect : yearSelect;
        console.log({isLine});
        results.html(loadingDiv);

        const categories = [];
        $(`input[name="${isLine ? 'line_categories' : 'categories'}[]"]:checked`).each(function () {
            categories.push($(this).val());
        });

        $.ajax({
            type: 'POST',
            url,
            data: {
                ...getDefaultOptions(),
                type: TYPES.category,
                categories,
                year: yearInput.val(),
                isLine: isLine ? 1 : 0
            },
            success: function (data) {
                results.html(data);
            },
            ajaxError: function () {
                results.html(errorContent);
            }
        });
    }

    resultsCategories();
    yearSelect.change(function () {
        resultsCategories();
    });
    $('input[name="categories[]"]').on('change', function () {
        resultsCategories();
    });
</script>
<script>

    resultsCategories(true);
    yearLineSelect.change(function () {
        resultsCategories(true)
    });

    $('input[name="line_categories[]"]').on('change', function () {
        resultsCategories(true)
    });
</script>

<script>
    const openingStatusMonthSelect = $('select[name="opening-status-month"]');

    function resultsByOpeningStatus() {
        const results = $('#results_opening_status');
        results.html(loadingDiv);

        $.ajax({
            type: 'POST',
            url,
            data: {
                ...getDefaultOptions(),
                type: TYPES.openingStatus,
                month: openingStatusMonthSelect.val()
            },
            success: function (data) {
                results.html(data);
            },
            ajaxError: function () {
                results.html(errorContent);
            }
        });
    }

    resultsByOpeningStatus();
    openingStatusMonthSelect.change(resultsByOpeningStatus);
</script>

<script>
    const choicesMonthSelect = $('select[name="choice-month"]');

    function resultsByChoices() {
        const results = $('#choices_results');
        results.html(loadingDiv);

        $.ajax({
            type: 'POST',
            url,
            data: {
                ...getDefaultOptions(),
                type: TYPES.choice,
                month: choicesMonthSelect.val()
            },
            success: function (data) {
                results.html(data);
            },
            ajaxError: function () {
                results.html(errorContent);
            }
        });
    }

    resultsByChoices();
    choicesMonthSelect.change(resultsByChoices);
</script>

<script>
    function resultsByGender() {
        const results = $('#results_genders');
        results.html(loadingDiv);

        $.ajax({
            type: 'POST',
            url,
            data: {
                ...getDefaultOptions(),
                type: TYPES.gender,
                month: monthSelect.val()
            },
            success: function (data) {
                results.html(data);
            },
            ajaxError: function () {
                results.html(errorContent);
            }
        });
    }

    resultsByGender();
    monthSelect.change(resultsByGender);

</script>
<script>
    const identityMonth = $('select[name="identity-month"]');

    function resultsByIdentity() {
        const results = $('#results_identity');
        console.log({results});
        results.html(loadingDiv);

        $.ajax({
            type: 'POST',
            url,
            data: {
                ...getDefaultOptions(),
                type: TYPES.identity,
                month: identityMonth.val()
            },
            success: function (data) {
                results.html(data);
            },
            ajaxError: function () {
                results.html(errorContent);
            }
        });
    }

    resultsByIdentity();
    identityMonth.change(resultsByIdentity);

</script>
<script>
    const yearInput = $('select[name="classes-school-year"]');

    function resultsByClasses() {
        const results = $('#results_classes');
        results.html(loadingDiv);

        const categories = [];
        $(`input[name="classes_categories[]"]:checked`).each(function () {
            categories.push($(this).val());
        });

        $.ajax({
            type: 'POST',
            url,
            data: {
                ...getDefaultOptions(),
                type: TYPES.class,
                categories,
                year: yearInput.val(),
                isLine: 0
            },
            success: function (data) {
                results.html(data);
            },
            ajaxError: function () {
                results.html(errorContent);
            }
        });
    }

    resultsByClasses();
    yearInput.change(resultsByClasses);
    $('input[name="classes_categories[]"]').on('change', function () {
        resultsByClasses();
    });
</script>
<?php $this->load->view("Shared/Schools/speak-out/inc/results-by-status"); ?>
<?php $this->load->view("Shared/Schools/speak-out/inc/results-by-priority"); ?>
<?php if ($isMinistry) { ?>
    <script>
        $(".filters-form select").change(function () {
            resultsCategories();
            resultsCategories(true);
            resultsByGender();
            resultsByClasses();
            resultsByStatus();
            resultsByIdentity();
            resultsByOpeningStatus();
            resultsByPriority();
            resultsByChoices();
        });
    </script>
<?php } ?>