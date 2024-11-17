<style>
    .bar-t-s {
        background: linear-gradient(90deg, rgba(116, 83, 163, 1) 0%, rgba(121, 195, 236, 1) 99%);
        padding: 10px;
        color: #ffffff;
        border-radius: 4px;
        width: 100%;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .btn-outline-light {
        color: #fff;
    }

    .btn-outline-light:hover {
        color: #000;
    }
</style>
<script src="<?= base_url("assets/libs/apexcharts/apexcharts.min.js"); ?>"></script>
<div class="main-content">
    <div class="page-content">

        <div class="row">
            <?php foreach ($cards as $card) { ?>
                <div class="col-md-6 col-xl-3 InfosCards">
                    <div class="card">
                        <div class="card-body" style="background-color: #<?= $card['bg_color'] ?>;">
                            <div class="float-right mt-2">
                                <img src="<?= base_url("assets/images/icons/png_icons/") . $card['icons'] ?>" alt="<?= $card['Title'] ?>">
                            </div>
                            <div>
                                <h4 class="mb-1 mt-1">
                                    <span data-plugin="counterup">
                                        <?= $card['Data']['allCounter'] ?? '--' ?>
                                    </span>
                                </h4>
                                <p class="mb-0"><?= $card['Title'] ?></p>
                            </div>
                            <p class="mt-3 mb-0"><span class="mr-1" style="color: #ffffff;">
                                    <span>
                                        <?= $card['Data']['LastAdded'] ?? '--/--/--' ?>
                                    </span><br>
                                    <?= $card['last_title'] ?>
                            </p>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>

        <div class="row">
            <div class="col-12">
                <h4 class="card-title bar-t-s">
                    <span>MOE 002 COUNTER CARDS-ALL SURVEYS</span>
                    <div class="actions-container">
                        <button class="data-loader btn btn-outline-light"
                                data-source="AR/Ministry/new-dashboard/lab-tests">Default
                        </button>
                        <button class="data-loader btn btn-success"
                                data-source="AR/Ministry/new-dashboard/lab-tests-by-test">Show Per Test
                        </button>
                        <button class="data-loader btn btn-success"
                                data-source="AR/Ministry/new-dashboard/lab-tests-by-school">Show Per School
                        </button>
                    </div>
                </h4>
            </div>
            <div class="result-container w-100">
                <?php $this->load->view("AR/Ministry/new-dashboard/lab-tests") ?>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <h4 class="card-title bar-t-s">
                    <span>MOE 002 Daily  CARDS-ALL SURVEYS</span>
                    <div class="actions-container">
                        <button class="data-loader btn btn-outline-light"
                                data-source="AR/Ministry/new-dashboard/temp-tests">Default
                        </button>
                        <button class="data-loader btn btn-success"
                                data-source="AR/Ministry/new-dashboard/temp-tests-by-result">Show Per Test
                        </button>
                        <button class="data-loader btn btn-success"
                                data-source="AR/Ministry/new-dashboard/temp-tests-by-school">Show Per School
                        </button>
                    </div>
                </h4>
            </div>
            <div class="result-container w-100">
                <?php $this->load->view("AR/Ministry/new-dashboard/temp-tests") ?>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <h4 class="card-title bar-t-s">
                    <span>MOE 002 Home Quarantine And Quarantine</span>
                    <div class="actions-container">
                        <button class="data-loader btn btn-outline-light"
                                data-source="AR/Ministry/new-dashboard/actions-results">Default
                        </button>
                        <button class="data-loader btn btn-success"
                                data-source="AR/Ministry/new-dashboard/actions-results-by-school">Show Per School
                        </button>
                    </div>
                </h4>
            </div>
            <div class="result-container w-100">
                <?php $this->load->view("AR/Ministry/new-dashboard/actions-results") ?>
            </div>
        </div>

    </div>
</div>
<script>
    $(".data-loader").click(function () {
        const that = $(this);
        $(this).parents(".actions-container").children(".btn").removeClass("btn-outline-light");
        $(this).parents(".actions-container").children(".btn").addClass("btn-success");
        $(this).removeClass("btn-success");
        $(this).addClass("btn-outline-light");
        $.ajax({
            type: 'POST',
            url: '<?= base_url(); ?>EN/Ajax/ministry-reports-loader',
            data: {
                source: $(this).data("source")
            },
            beforeSend: function () {
                $(that).parents(".row").children(".result-container").html(`<div class="col-12"><div class="alert alert-primary w-100 text-center">المرجو الإنتظار....</div></div>`)
            },
            success: function (data) {
                if (data === "error") {
                    $(that).parents(".row").children(".result-container").html(`<div class="col-12"><div class="alert alert-danger w-100 text-center">نأسف لوجود خطأ</div></div>`)
                    return;
                }
                $(that).parents(".row").children(".result-container").html(data)
            },
            ajaxError: function () {
                $(that).parents(".row").children(".result-container").html(`<div class="col-12"><div class="alert alert-danger w-100 text-center">نأسف لوجود خطأ</div></div>`)
            }
        });
    });
</script>