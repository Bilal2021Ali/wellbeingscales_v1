<?php if ($language === "AR") { ?>
    <style>
        .verti-timeline .event-list .event-date {
            left: auto !important;
        }

        .event-list h5 {
            padding-right: 1rem !important;
        }
    </style>
<?php } ?>
<div class="main-content">
    <div class="page-content">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <ul class="verti-timeline list-unstyled">
                            <?php foreach ($publishedSurveys as $survey) { ?>
                                <li class="event-list <?= $survey['to_date'] < $today ? "expired" : "" ?>">
                                    <a href="<?= base_url($language . "/schools/new-climate-report/" . $survey['survey_id']) ?>"
                                       class="event-date text-primar">
                                        <?= date("d M", strtotime($survey['publishedAt'])) ?>
                                    </a>
                                    <h5><?= $survey['set_name_' . strtolower($language)] ?></h5>
                                    <p class="text-muted"><?= $survey['question'] ?></p>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <ul class="verti-timeline list-unstyled">
                            <?php foreach ($categories as $key => $survey) { ?>
                                <li class="event-list">
                                    <a href="<?= base_url($language . "/schools/new-climate-report/" . $survey['id'] . "?by-category") ?>"
                                       class="event-date text-primar">
                                        <?= $key + 1 ?>
                                    </a>
                                    <h5><?= $survey['category'] ?></h5>
                                    <p class="text-muted"><?= $this->lang->line("total") ?> : <?= $survey['surveys'] ?></p>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>