<style>
    .badge-m-1 {
        margin: 2px;
    }
</style>
<table class="table dt-responsive nowrap">
    <thead>
    <th>No</th>
    <th>Date</th>
    <th>Category</th>
    <th>Climate Title</th>
    <th>From</th>
    <th>To</th>
    <th>Question</th>
    <th>Targeted Genders</th>
    <th style="width: 60px;">Targeted Levels</th>
    <th>Targeted Users Types</th>
    <?php if (!isset($hideStatus)) { ?>
        <th>Status</th>
    <?php } ?>
    <?php if (isset($hasAction)) { ?>
        <th>Actions</th>
    <?php } ?>
    </thead>
    <tbody>
    <?php foreach ($published_surveys as $key => $oursurvey) { ?>
        <tr id="serv_<?= $oursurvey['survey_id'] ?>">
            <td><?= $key + 1 ?></td>
            <td><?= $oursurvey['created_at'] ?></td>
            <td><?= $oursurvey['Cat_en']; ?><br><?= $oursurvey['Cat_ar'] ?></td>
            <td><?= $oursurvey['set_name_en']; ?><br><?= $oursurvey['set_name_ar'] ?></td>
            <td><?= $oursurvey['from_date']; ?></td>
            <td><?= $oursurvey['to_date']; ?></td>
            <td><?= $oursurvey['question'] ?></td>
            <td>
                <?php foreach (explode(',', $oursurvey['genderslist']) as $gender) { ?>
                    <span
                            class="badge rounded-pill bg-primary text-white p-2"><?= str_replace(['1', '2'], ['Males', 'Females'], $gender); ?></span>
                <?php } ?>
            </td>
            <td>
                <div style="max-width: 150px;display: flex;flex-direction: row;flex-wrap: wrap;">
                    <?php foreach ($this->labels_formatter->format($oursurvey['levelslist']) as $level) { ?>
                        <span class="badge rounded-pill bg-success text-white p-2 badge-m-1"><?= $level ?></span>
                    <?php } ?>
                    <?php if ($this->labels_formatter->hasMore($oursurvey['levelslist'])) { ?>
                        <span data-value="<?= $oursurvey['levelslist'] ?>"
                              class="badge rounded-pill bg-success text-white p-2 badge-m-1 show-more-labels">Show More...</span>
                    <?php } ?>
                </div>
            </td>
            <td>
                <div style="max-width: 150px;display: flex;flex-direction: row;flex-wrap: wrap;">
                    <?php foreach ($this->labels_formatter->format($oursurvey['typeslist']) as $type) { ?>
                        <span
                                class="badge rounded-pill bg-danger text-white p-2 badge-m-1"><?= str_replace(['1', '2', '3', '4'], ['Staff', 'Students', 'Teachers', 'Parents'], $type); ?></span>
                    <?php } ?>
                    <?php if ($this->labels_formatter->hasMore($oursurvey['typeslist'])) { ?>
                        <span data-value="<?= translate_types_codes($oursurvey['typeslist']) ?>"
                              class="badge rounded-pill bg-danger text-white p-2 badge-m-1 show-more-labels">Show More...</span>
                    <?php } ?>
                </div>
            </td>
            <?php if (!isset($hideStatus)) { ?>
                <td>
                    <label
                            class="switch <?= (intval($oursurvey['ministry_survey_status']) == 1 && intval($oursurvey['main_survey_status']) == 1) ? '' : 'disabled' ?>">
                        <input type="checkbox"
                               name="ischecked" <?= (intval($oursurvey['ministry_survey_status']) == 1 && intval($oursurvey['main_survey_status']) == 1) ? '' : 'disabled="disabled"' ?>
                               data-serv-key="<?= $oursurvey['survey_id']; ?>" <?= $oursurvey['status'] == 1 ? 'checked' : ""; ?>>
                        <span class="slider round"></span>
                    </label>
                </td>
            <?php } ?>
            <?php if (isset($hasAction)) { ?>
                <td>
                    <a data-toggle="tooltip" data-placement="top" title="" data-original-title="Report"
                       href="<?= $oursurvey['action'] ?>">
                        <i class="uil uil-eye font-size-20 btn btn-rounded waves-effect btn-success"></i>
                    </a>
                </td>
            <?php } ?>
        </tr>
    <?php } ?>
    </tbody>
</table>
<?php $this->load->view("Shared/inc/show-more-labels") ?>
<script>
    $(".table").DataTable();
</script>
