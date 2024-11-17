<?php
/**
 * @var string $activeLanguage
 */
?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive mb-0" data-pattern="priority-columns">
                    <table class="table">
                        <thead>
                        <th>#</th>
                        <?php if ($isqreport) { ?>
                            <th><?= __("detail_report") ?></th>
                        <?php } ?>
                        <th><?= __("survey_title") ?></th>
                        <th><?= __("category_title") ?></th>
                        <th><?= __("from") ?></th>
                        <th><?= __("to") ?></th>
                        </thead>
                        <tbody>
                        <?php foreach ($surveys as $key => $survey) : ?>
                            <tr id="cat_<?= $key; ?>">
                                <td><?= $key + 1 ?></td>
                                <?php if ($isqreport) { ?>
                                    <td>
                                        <a href="<?= base_url($activeLanguage . "/schools/results_by_question_chart/") . $survey['survey_id'] ?>">
                                            <button class="btn btn-info waves-effect waves-light w-100 text-center"><i
                                                        class="uil uil-file-alt mr-2 font-size-20"></i> <?= __("report") ?>
                                            </button>
                                        </a></td>
                                <?php } ?>
                                <td><?= $survey['set_name_' . strtolower($activeLanguage)] ?></td>
                                <td><?= $survey['Title_' . strtolower($activeLanguage)] ?></td>
                                <td class="text-center"><?= $survey['From_date'] ?></td>
                                <td class="text-center"><?= $survey['To_date'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
