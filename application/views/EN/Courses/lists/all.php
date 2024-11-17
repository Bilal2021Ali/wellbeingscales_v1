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

    .add-card {
        text-align: center;
        min-height: 310px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 30px;
    }
</style>
<div class="main-content">
    <div class="page-content">
        <div class="row">
            <?php foreach ($categories as $key => $category) { ?>
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="card category-card">
                        <div class="card-body">
                            <div class="counter-element"><?= $key + 1 ?></div>
                            <div class="counter-element"><?= $category['category_title'] ?></div>
                            <a href="<?= base_url("EN/Courses/courses-list/" . $category['category_id']) ?>"
                               class="counter-element"><?= $category['coursesCount'] ?> Courses</a>
                            <div class="counter-element"><?= $category['topicsCount'] ?> Topic</div>
                            <div class="counter-element"><?= $category['resourcesCount'] ?> Resources</div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>