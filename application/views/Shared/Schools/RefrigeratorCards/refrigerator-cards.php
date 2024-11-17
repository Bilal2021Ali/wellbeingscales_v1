<?php
/**
 * @var array $school
 */
?>

<style>
    td,
    th {
        text-align: center;
    }

    .Td-Results_font span {
        font-size: 20px !important;
        padding: 6px;
    }

    .badge, .temp .value {
        text-align: center;
        font-size: 24px;
        font-weight: 500;
        line-height: 1;
    }

    .card-body {
        text-align: center;
    }

    .highlight-title {
        font-weight: bold;
        font-size: 16px;
    }

.temp .value, .hum .badge {
        text-align: center;
		font-size: 23px;
		padding: 0.6rem;
        width: 100%;
        display: block;
        border-radius: .3rem;
        border: 0.03rem solid gray;
    }

    .temp.error .value, .hum.high .badge {
        background-color: #ff2e00;
        animation: bgColor_red 1s infinite alternate;
    }

    .temp.low .value, .hum.low .badge {
        background-color: #75f8f8;
        color: #000;
        animation: bgColor_blue 1s infinite alternate;
    }

    .temp.normal .value, .hum.normal .badge {
        background-color: #008000;
        color: white;
    }

    .hum.no-data .badge {
        background-color: #808080;
        color: #fff;
    }

    .hum.high .highlight-title {
        color: #ff2e00;
    }

    .hum.low .highlight-title {
        color: #75f8f8;
    }

    .hum.normal .highlight-title {
        color: #008000;
    }

    .hum.no-data .highlight-title {
        color: #808080;
    }

    .standard {
        font-weight: bold;
        color: black;
        font-size: 0.8rem;
    }

    @keyframes bgColor_red {
        0% {
            background: #ff2e00;
        }
        100% {
            background: #FFFFFF;
        }
    }

    @keyframes bgColor_blue {
        0% {
            background: #75f8f8;
        }
        100% {
            background: #FFFFFF;
        }
    }

    .cooling-title {
        background: linear-gradient(90deg, rgba(116, 83, 163, 1) 0%, rgba(121, 195, 236, 1) 99%);
        padding: 10px;
        color: #ffffff;
        border-radius: 4px;
        margin-top: -30px;
    }

    .loading-container {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 5rem;
    }
</style>

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <br>
            <h4 class="card-title cooling-title" style="">
                <?= __("cooling_control") ?> -
                <span style="font-size: 17px; color: white;">
                   <?= isset($school['name']) ? $school['name'] : 'School Name Not Available' ?>

                </span>
            </h4>

            <div class="w-100" id="results"></div>
        </div>
    </div>
</div>

<script>
    const loadingDiv = `<div class="loading-container"><div class="spinner-border text-warning m-1" role="status" id="red1"><span class="sr-only">Loading...</span> </div></div>`;
    const errorContent = `<div class="alert alert-danger w-100">Ooops! Error was found.</div>`;
    const resultsContainer = $('#results');
    const TEN_MINUTES = 600000;

    function fetchResults() {
        resultsContainer.html(loadingDiv);

        $.ajax({
            url: "<?= current_url() ?>",
            type: "POST",
            ajaxError: function () {
                resultsContainer.html(errorContent);
            },
            success: function (response) {
                resultsContainer.html(response);
            }
        });
    }

    $(document).ready(function () {
        setInterval(fetchResults, TEN_MINUTES);
        fetchResults();
    });
</script>