<style>
    .references {
        align-items: center;
    }

    .references span {
        width: 140px;
        text-align: center;
    }

    .data-container {
        min-height: 30vh;
    }

    .data-container.loading {
        display: grid;
        align-items: center;
        justify-items: center;
    }
</style>
<link href="<?= base_url("assets/libs/select2/css/select2.min.css"); ?>" rel="stylesheet" type="text/css"/>
<script src="<?= base_url(); ?>assets/libs/select2/js/select2.min.js"></script>
<div class="main-content">
    <div class="page-content">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-10">
                        <label class="mt-2">Filter By Type :</label>
                        <select name="users-types" multiple class="form-control select2">
                            <option disabled selected>All</option>
                            <?php foreach ($usersTypes as $key => $usersType) { ?>
                                <option value="<?= $key ?>"><?= $usersType ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-lg-2">
                        <?php foreach ($bars as $key => $bar) { ?>
                            <div class="d-flex references">
                                <div class="progress w-100">
                                    <div class="progress-bar progress-bar-striped bg-<?= $bar ?>" role="progressbar"
                                         style="width: 100%" aria-valuenow="100" aria-valuemin="0"
                                         aria-valuemax="100"></div>
                                </div>
                                <span><?= $key ?></span>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <?php foreach ($usersTypes as $typeCode => $key) { ?>
                    <div class="w-100 mt-2 usertype-results-container" id="<?= $typeCode ?>-results-container">
                        <h3><?= $key ?></h3>
                        <hr>
                        <div class="data-container" id="<?= $key ?>"></div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
<script>
    const loadingIndicator = `<div class="loading-row">Loading...</div>`;
    const supportedTypes = <?= json_encode(array_values($usersTypes)); ?>;
    $(".select2").select2({
        placeholder: "Select types",
        closeOnSelect: false,
        allowClear: true
    });

    function fetchData() {
        supportedTypes.forEach(function (type) {
            const container = $("#" + type);
            $.ajax({
                type: 'POST',
                url: '<?= base_url("EN/schools/climate-users-results/" . $id); ?>?type=' + type,
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function () {
                    container.addClass("loading").html(loadingIndicator);
                },
                success: function (html) {
                    container.removeClass("loading").html(html);
                },
                ajaxError: function () {
                    container.addClass("loading text-danger").html("Ooops! There Was an Unexpected Error.");
                }
            });
        });
    }

    $(document).ready(function () {
        fetchData();
    });

    $('select[name="users-types"]').change(function () {
        const selected = $('select[name="users-types"]').val();
        const containers = $(".usertype-results-container");
        if (selected.includes("all")) {
            containers.show();
            return;
        }

        containers.hide();
        selected.forEach(function (code) {
            $("#" + code + "-results-container").show();
        });
    });
</script>