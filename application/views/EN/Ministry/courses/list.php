<style>
    .category-card .card-body .counter-element {
        padding: 10px;
        font-size: 15px;
        text-align: center;
        border-radius: 5px;
        margin: 10px 0px;
        font-weight: 700;
        color: #404040;
        width: 100%;
        display: block;
    }

    .category-card .card-body .counter-element:nth-child(1), .category-card .card-body .counter-element:nth-child(4) {
        background: #fbe5d6;
    }

    .category-card .card-body .counter-element:nth-child(2) {
        background: #ffc000;
    }

    .category-card .card-body .counter-element:nth-child(3) {
        background: #5b9bd5;
    }

    .category-card .card-body .counter-element:nth-child(5) {
        background: #f6ac8d;
    }

    .category-card .card-body .counter-element:nth-child(6) {
        color: #fff;
        background: #70ad47;
    }

    .category-card .card-body .counter-element:nth-child(7) {
        color: #fff;
        background: #ed7d31;
    }

    .category-card .card-body .counter-element:nth-child(8) {
        color: #fff;
        background: #4472c4;
    }

    .add-card {
        text-align: center;
        min-height: 310px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 30px;
    }
</style>
<?php
function formatNumber($number)
{
    return number_format((float)$number, 1, '.', '');
}

?>
<div class="main-content">
    <div class="page-content">
        <div class="row">
            <?php foreach ($courses as $course) { ?>
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="card category-card">
                        <div class="card-body">
                            <div class="counter-element"><?= $course['category_title'] ?></div>
                            <div class="counter-element"><?= $course['courseTitle'] ?></div>
                            <div class="counter-element"><?= $course['topicsCount'] ?> Topic</div>
                            <div class="counter-element"><?= $course['resourcesCount'] ?> Resources</div>
                            <div class="counter-element"><?= $course['publishedCount'] ?> Schools Had Published This
                                Course
                            </div>
                            <div class="counter-element">
                                <?= $course['reviews'] ?? 0 ?> Reviews (Average
                                Rate <?= formatNumber($course['averageRate'] ?? 0) ?>)
                            </div>
                            <a href="<?= base_url("EN/DashboardSystem/course/" . $course['courseId']) ?>"
                               class="counter-element">Setting</a>
                            <a href="<?= base_url("EN/DashboardSystem/publish-course/" . $course['courseId']) ?>"
                               class="counter-element">Publish</a>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>