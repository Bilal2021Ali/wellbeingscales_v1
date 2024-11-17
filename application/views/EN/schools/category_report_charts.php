<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="<?= base_url("assets/libs/apexcharts/apexcharts.min.js") ?>"></script>
</head>
<?php
$levels = array();
$accepted_foreach = array();
$simple_levels_names_arr = array();
foreach ($avalaible_types_of_classes as $cl_id => $class) {
    $levels[$class['name']] = 0;
    $simple_levels_names_arr[] = $class['name'];
    $accepted_foreach[$class['name']] = explode(";", $class['Classes']);
}


foreach ($students_completed_surveys as $key => $students) {
    foreach ($levels as $key => $level) {
        if (in_array($students['Student_class'], $accepted_foreach[$key])) {
            $levels[$key] = $levels[$key] + 1;
        }
    }
}

$lables_arr = array_map(function ($name) {
    return "'" . $name . "'";
}, $simple_levels_names_arr);
?>
<body>
    <div class="main-content">
        <div class="page-content">
            <div class="row">

                <div class="col-12">
                    <<br>
                    <h4 class="card-title" style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">CH 065 Total Received Surveys by Gender</h4>
                    <div class="card">
                        <div class="card-body">
                            <h3 class="text-center ">Total Received Surveys by Gender</h3>
                            <div id="genders_charts"></div>
                        </div>
                    </div>
                </div>
                <div class="col-12">	
                    <br>
                    <h4 class="card-title" style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">CH 067 Total Received Surveys by User Type</h4>
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-4">User Type Charts </h4>
                            <div id="radial_chart" class="apex-charts" dir="ltr"></div>
                        </div>
                    </div>
                </div>

                <?php
                foreach($surveys as $key => $survey){
                    $this->load->view('EN/schools/inc/answers_counter_chart_generater' ,[
                        'counter' => $key ,
                        'data'    => $survey
                    ]);
                } 
                ?>

            </div>
        </div>
    </div>
</body>
<script src="<?= base_url("assets/libs/chart.js/Chart.bundle.min.js") ?>"></script>
</html>
<script>
   const setupGendersChartOptions = (malesData, femalesData) => {
  const colors = ["#34c38f", "#5b73e8", "#f1b44c", "#50a5f1", "#ff6b6b", "#1dd1a1", "#feca57", "#5f27cd", "#222f3e", "#2e86de", "#f368e0", "#feca57"];
  
  const gendersChartOptions = {
    chart: {
      type: "bar",
      height: 160,
      stacked: true,
      stackType: "100%",
      toolbar: {
        show: false
      }
    },
    series: [{
        name: "Males",
        data: [malesData]
      },
      {
        name: "Females",
        data: [femalesData]
      }
    ],
    plotOptions: {
      bar: {
        horizontal: true
      }
    },
    dataLabels: {
      dropShadow: {
        enabled: true
      },
      formatter: (val) => {
        return val ? val.toFixed(1) + '%' : ''
      }
    },
    stroke: {
      width: 0
    },
    grid: {
      show: false,
      padding: {
        top: 0,
        bottom: 0,
        right: 0,
        left: 0
      }
    },
    xaxis: {
      categories: ["Total"],
      labels: {
        show: false
      },
      axisBorder: {
        show: false
      },
      axisTicks: {
        show: false
      }
    },
    fill: {
      opacity: 1,
      type: "gradient",
      gradient: {
        shade: "dark",
        type: "vertical",
        shadeIntensity: 0.35,
        gradientToColors: undefined,
        inverseColors: false,
        opacityFrom: 0.85,
        opacityTo: 0.85,
        stops: [90, 0, 100]
      }
    },
    legend: {
      position: "bottom",
      horizontalAlign: "center"
    }
  };
  
  return gendersChartOptions;
}

const renderGendersChart = () => {
  const dataForMales = <?= $surveys_for_males ?>;
  const dataForFemales = <?= $surveys_for_females ?>;
  
  const gendersChartOptions = setupGendersChartOptions(dataForMales, dataForFemales);
  
  const gendersChart = new ApexCharts(document.querySelector("#genders_charts"), gendersChartOptions);
  gendersChart.render();
}

renderGendersChart();


    var options = {
            chart: {
                height: 210,
                type: "bar"
            },
            toolbar: {
                show: true,
            },
            plotOptions: {
                bar: {
                    borderRadius: 10,
                    dataLabels: {
                        position: 'top', // top, center, bottom
                    },
                }
            },
            dataLabels: {
                enabled: false,
                formatter: function(val) {
                    return val ;
	
                } ,
                offsetY: -25,
                style: {
                    fontSize: '12px',
                    colors: ["#304758"]
                }
            },
                series: [{
                        name: 'Staff',
                        data: [<?= sizeof($Staffs) ?>]
                    },
                    {
                        name: 'Teachers',
                        data: [<?= sizeof($Teachers) ?>]
                    },
                    {
                        name: 'Students',
                        data: [<?= sizeof($Students) ?>]
                    },
                    {
                        name: 'Parents',
                        data: [<?= sizeof($Parents) ?>]
                    },
                ],
				
                 labels: ["Total"],
                colors: ["#5b73e8", "#34c38f", "#50a5f1", "#f1b44c"]
            };
            (chart = new ApexCharts(document.querySelector("#radial_chart"), options)).render();
</script>