<style>
    .content-list {
        height: 500px;
        overflow: auto;
    }
</style>
<div class="main-content">
    <div class="page-content">
        <div class="row">
            <?php foreach ($surveys as $survey) { ?>
                <div class="col-lg-4">
                    <div class="card">
                        <img class="card-img-top img-fluid" src="<?= $survey['climate_image'] ?>" alt="Card image cap">
                        <div class="card-body content-list">
                            <div class="w-100 text-center mb-4">
                                <a class="btn btn-primary"
                                   href="<?= base_url(strtoupper($language) . "/schools/climate-results-charts/" . $survey['survey_id']) ?>"><?= $this->lang->line('report') ?>
                                    <?= $this->lang->line('report') ?>
                                </a>
                            </div>

                            <div class="w-100 text-center">
                                <h3><?= date("Y-m-d", strtotime($survey['publishedAt'])) ?></h3>
                                <p><?= $this->lang->line('publish-date') ?></p>
                            </div>
                            <hr>
                            <div class="w-100 d-flex justify-content-between mb-3">
                                <div class="text-center">
                                    <h3><?= $survey['answers_counter'] ?></h3>
                                    <p><?= $this->lang->line('users-answered') ?></p>
                                </div>
                                <div class="text-center">
                                    <h3><?= $survey['to_date'] ?></h3>
                                    <p><?= $this->lang->line('expired-on') ?></p>
                                </div>
                            </div>

                            <p>
                                <b><?= $this->lang->line('category-title') ?>:</b>
                                <?= $survey["Cat_" . strtolower($language)] ?>
                            </p>
                            <p>
                                <b><?= $this->lang->line('question') ?>:</b>
                                <?= $survey['question'] ?>
                            </p>
                            <p>
                                <b><?= $this->lang->line('targeted-genders') ?>:</b>
                                <?= $survey['genders'] ?>
                            </p>
                            <p>
                                <b><?= $this->lang->line('targeted-users-types') ?>:</b>
                                <?= $survey['usersTypes'] ?>
                            </p>
                            <p>
                                <b><?= $this->lang->line('targeted-levels') ?>:</b>
                                <?= $survey['levelslist'] ?>
                            </p>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>