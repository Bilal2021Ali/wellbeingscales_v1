<?php use Types\AttendanceRecord; ?>
<div class="main-content">
    <div class="page-content">
        <?php $this->load->view("Shared/Attendance/inc/counters") ?>
        <div class="modal fade result-modal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <i class="uil uil-times pointer" data-dismiss="modal" aria-label="Close"></i>
                    </div>
                    <div class="modal-body"></div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h3 class="card-title"><?= __("data-for") . " " . date("Y-m-d") ?></h3>
                <hr class="mb-4">
                <div class="row">
                    <?php /** @var array<AttendanceRecord> $results */ ?>
                    <?php foreach ($results as $item) { ?>
                        <?php $this->load->view("Shared/Attendance/inc/result-card", ['result' => $item]); ?>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const details = $(".result-modal");
    const loadingDiv = `<div class="d-flex justify-content-center loading-container"><div class="spinner-border text-warning m-1" role="status" id="red1"><span class="sr-only">Loading...</span> </div></div>`;

    function fetchResults(url) {
        details.find(".modal-body").html(loadingDiv);
        details.modal("show");

        $.ajax({
            type: "GET",
            url, // TODO : remove index.php
            success: function (data) {
                details.modal("show");
                details.find(".modal-body").html(data);
            }
        });
    }

    $(".name-ifo").click(function (e) {
        const id = $(this).data("id");
        fetchResults("<?= base_url($activeLanguage . "/schools/vehicle-drivers") ?>/" + id);
    });

    $(".label-info").click(function (e) {
        const id = $(this).data("id");
        fetchResults("<?= base_url($activeLanguage . "/schools/vehicle-data") ?>/" + id);
    });
</script>