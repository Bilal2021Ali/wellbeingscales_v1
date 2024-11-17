<?php
$quarantine = $this->Ministry_Functions->UsersInAction("Quarantine");
$home = $this->Ministry_Functions->UsersInAction("Home");

$QuarantineSum = sizeof($quarantine['staff'] ?? []) + sizeof($quarantine['teachers'] ?? []) + sizeof($quarantine['students'] ?? []);
$HomeSum = sizeof($home['staff'] ?? []) + sizeof($home['teachers'] ?? []) + sizeof($home['students'] ?? []);
?>
<div class="col-12">
    <div class="row">
        <div class="col-lg-6 col-sm-12">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title">Counters Home Quarantine And Quarantine </h3>
                    <div id="ResultsbyAction-bars"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-sm-12">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title">Counters Home Quarantine And Quarantine </h3>
                    <div id="ResultsbyAction-pie"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var options = {
        chart: {
            height: 350,
            type: 'bar',
            toolbar: {
                show: false,
            }
        },
        plotOptions: {
            bar: {
                horizontal: true,
            }
        },
        dataLabels: {
            enabled: false
        },
        series: [
            {
                name: "Quarantine",
                data: [<?= sizeof($quarantine['staff'] ?? []) ?>, <?= sizeof($quarantine['staff'] ?? []) ?> , <?= sizeof($quarantine['students'] ?? []) ?>]
            },
            {
                name: "Home Quarantine",
                data: [<?= sizeof($home['staff'] ?? []) ?>, <?= sizeof($home['staff'] ?? []) ?> , <?= sizeof($home['students'] ?? []) ?>]
            },
        ],
        colors: ['#269ffb' , '#35c28e'],
        grid: {
            borderColor: '#f1f1f1',
        },
        xaxis: {
            categories: [' Staff', ' Teachers' , 'Students'],
        }
    }

    var chart = new ApexCharts(document.querySelector("#ResultsbyAction-bars"), options);
    chart.render();

    var options = {
        chart: {
            height: 350,
            type: 'pie',
        },
        data: [<?= $QuarantineSum ?>, <?= $HomeSum ?>],
        labels: ['Quarantine', 'Home Quarantine'],
        colors: ["#34c38f", "#5b73e8", "#f1b44c", "#50a5f1", "#f46a6a"],
        legend: {
            show: true,
            position: 'bottom',
            horizontalAlign: 'center',
            verticalAlign: 'middle',
            floating: false,
            fontSize: '14px',
            offsetX: 0
        },
        responsive: [{
            breakpoint: 600,
            options: {
                chart: {
                    height: 240
                },
                legend: {
                    show: false
                },
            }
        }]

    }

    var chart = new ApexCharts(
        document.querySelector("#ResultsbyAction-pie"),
        options
    );

    chart.render();
</script>