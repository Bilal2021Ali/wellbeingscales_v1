<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-body">
        <table class="table">
          <thead>
          <th class="text-center">#</th>
            <th class="text-center">تقرير المجاميع</th>
            <?php if ($isqreport) { ?>
            <th>التقرير التفصيلي</th>
            <?php } ?>
            <th class="text-center">رمز الإستبيان</th>
            <th class="text-center">عنوان الإستبيان</th>
            <th class="text-center">عنوان المجموعة</th>
            <th class="text-center">من تاريخ</th>
            <th class="text-center">إلى تاريخ</th>
            </thead>
          <tbody>
            <?php foreach ($surveys as $key => $survey) : ?>
            <tr id="cat_<?= $key; ?>">
              <td class="text-center"><?= $key + 1 ?></td>
              <td><a href="<?= base_url("AR/schools/" . $link . "/") . $survey['survey_id'] ?>">
                <button class="btn btn-info waves-effect waves-light w-100 text-center"><i class="uil uil-file-alt mr-2 font-size-20"></i>عرض التقرير</button>
                </a></td>
              <?php if ($isqreport) { ?>
              <td><a href="<?= base_url("AR/schools/results_by_question_chart/") . $survey['survey_id'] ?>">
                <button class="btn btn-info waves-effect waves-light w-100 text-center"><i class="uil uil-file-alt mr-2 font-size-20"></i>عرض التقرير</button>
                </a></td>
              <?php } ?>
              <th class="text-center"><?= $survey['serv_code'] ?>
                </td>
              <td><?= $survey['set_name_ar'] ?></td>
              <td><?= $survey['Title_ar'] ?></td>
              <th class="text-center"><?= $survey['From_date'] ?>
                </td>
              <th class="text-center"><?= $survey['To_date'] ?>
                </td>
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
