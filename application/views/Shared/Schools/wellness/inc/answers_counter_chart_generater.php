<?php

$account = "`sv_school_published_surveys`.`By_school` = '" . $sessiondata['admin_id'] . "'";

if (isset($isMinistry) && $isMinistry) {
    $account = "`l1_school`.`Added_By` = '" . $sessiondata['admin_id'] . "'";
}

$surveyId = $data['survey_id'];
$used_choices = $this->db->query(" SELECT
`sv_set_template_answers_choices`.`title_" . strtolower($activeLanguage) . "` AS `choices_name` ,
`sv_set_template_answers_choices`.`Id` AS `Id`
FROM `sv_school_published_surveys`
JOIN `sv_st1_surveys` ON  `sv_st1_surveys`.`Id` = `sv_school_published_surveys`.`Serv_id`
JOIN `sv_st_surveys` ON `sv_st_surveys`.`Id` = `sv_st1_surveys`.`Survey_id`
JOIN `sv_set_template_answers` ON `sv_set_template_answers`.`Id` = `sv_st_surveys`.`answer_group_en`
JOIN `sv_set_template_answers_choices` ON `sv_set_template_answers_choices`.`group_id` = `sv_set_template_answers`.`Id`
JOIN `l1_school` ON `l1_school`.`Id` = `sv_school_published_surveys`.`By_school`
WHERE `sv_school_published_surveys`.`Id` = '" . $data['survey_id'] . "' AND $account ")->result_array();
$users_types = array(1, 2, 3, 4);

?>
<div class="col-xl-12">
    <br><h4 class="card-title"
            style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">
        CH 07<?= $counter + 1 ?> <?= __("answers") ?> </h4>
    <div class="card">
        <div class="card-body">
            <h4 class="card-title"> -> <?= $data['surveysTitles'] ?>
                (<?= $data['From_date'] . ' To : ' . $data['To_date']; ?>)</h4>
            <p><?= $data['Message']; ?></p>
            <div id="column_chart_<?= $counter; ?>" class="apex-charts" dir="ltr"></div>
        </div>
    </div>
</div>
<script>
    var colors = ["#34c38f", "#5b73e8", "#f1b44c", "#50a5f1", "#ff6b6b", "#1dd1a1", "#feca57", "#5f27cd", "#222f3e", "#2e86de", "#f368e0", "#feca57"];

    options = {
        chart: {
            height: 350,
            type: "bar",
            toolbar: {
                show: true,
            }
        },
        plotOptions: {
            bar: {
                horizontal: 0,
                columnWidth: "45%",
                endingShape: "rounded"
            }
        },
        dataLabels: {
            enabled: true,
            style: {
                colors: ['#fff', "#fff"]
            }
        },
        stroke: {
            show: !1,
            width: 2,
            colors: ["transparent"]
        },
        series: [
            <?php
            foreach($used_choices as $choice){
            $data = array();
            foreach ($users_types as $type) {
                $use_count = $this->db->query(" SELECT `sv_st1_answers_values`.`Id` FROM `sv_st1_answers_values` 
                        JOIN `sv_st1_answers` ON `sv_st1_answers_values`.`answers_data_id` = `sv_st1_answers`.`Id` AND `sv_st1_answers`.`user_type` = '" . $type . "'
                        JOIN `sv_school_published_surveys` ON `sv_st1_answers`.`serv_id` = `sv_school_published_surveys`.`Id`
                        JOIN `l1_school` ON `l1_school`.`Id` = `sv_school_published_surveys`.`By_school`
                        WHERE `choice_id` = '" . $choice['Id'] . "' AND  `sv_school_published_surveys`.`Id` = '" . $surveyId . "' 
                        AND $account GROUP BY `sv_st1_answers`.`Id` ")->num_rows();
                $data[] = $use_count;
            }
            ?>
            {
                name: "<?= $choice['choices_name'] ?>",
                data: [<?= implode(",", $data) ?>]
            },
            <?php } ?>
        ],
        colors: colors,
        xaxis: {
            categories: ["<?= __("staff") ?>", "<?= __("students") ?>", "<?= __("teachers") ?>", "<?= __("parents") ?>"]
        },
        yaxis: {
            title: {
                text: "<?= __("choose_times") ?>"
            }
        },
        grid: {
            borderColor: "#f1f1f1"
        },
        fill: {
            opacity: 1
        },
        tooltip: {
            y: {
                formatter: function (e) {
                    return e + " <?= __("times") ?>";
                }
            }
        }
    };
    (chart = new ApexCharts(document.querySelector("#column_chart_<?= $counter; ?>"), options)).render();
</script>