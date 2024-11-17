<?php use Types\AttendanceRecord; ?>
<div class="main-content">
    <div class="page-content">
        <?php $this->load->view("Shared/Attendance/inc/counters") ?>
        <div class="card">
            <div class="card-body">
                <h3 class="card-title"><?= __("data-for") . " " . date("Y-m-d") ?></h3>
                <hr class="mb-4">
                <div class="row">
                    <?php /** @var array<AttendanceRecord> $results */ ?>
                    <?php foreach ($results as $item) { ?>
                        <?php $this->load->view("Shared/Attendance/inc/class-card", ["item" => $item])?>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>