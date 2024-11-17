<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-body">
        <div class="table-responsive mb-0" data-pattern="priority-columns">
          <table class="table">
            <thead>
              <th>#</th>
              <?php if ($isqreport) { ?>
              <th>Detail Report</th>
              <?php } ?>
              <th>عنوان الإستبيان</th>
              <th>عنوان المجموعة</th>
              <th>من تاريخ</th>
              <th>إلى تاريخ</th>
            </thead>
            <tbody>
              <?php foreach ($surveys as $key => $survey) : ?>
              <tr id="cat_<?= $key; ?>">
                <td><?= $key + 1 ?></td>
                <?php if ($isqreport) { ?>
                <td><a href="<?= base_url("AR/schools/results_by_question_chart/") . $survey['survey_id'] ?>">
                  <button class="btn btn-info waves-effect waves-light w-100 text-center"><i class="uil uil-file-alt mr-2 font-size-20"></i> تقرير</button>
                  </a></td>
                <?php } ?>
                <td><?= $survey['set_name_ar'] ?></td>
                <td><?= $survey['Title_ar'] ?></td>
                <th class="text-center"><?= $survey['From_date'] ?>
                  </td>
                <th class="text-center"><?= $survey['To_date'] ?>
                  </td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
