<!-- by_types -->
<style>
.avatar-lg {
    height: 4rem !important;
    width: 4rem !important;
}
</style>
<?php if($use_count !== 0){ ?>
<div class="container-fluid mt-5">
    <h3> + <?= $name ?> :</h3>
    <div class="row">
        <div class="col-lg-6">
            <div class="card notstatic">
                <div class="card-body pb-5">
                    <h3 class="card-title text-center"> أنواع المستخدمين الذين اختاروا هذا </h3>
                    <div id="types_chart_<?= $__count ?? "" ?>" class="apex-charts" dir="ltr"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="row">
                <div class="col-lg-6">
                    <div class="card notstatic text-center">
                        <div class="card-body">
                            <div class="clearfix"></div>
                            <div class="avatar-lg mx-auto mb-4">
                                <div class="avatar-title bg-soft-primary rounded-circle text-primary">
                                    <i class="mdi mdi-account-circle display-4 m-0 text-primary"></i>
                                </div>
                            </div>
                            <h5 class="font-size-16 mb-1"><a class="text-dark"><?=$by_types[0]['Parents'] ?></a></h5>
                            <p class="text-muted mb-2">أولياء أمور</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card notstatic text-center">
                        <div class="card-body">
                            <div class="clearfix"></div>
                            <div class="avatar-lg mx-auto mb-4">
                                <div class="avatar-title bg-soft-primary rounded-circle text-primary">
                                    <i class="mdi mdi-account-circle display-4 m-0 text-primary"></i>
                                </div>
                            </div>
                            <h5 class="font-size-16 mb-1"><a class="text-dark"><?=$by_types[0]['Staffs'] ?></a></h5>
                            <p class="text-muted mb-2">موظفين</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card notstatic text-center">
                        <div class="card-body">
                            <div class="clearfix"></div>
                            <div class="avatar-lg mx-auto mb-4">
                                <div class="avatar-title bg-soft-primary rounded-circle text-primary">
                                    <i class="mdi mdi-account-circle display-4 m-0 text-primary"></i>
                                </div>
                            </div>
                            <h5 class="font-size-16 mb-1"><a class="text-dark"><?=$by_types[0]['Students'] ?></a></h5>
                            <p class="text-muted mb-2">طلبة</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card notstatic text-center">
                        <div class="card-body">
                            <div class="clearfix"></div>
                            <div class="avatar-lg mx-auto mb-4">
                                <div class="avatar-title bg-soft-primary rounded-circle text-primary">
                                    <i class="mdi mdi-account-circle display-4 m-0 text-primary"></i>
                                </div>
                            </div>
                            <h5 class="font-size-16 mb-1"><a class="text-dark"><?=$by_types[0]['Teachers'] ?></a></h5>
                            <p class="text-muted mb-2">معلمين</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <div class="card notstatic">
                <div class="card-body pb-5">
                    <h3 class="card-title text-center">أجناس المستخدمين الذين اختاروا هذا</h3>
                    <div id="genders_chart_<?= $__count ?? "" ?>" class="apex-charts" dir="ltr"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card notstatic text-center">
                <div class="card-body pb-5">
                    <div class="avatar-xl mx-auto mb-4">
                        <div class="avatar-title bg-soft-primary rounded-circle text-primary">
                            <span class="display-4 m-0 text-primary">%</span>
                        </div>
                    </div>             
                    <h1 class="mt-5"><?= $perc; ?>%</h1>
                    <h4>النسبة المئوية لاستخدام هذا الاختيار للإجابة على هذا السؤال من جميع الأنواع والجنس </h4>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo base_url();?>assets/js/app.js"></script>   

<script src="<?php echo base_url("assets/libs/apexcharts/apexcharts.min.js"); ?>"></script>
<script>
    var perc_types_options = {
        chart: {
            height: 320,
            type: "donut"
        },
        series: [<?= $by_types[0]['Parents'] ?>, <?= $by_types[0]['Teachers'] ?>, <?= $by_types[0]['Students'] ?>, <?= $by_types[0]['Staffs'] ?>],
        labels: ["أولياء الأمور", "المعلمين", "الطلاب", "الموظفين"],
        colors: ["#f1b44c", "#50a5f1", "#f46a6a", "#74788d"],
        legend: {
            show: true,
            position: "bottom",
            horizontalAlign: "center",
            verticalAlign: "middle",
            floating: !1,
            fontSize: "14px",
            offsetX: 0
        },
        responsive: [{
            breakpoint: 600,
            options: {
                chart: {
                    height: 240
                },
                legend: {
                    show: true
                }
            }
        }]
    };
    (chart = new ApexCharts(document.querySelector("#types_chart_<?= $__count ?? "" ?>"), perc_types_options)).render();
    var perc_genders_options = {
        chart: {
            height: 280,
            type: "donut"
        },
        series: [<?= $males ?>, <?= $females ?>],
        labels: ["ذكور", "إناث"],
        colors: ["#f1b44c", "#50a5f1"],
        legend: {
            show: true,
            position: "bottom",
            horizontalAlign: "center",
            verticalAlign: "middle",
            floating: !1,
            fontSize: "14px",
            offsetX: 0
        },
        responsive: [{
            breakpoint: 600,
            options: {
                chart: {
                    height: 240
                },
                legend: {
                    show: true
                }
            }
        }]
    };
    (chart = new ApexCharts(document.querySelector("#genders_chart_<?= $__count ?? "" ?>"), perc_genders_options)).render();
</script>
<?php }else{ ?>
        <div class="col-12 mt-5">
            <div class="card notstatic">
                <div class="card-body text-center">
                    <h3 class="card-title">لاتوجد بيانات</h3>
                    <p>ماذا يعني ذلك: لا يمكننا العثور على أي نتائج حول هذا الاختيار  "<?php echo $name ?>"
                    وسبب ذلك في كثير من الأحيان أنه لا أحد من المستخدمين الذين اجتازوا هذا الاستطلاع يختار هذه الإجابة</p>
                </div>
            </div>
        </div>
<?php } ?>