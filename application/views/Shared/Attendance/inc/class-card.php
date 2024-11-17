<?php
/** @var AttendanceRecord $item */

use Types\AttendanceRecord;

$baseUrl = isset($detailsBuilder) ? $detailsBuilder($key) : "";
?>
<div data-toggle="tooltip" data-placement="top" title="" data-original-title=""
     class=" col-xl-3 col-sm-6 classChoice checked" data-class-id="2">
    <div class="card text-center">
        <div class="card-body">
            <div class="avatar-lg mx-auto mb-4">
                <div class="avatar-title rounded-circle text-primary">
                    <i class="uil uil-check display-4 m-0 text-white"></i>
                </div>
            </div>
            <h5 class="font-size-16 mb-1 text-dark">
                <?php if (isset($actionBuilder)) { ?>
                    <a href="<?= $actionBuilder($item->id) ?>">
                        <?= $item->name ?>
                    </a>
                <?php } else { ?>
                    <?= $item->name ?>
                <?php } ?>
            </h5>
            <div class="d-flex mt-2">
                <a href="<?= empty($baseUrl) ? "javascript:void(0)" : ($baseUrl . "/" . $attendanceStatuses::PRESENT) ?>"
                   class="btn w-100 btn-success mr-1"><?= __("present") ?> : <?= $item->present ?>
                </a>
                <a href="<?= empty($baseUrl) ? "javascript:void(0)" : ($baseUrl . "/" . $attendanceStatuses::ABSENT) ?>"
                   class="btn w-100 btn-danger"><?= __("absent") ?> : <?= $item->absent ?>
                </a>
            </div>
        </div>
    </div>
</div>