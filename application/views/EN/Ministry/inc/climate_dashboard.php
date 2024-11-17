<link href="<?= base_url("assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css") ?>" rel="stylesheet">
<link href="<?= base_url("assets/libs/select2/css/select2.min.css"); ?>" rel="stylesheet" type="text/css"/>
<script src="<?= base_url("assets/libs/select2/js/select2.min.js"); ?>"></script>

<style>
    .choice {
        height: 10px;
    }

    .col.text-center {
        font-size: 10px;
        margin-bottom: 5px;
    }

    .GaugeChartContainer {
        height: 160px;
    }

    .emptysurvey {
        max-width: 300px;
        margin: auto;
        padding: 20px;
    }

    .disabled {
        background-color: #404040 !important;
        pointer-events: none;
        border: 0px;
        color: #a3a3a3 !important;
    }

    .hori-timeline {
        display: flex;
        overflow-x: auto;
    }

    .climatesurvey {
        flex: 0 0 auto;
    }
</style>

<?php if (isset($fullpage)) { ?>
<div class="main-content">
    <div class="page-content">
        <?php } ?>

        <div class="col-12">
            <h4 class="card-body text-center"
                style="background: #33a2ff; padding: 10px;color: #fcf9f9;border-radius: 4px;">CLIMATE SURVEY
                REPORTS</h4>
            <div class="card">
                <div class="card-body">
                    <form class="row" method="post">
                        <div class="col">
                            <label>Category name:</label>
                            <select class="form-control categoryfilter">
                                <option value="all">All</option>
                                <?php foreach (array_unique(array_column($climate_surveys, "Cat_id")) as $key => $category) { ?>
                                    <option value="<?= $category ?>"><?= $climate_surveys[$key]['Cat_en'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <?php if (isset($filters)) { ?>
                            <div class="col">
                                <label>School name:</label>
                                <select name="school" class="form-control">
                                    <option value="all">All</option>
                                    <?php foreach ($our_schools as $key => $school) { ?>
                                        <option <?= $this->input->post('school') == $school['Id'] ? "selected" : "" ?>
                                                value="<?= $school['Id'] ?>"><?= $school['School_Name_EN'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col">
                                <label for="climate-title">Climate title:</label>
                                <select name="climate_title" id="climate-title" class="form-control climates-titles">
                                    <option value="all">All</option>
                                    <?php foreach ($results as $climate) { ?>
                                        <option value="<?= $climate['setId'] ?>">
                                            <?= $climate['title'] ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                        <?php } ?>
                        <div class="col-12 mb-2">
                            <label class="form-label"> Date Range :</label>
                            <div class="input-daterange input-group" id="datepicker6" data-date-format="yyyy-mm-dd"
                                 data-date-autoclose="true" data-provide="datepicker"
                                 data-date-container='#datepicker6'>
                                <input type="text" class="form-control" autocomplete="off"
                                       value="<?= $filters["from"] ?>" name="from" placeholder="From"/>
                                <input type="text" class="form-control" autocomplete="off" name="to"
                                       value="<?= $filters["to"] ?>" placeholder="to"/>
                            </div>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary w-100 mt-2">Apply</button>
                        </div>
                    </form>
                    <?php if (!empty($results)) { ?>
                        <div class="row w-100" dir="ltr">
                            <?php foreach ($results as $survey) { ?>
                                <div class="climatesurvey col-md-3 col-sm-6 col-xs-12 mt-5 text-center" data-category-id="<?= $survey['category_id']; ?>">
                                    <div class="text-center">
                                        <h5 class="font-size-14 mb-3"><?= $survey['title'] ?></h5>
                                        <input class="knob" data-width="150" data-height="150" data-linecap="round"
                                               data-fgColor="#0eacd8" value="<?= round($survey['ff'], 1) ?>"
                                               data-skin="tron" data-angleOffset="180" data-readOnly="true"
                                               data-thickness=".4"/>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    <?php } else { ?>
                        <div class="p-5 w-100 text-center">
                            <img style="max-width: 300px;" class="w-100 mb-5"
                                 src="<?= base_url("assets/images/nosurveys.svg") ?>" alt="No surveys available">
                            <h6>No data available</h6>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>

        <?php if (isset($fullpage)) { ?>
    </div>
</div>
<?php } ?>

<script src="<?= base_url("assets/libs/jquery-knob/jquery.knob.min.js") ?>"></script>
<script src="<?= base_url("assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js") ?>"></script>
<script>
    const colors = ["#34c38f", "#5b73e8", "#f1b44c", "#50a5f1", "#ff6b6b", "#1dd1a1", "#feca57", "#5f27cd", "#222f3e", "#2e86de", "#f368e0", "#feca57"];

    $(function () {
        $(".knob").knob();
        $('.knob').each(function () {
            const $this = $(this);
            const value = $this.val();
            $(this).val(value + "%");
        });
    });

    const climates = $(".climates-titles");
    let data = <?= json_encode(array_map(function ($item) {
        return [
            'id' => $item['setId'],
            'category_id' => $item['category_id'],
            'text' => $item['title'],
        ];
    }, $results)) ?>;

    $('.categoryfilter').change(function () {
        var val = $(this).val();
        if (val !== "all") {
            $('.climatesurvey').hide();
            $('.climatesurvey[data-category-id="' + val + '"]').show();
        } else {
            $('.climatesurvey').show();
        }

        const category_id = parseInt(val);
        const result = isNaN(category_id) ? data : data.filter(item => parseInt(item.category_id) === category_id);

        climates.empty();
        climates.select2({
            data: [
                {
                    id: "all",
                    text: "All"
                },
                ...result
            ]
        });
    });

    $(".select2").select2();
    climates.select2({
        data
    }); 
</script>
