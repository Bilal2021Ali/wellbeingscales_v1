<div class="table-responsive mb-0" data-pattern="priority-columns" data-simplebar="init">
    <table class="table dt-responsive nowrap unfillable_publishedSuveys table_pub">
        <thead>
        <th>#</th>
        <th>Code</th>
        <th>Date Published</th>
        <th>Category</th>
        <th>Title</th>
        <th>User Target Type</th>
        <th>Completed</th>
        <th>No. of Questions</th>
        <th>No. of Choices</th>
        <th>Status</th>
        </thead>
        <tbody>
        <?php foreach ($published_surveys_unfillable as $key => $published_survey) {  ?>
            <?php
            $choices_count = $this->db->query("SELECT Id FROM `sv_set_template_answers_choices`
                                                    WHERE `group_id` = '" . $published_survey['group_id'] . "' ")->num_rows();
            $answers_count = $this->db->query("SELECT Id FROM `sv_st_questions`
                                                    WHERE `survey_id` = '" . $published_survey['main_survey_id'] . "' ")->num_rows();
            $search = array("1", "2", "3", "4");
            $replace = array("staff", "students", "teachers", "parents");
            $Targeted_types = str_replace($search, $replace, array_column($this->db->query("SELECT Type_code FROM sv_school_published_surveys_types WHERE Survey_id = '" . $published_survey['survey_id'] . "' ")->result_array(), "Type_code"));
            ?>
            <tr>
                <td><?= $key + 1 ?></td>
                <td><?= $published_survey['serv_code'] ?></td>
                <td><?= $published_survey['publish_date'] ?></td>
                <td><?= $published_survey['Title_en'] ?></td>
                <td><?= $published_survey['set_name_en'] ?></td>
                <td><?= implode(', ', $Targeted_types) ?></td>
                <td><?= $published_survey['completed'] ?></td>
                <td class="text-center"><?= $answers_count ?>
                    <span data-toggle="tooltip" data-placement="top" data-original-title="Show the survey questions" class="ml-2">
                                                                <i class="uil uil-notes questions" data-toggle="modal" data-target="#myModal" group="<?= $published_survey['main_survey_id']; ?>"></i>
                                                            </span>
                </td>
                <td><?= $choices_count ?></td>
                <td>
                    <input type="checkbox" id="pub_sur_fi_<?= $key ?>" onchange="publishedsurveyStatusChanger(<?= $published_survey['survey_id'] ?>)" data-survey-key="<?= $published_survey['survey_id'] ?>" switch="success" <?= $published_survey['status'] == 1 ? "checked" : "" ?> />
                    <label for="pub_sur_fi_<?= $key ?>" data-on-label="on" data-off-label="off"></label>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>
<script>
    $(".unfillable_publishedSuveys").DataTable();
</script>