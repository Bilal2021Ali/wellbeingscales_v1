<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive mb-0" data-pattern="priority-columns">
                    <table class="table">
                        <thead>
                        <th>#</th>
                        <?php if (!isset($showQuestionsReport)) { ?>
                            <th>التقارير</th>
                        <?php } ?>
                        <?php if (isset($showQuestionsReport)) { ?>
                            <th>الأسئلة</th>
                        <?php } ?>
                        <?php if (!isset($hideQuestionsCode)) { ?>
                            <th>رمز الإستبيان</th>
                        <?php } ?>
                        <th>المجموعة</th>
                        <th>التصنيف</th>
                        <th>من</th>
                        <th>إلى</th>
                        </thead>
                        <tbody>
                        <?php foreach ($surveys as $key => $survey) : ?>
                            <tr id="cat_<?= $key; ?>">
                                <td><?= $key + 1 ?></td>
                                <?php if (!isset($showQuestionsReport)) { ?>
                                    <td>
                                        <a href="<?= base_url("AR/DashboardSystem/" . $link . "/") . $survey['survey_id'] ?>">
                                            <button class="btn btn-info waves-effect waves-light w-100 text-center"><i
                                                        class="uil uil-file-alt mr-2 font-size-20"></i>التقرير
                                            </button>
                                        </a></td>
                                <?php } ?>
                                <?php if (isset($showQuestionsReport)) { ?>
                                    <td>
                                        <a href="<?= base_url("AR/DashboardSystem/results-by-question-chart/") . $survey['survey_id'] ?>">
                                            <button class="btn btn-info waves-effect waves-light w-100 text-center"><i
                                                        class="uil uil-file-alt mr-2 font-size-20"></i>التقرير
                                            </button>
                                        </a></td>
                                <?php } ?>
                                <?php if (!isset($hideQuestionsCode)) { ?>
                                    <td><?= $survey['serv_code'] ?? "#" ?></td>
                                <?php } ?>
                                <td><?= $survey['set_name_ar'] ?></td>
                                <td><?= $survey['Title_ar'] ?></td>
                                <td><?= $survey['From_date'] ?></td>
                                <td><?= $survey['To_date'] ?></td>
                            </tr>
                        <?php
                        endforeach; // end foreach starts in line 23
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
