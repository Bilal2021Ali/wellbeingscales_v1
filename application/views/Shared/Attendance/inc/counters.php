<style>
    .top-cards .card {
        margin-right: 10px;
        background-size: cover !important;
        color: #fff;
        border: 0;
        padding: 10px 0;
    }

    .top-cards .card:first-of-type {
        margin-left: 5px;
    }

    .top-cards .card:last-of-type {
        margin-right: 0;
    }

</style>
<div class="row top-cards">
    <div class="col-lg-4 col-md-6 col-sm-12">
        <div class="card" style="background: url(<?= base_url("assets/images/attendees/04.png"); ?>);">
            <div class="card-body row">
                <div class="col-6 text-right">
                    <img src="<?= base_url("assets/images/attendees/Students.png"); ?>" class="img-responsive w-100"
                         alt="" srcset="">
                </div>
                <div class="col-6 text-left">
                    <?= __("present") ?>:
                    <span id="presentCounter"><?= $present ?></span>/<?= $total; ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-6 col-sm-12">
        <div class="card" style="background: url(<?= base_url("assets/images/attendees/05.png"); ?>);">
            <div class="card-body row">
                <div class="col-6 text-right">
                    <img src="<?= base_url("assets/images/attendees/Students.png"); ?>" class="img-responsive w-100"
                         alt="" srcset="">
                </div>
                <div class="col-6 text-left">
                    <?= __("absent") ?>:
                    <span id="absentCounter"><?= $absent ?></span>/<?= $total; ?>
                    <?= __("late") ?>:
                    --/<?= $total; ?>
                </div>
            </div>
        </div>
    </div>
</div>