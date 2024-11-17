<?php
/**
 * @var callable $incidentsAction
 */
?>
<style>
    .icon-lg {
        text-align: center;
        font-size: 2rem;
    }

    .main-content .card-body {
        position: relative;
    }

    .main-content a .card-body p {
        color: #929292;
    }

    .main-content p {
        margin-bottom: 0;
    }

    .arrow-icon {
        position: absolute;
        top: 11%;
        right: 10px;
        font-size: 1.5rem;
        color: #000;
    }

    <?php if ($activeLanguage === "AR") { ?>
    .arrow-icon {
        right: auto;
        left: 10px;
        transform: rotate(180deg);
    }

    <?php } ?>
</style>
<div class="main-content">
    <div class="page-content">

        <a class="card" href="<?= $incidentsAction("reports/summary") ?>">
            <div class="card-body">
                <div class="row">
                    <div class="col-2 icon-lg">
                        <i class="uil uil-file" style="color: green"></i>
                    </div>
                    <div class="col-10">
                        <h4 class="card-title"><?= __("summary") ?></h4>
                        <p><?= __("gain_complete_visibility") ?></p>
                        <i class="uil uil-arrow-right arrow-icon"></i>
                    </div>
                </div>
            </div>
        </a>

        <a class="card" href="<?= $incidentsAction("reports/students") ?>">
            <div class="card-body">
                <div class="row">
                    <div class="col-2 icon-lg">
                        <i class="uil uil-users-alt" style="color: deepskyblue"></i>
                    </div>
                    <div class="col-10">
                        <h4 class="card-title"><?= __("student_report") ?></h4>
                        <p><?= __("list_all_student_then_select") ?></p>
                        <i class="uil uil-arrow-right arrow-icon"></i>
                    </div>
                </div>
            </div>
        </a>

        <a class="card" href="<?= $incidentsAction("reports/completed") ?>">
            <div class="card-body">
                <div class="row">
                    <div class="col-2 icon-lg">
                        <i class="uil uil-check-circle" style="color: lawngreen"></i>
                    </div>
                    <div class="col-10">
                        <h4 class="card-title"><?= __("completed") ?></h4>
                        <i class="uil uil-arrow-right arrow-icon"></i>
                    </div>
                </div>
            </div>
        </a>

    </div>
</div>