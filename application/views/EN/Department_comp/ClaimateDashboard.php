<link rel="stylesheet" href="<?= base_url("assets/libs/@chenfengyuan/datepicker/datepicker.min.css") ?>">
<link href="<?= base_url("assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css") ?>" rel="stylesheet">
<style>
  .answer-td {
    text-align: center;
  }
</style>
<div class="main-content">
  <div class="page-content">
    <?php $this->load->view('EN/Department_comp/inc/climate_dashboard') ?>
    <div class="card">
      <div class="card-body">
        <label>Filter By Usertype:</label>
        <select class="form-control float-right usertypeFilter" style="width: auto;">
          <option value="">All</option>
          <?php foreach ($types as $key => $usertype) {   ?>
            <option value="<?= $usertype['Id'] ?>">
              <?= $usertype['UserType'] ?>
            </option>
          <?php } ?>
        </select>
        <div class="results">
          <?php $this->load->view('EN/Department_comp/inc/climate_dashboard', ["nofilter" => true, "prefix" => "usertype"]) ?>
        </div>
      </div>
    </div>
    <div class="card">
      <div class="card-body">
        <h3 class="card-title">Today's Answers:
          <form method="POST" class="marks-avg row">
            <div class="col-lg-6">
              <div class="input-daterange input-group mt-2" data-date-format="yyyy-mm-dd" data-date-autoclose="true" data-provide="datepicker">
                <input type="text" class="form-control" autocomplete="off" name="from" value="<?= $from ?>" placeholder="from" />
                <input type="text" class="form-control" autocomplete="off" name="to" value="<?= $to ?>" placeholder="to" />
              </div>
            </div>
            <div class="col-lg-6">
              <input autocomplete="off" type="text" value="<?= $this->input->post("name") ?? "" ?>" name="name" class="form-control mt-2 search-by-name" placeholder="search by name...">
            </div>
            <button class="btn btn-primary w-100 my-2" style="display: none;" type="submit">Rerender</button>
          </form>
        </h3>
        <div class="table-responsive">
          <table>
            <thead>
              <th>Img</th>
              <th>Name</th>
              <th>National ID</th>
              <?php foreach ($climate_survyes as $survey) { ?>
                <th><?= $survey['set_name_en']; ?></th>
              <?php } ?>
            </thead>
            <tbody>
              <?php foreach ($usersWhoAnsweredToday as $sn => $user) { ?>
                <tr>
                  <td><img class="avatar-md rounded-circle m-3" src="<?= base_url('uploads/co_avatars/') . (!empty($user['Avatar']) ? $user['Avatar'] : 'default_avatar.jpg') ?>" alt=""></td>
                  <td><?= $user['userName'] ?></td>
                  <td><?= $user['National_Id'] ?></td>
                  <?php foreach ($climate_survyes as $survey) { ?>
                    <?php
                    $value = $this->sv_reports->Answer($survey['survey_id'], $user['Id'], [$from, $to]);
                    $color = "#fff";
                    foreach ($scores as $key => $score) {
                      if ($value >= $score['accept_from'] && $value <= $score['accept_to']) {
                        $color = $score['color'];
                        $font = $score['font_color'];
                        break;
                      }
                    }
                    ?>
                    <td class="answer-td" style="background-color: <?= $color ?? "#000" ?>"><span style="color: <?= $font ?? "#000" ?>;">
                        <?= $value ?>
                      </span>
                    </td>
                  <?php } ?>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <?php /*?>
<div class="card">
    <div class="card-body">
        <h3 class="card-title">Overall Climate: </h3>
        <div class="col-lg-8 m-auto mb-8 text-center">
            <div class="GaugeChartContainer" id="avg_chart"></div>
        </div>
    </div>
</div>
    <?php */ ?>
  </div>
</div>
<script src="<?= base_url("assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js") ?>"></script>
<script src="<?= base_url("assets/libs/@chenfengyuan/datepicker/datepicker.min.js") ?>"></script>
<script>
  var colors = ["#fc2413", "#fdd000", "#63d566", "#07b301", "#ff6b6b", "#1dd1a1", "#feca57", "#5f27cd", "#222f3e", "#2e86de", "#f368e0", "#feca57"];
  $('.usertypeFilter').on('change', function() {
    $('.results').html('Please wait...');
    $.ajax({
      type: "POST",
      url: "<?= base_url('EN/Ajax/deptclimatedashboard') ?>",
      data: {
        usertype: this.value
      },
      success: function(response) {
        $('.results').html(response);
      }
    });
  });
  // avg_chart
  var selector = '#avg_chart';
  var element = document.querySelector(selector);
  var chartWidth = ($(selector).parent().parent().parent().parent().parent().width() / 3);
  var options = {
    arcOverEffect: false,
    hasNeedle: true,
    needleColor: "black",
    needleStartValue: 0,
    arcColors: colors,
    arcDelimiters: [<?= implode(',', $climateAverageChart['counts']) ?>],
  }
  GaugeChart.gaugeChart(element, chartWidth, options).updateNeedle(<?= $climateAverageChart['value']['value'] ?>);
  var choicesbar = '<div class="row mt-4">';
  <?php foreach ($climateAverageChart['labels'] as $choice) { ?>
    choicesbar += '<div class="col text-center"><?= $choice  ?></div>';
  <?php } ?>
  choicesbar += '</div>';
  $(selector).parent().append(choicesbar);
  var choicesbar = '<div class="row">';
  <?php foreach ($climateAverageChart['labels'] as $i => $choice) { ?>
    choicesbar += '<div class="col choice" style="background-color : ' + colors[<?= $i ?>] + '"></div>';
  <?php } ?>
  choicesbar += '</div>';
  $(selector).parent().append(choicesbar);

  $('.marks-avg input , .search-by-name').change(() => {
    $('.marks-avg button[type="submit"]').slideDown();
  });
</script>