<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive mb-0" data-pattern="priority-columns">
                    <table class="table">
                        <thead>
                        <th>#</th>
                        <?php if (!isset($showQuestionsReport)) { ?>
                            <th>Detailed Report</th>
                        <?php } ?>
                        <?php if (isset($showQuestionsReport)) { ?>
                            <th>Questions</th>
                        <?php } ?>
                        <?php if (!isset($hideQuestionsCode)) { ?>
                            <th>Survey Code</th>
                        <?php } ?>
                        <th>Category Title</th>
                        <th>Set Title</th>
                        <th>From</th>
                        <th>To</th>
                        </thead>
                        <tbody>
                        <?php foreach ($surveys as $key => $survey) : ?>
                            <tr id="cat_<?= $key; ?>">
                                <td><?= $key + 1 ?></td>
                                <?php if (!isset($showQuestionsReport)) { ?>
                                    <td>
                                        <a href="<?= base_url("EN/DashboardSystem/" . $link . "/") . $survey['survey_id'] ?>">
                                            <button class="btn btn-info waves-effect waves-light w-100 text-center"><i
                                                        class="uil uil-file-alt mr-2 font-size-20"></i> Report
                                            </button>
                                        </a></td>
                                <?php } ?>
                                <?php if (isset($showQuestionsReport)) { ?>
                                    <td>
                                        <a href="<?= base_url("EN/DashboardSystem/results-by-question-chart/") . $survey['survey_id'] ?>">
                                            <button class="btn btn-info waves-effect waves-light w-100 text-center"><i
                                                        class="uil uil-file-alt mr-2 font-size-20"> </i> Report
                                            </button>
                                        </a></td>
                                <?php } ?>
                                <?php if (!isset($hideQuestionsCode)) { ?>
                                    <td><?= $survey['serv_code'] ?? "#" ?></td>
                                <?php } ?>
                                <td><?= $survey['set_name_en'] ?></td>
                                <td><?= $survey['Title_en'] ?></td>
                                <td><?= $survey['From_date'] ?></td>
                                <td><?= $survey['To_date'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
