<?php
/**
 * @var AttendanceStatuses $attendanceStatuses
 * @var AttendanceRecord $result
 * @var bool $isDetailedList
 */

use Enums\AttendanceStatuses;
use Types\AttendanceRecord;

?>
<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
    <div class="card text-center">
        <div class="card-body">
            <div class="mb-4">
                <?php if (isset($hideAvatar) && $hideAvatar) { ?>
                    <div class="avatar-lg mx-auto mb-4">
                        <div class="avatar-title rounded-circle text-primary">
                            <i class="uil uil-user text-white display-4 m-0"></i>
                        </div>
                    </div>
                <?php } else { ?>
                    <img src="<?= $result->avatar ?>" alt="" class="avatar-lg rounded-circle img-thumbnail">
                <?php } ?>
            </div>
            <h5 class="font-size-16 mb-1">
                <?php if (!$isDetailedList) { ?>
                    <i class="uil uil-user name-ifo float-left text-muted pointer" data-id="<?= $result->id ?>"></i>
                <?php } ?>
                <?= $result->name ?>
            </h5>
            <p>
                <?php if (!$isDetailedList) { ?>
                    <i class="uil uil-info-circle label-info text-muted pointer" data-id="<?= $result->id ?>"></i>
                <?php } ?>
                <?= $result->label ?>
            </p>
            <hr>
            <?php if ($isDetailedList) { ?>
                <?php if ($activeStatus === $attendanceStatuses::PRESENT) { ?>
                    <span type="button" data-device="<?= $result->device ?>" data-user-id="<?= $result->id ?>"
                          class="btn btn-<?= $result->presentStatus() ?> btn-rounded waves-effect waves-light">
                        P
                    </span>
                <?php } else { ?>
                    <span type="button" data-device="<?= $result->device ?>" data-user-id="<?= $result->id ?>"
                          class="btn btn-<?= $result->absentStatus() ?> btn-rounded waves-effect waves-light">
                        A
                    </span>
                <?php } ?>
            <?php } else { ?>
                <a href="<?= $actionBuilder($result->id) . "/" . $attendanceStatuses::PRESENT ?>"
                   title="<?= __("present") ?>"
                   class="btn btn-success btn-rounded waves-effect waves-light"><?= $result->present ?></a>
                <a href="<?= $actionBuilder($result->id) . "/" . $attendanceStatuses::ABSENT ?>"
                   title="<?= __("absent") ?>"
                   class="btn btn-outline-danger btn-rounded waves-effect waves-light"><?= $result->absent ?></a>
            <?php } ?>
        </div>
    </div>
</div>