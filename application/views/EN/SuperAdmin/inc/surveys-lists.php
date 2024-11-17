<!-- Nav tabs -->
<ul class="nav nav-tabs nav-justified" role="tablist">
    <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#navtabs2-home" role="tab">
            <span class="d-block d-sm-none"><i class="uil uil-notes"></i></span> <span
                class="d-none d-sm-block">CHOICES SURVEYS</span> </a></li>
    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#navtabs2-profile" role="tab">
            <span class="d-block d-sm-none"><i class="uil uil-comment-alt-message"></i></span> <span
                class="d-none d-sm-block">FILLABLE SURVEYS</span> </a></li>
</ul>
<!-- Tab panes -->
<div class="tab-content p-3 text-muted">
    <div class="tab-pane active" id="navtabs2-home" role="tabpanel">
        <div class="table-responsive mb-0" data-pattern="priority-columns">
            <table class="table dt-responsive nowrap">
                <thead>
                <th>No</th>
                <th>Survey Code</th>
                <th>Date</th>
                <th>Category</th>
                <th>Survey Title</th>
                <th>Targeted Accounts</th>
                <th>Scale</th>
                <th>Completed</th>
                <th>Questions</th>
                <th>Choices</th>
                <th>Status</th>
                <th>Actions</th>
                </thead>
                <tbody>
                <?php
                foreach ($surveys as $key => $survey) {
                    $choices_count = $this->db->query("SELECT Id FROM `sv_set_template_answers_choices`
                                            WHERE `group_id` = '" . $survey['group_id'] . "' ")->num_rows();
                    ?>
                    <tr id="serv_<?= $survey['survey_id']; ?>">
                        <td class="count"><?= $key + 1; ?></td>
                        <td><?= $survey['serv_code']; ?></td>
                        <td><?= $survey['created_at'] ?></td>
                        <td><?= $survey['Cat_en']; ?>
                            <br>
                            <?= $survey['Cat_ar'] ?></td>
                        <td><?= $survey['set_name_en']; ?>
                            <br>
                            <?= $survey['set_name_ar'] ?></td>
                        <td><?= $survey['targeted_type'] == "M" ? "Ministries" : "Companies" ?></td>
                        <td><?= $survey['choices_title']; ?></td>
                        <td><?= $survey['completed'] ?></td>
                        <td><?= $survey['questions_count']; ?></td>
                        <td><?= $choices_count ?></td>
                        <td><label class="switch">
                                <input type="checkbox" name="ischecked"
                                       onchange="update_status(<?php echo $survey['survey_id'] ?>)"
                                       serv_Id="<?php echo $survey['survey_id']; ?>" <?php echo $survey['status'] == 1 ? 'checked' : ""; ?>>
                                <span class="slider round"></span> </label></td>
                        <td class="text-center"><a data-toggle="tooltip" data-placement="top" title=""
                                                   href="<?= base_url('EN/Dashboard/questions_manage/') . $survey['survey_id'] . "/choices"; ?>"
                                                   data-original-title="Preview Survey"> <i
                                    class="uil uil-notes questions font-size-20"
                                    data-survey-type="Not_fillable" group=""></i> </a> <span
                                data-toggle="tooltip" data-placement="top" title=""
                                onclick="get_avalaible_questions(<?php echo $survey['survey_id']; ?>)"
                                data-original-title="Add new questions to this survey"> <i
                                    class="uil uil-plus-circle <?= $survey['isUsed'] !== '0' ? "disabled-ic" : "ADD" ?>" <?= $survey['isUsed'] !== '0' ? '' : 'data-survey-type="Not_fillable" data-toggle="modal" data-target="#exampleModal"' ?> group=""></i> </span>
                            <i class="uil uil-trash  <?= $survey['isUsed'] !== '0' ? "disabled-ic" : "delete" ?>"
                               class="btn btn-primary" data-toggle="tooltip" data-placement="top"
                               title="" data-original-title="Delete Forever"
                               for="<?= $survey['survey_id']; ?>" key="<?php echo $key + 1 ?>"
                               data-type="notfillable"></i> <a data-toggle="tooltip"
                                                               data-placement="top" title=""
                                                               data-original-title="Questions Groups"
                                                               href="<?php echo base_url("EN/Dashboard/questions_grouping/" . $survey['survey_id']); ?>"><i
                                    class="uil uil-sitemap font-size-20"></i></a> <a
                                data-toggle="tooltip" data-placement="top" title=""
                                data-original-title="Conners Calculations"
                                href="<?= base_url("EN/Dashboard/standards/" . $survey['survey_id']); ?>">
                                <i class="uil uil-scenery nav__icon font-size-20"></i>
                            </a>
                            <a data-toggle="tooltip" data-placement="top" title=""
                               data-original-title="Add Account"> <i
                                    class="uil uil-file-lock-alt font-size-20 targetedaccounts text-success ml-1 btn"
                                    data-key="<?= $survey['survey_id'] ?>"></i> </a>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="tab-pane" id="navtabs2-profile" role="tabpanel">
        <div class="table-responsive mb-0" data-pattern="priority-columns">
            <table class="table dt-responsive nowrap">
                <thead>
                <th>No</th>
                <th>Survey Code</th>
                <th>Date</th>
                <th>Category</th>
                <th>Survey Title</th>
                <th>Completed</th>
                <th>Questions</th>
                <th>Status</th>
                <th>Actions</th>
                </thead>
                <tbody>
                <?php foreach ($fillablesurveys as $key => $survey) { ?>
                    <tr id="serv_<?= $survey['survey_id']; ?>">
                        <td class="count"><?= $key + 1; ?></td>
                        <td><?= $survey['serv_code']; ?></td>
                        <td><?= $survey['created_at'] ?></td>
                        <td><?= $survey['Cat_en']; ?>
                            <br>
                            <?= $survey['Cat_ar'] ?></td>
                        <td><?= $survey['set_name_en']; ?>
                            <br>
                            <?= $survey['set_name_ar'] ?></td>
                        <td><?= $survey['completed'] ?></td>
                        <td><?= $survey['questions_count']; ?></td>
                        <td><label class="switch">
                                <input type="checkbox" name="ischecked"
                                       onchange="update_status(<?= $survey['survey_id'] ?>,'fillable')"
                                       serv_Id="<?= $survey['survey_id']; ?>" <?= $survey['status'] == 1 ? 'checked' : ""; ?>>
                                <span class="slider round"></span> </label></td>
                        <td class="text-center"><a data-toggle="tooltip" data-placement="top" title=""
                                                   href="<?= base_url('EN/Dashboard/questions_manage/') . $survey['survey_id'] . "/fillable"; ?>"
                                                   data-original-title="Show Survey Questions"> <i
                                    class="uil uil-notes questions" data-survey-type="Not_fillable"
                                    group=""></i> </a> <span data-toggle="tooltip"
                                                             data-placement="top" title=""
                                                             onclick="get_avalaible_questions(<?= $survey['survey_id']; ?>,'fillable')"
                                                             data-original-title="add new questions to this survey"> <i
                                    class="uil uil-plus-circle <?= $survey['isUsed'] !== '0' ? "disabled-ic" : "ADD" ?>" <?= $survey['isUsed'] !== '0' ? '' : 'data-survey-type="Not_fillable" data-toggle="modal" data-target="#exampleModal"' ?> group=""></i> </span>
                            <i class="uil uil-trash <?= $survey['isUsed'] !== '0' ? "disabled-ic" : "delete" ?>"
                               class="btn btn-primary" data-toggle="tooltip" data-placement="top"
                               title="" data-original-title="Delete Forever"
                               for="<?= $survey['survey_id']; ?>" key="<?= $key + 1 ?>"
                               data-type="fillable"></i> <a data-toggle="tooltip" data-placement="top"
                                                            title=""
                                                            data-original-title="questions grouping"
                                                            href="<?= base_url("EN/Dashboard/questions_grouping/" . $survey['survey_id'] . "/fillable"); ?>"><i
                                    class="uil uil-sitemap"></i></a></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
