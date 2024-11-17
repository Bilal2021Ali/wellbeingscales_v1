<style>
    .showsurveys {
        font-size: 20px;
        cursor: pointer;
        color: #3f51b5;
        transition: 0.3s all;
    }

    .showsurveys:hover {
        transition: 0.3s all;
        font-size: 25px;
    }

    .right-bar-enabled .right-bar {
        width: 70%;
        min-width: 500px;
    }

    .right-bar {
        -webkit-transition: all 500ms cubic-bezier(0.9, 0.01, 0.17, 1.04) !important;
        transition: all 500ms cubic-bezier(0.9, 0.01, 0.17, 1.04) !important;
    }

    .uil-plus-circle.btn {
        font-size: 20px;
    }

    .result .avatar-title {
        width: 120px;
        height: 120px;
        margin: auto;
    }

    .image_container img {
        margin: auto;
        width: 100%;
        max-width: 800px;
    }
</style>
<!-- Right Sidebar -->
<div class="right-bar">
    <div data-simplebar class="h-100">
        <div class="rightbar-title d-flex align-items-center px-3 py-4"><a href="javascript:void(0);"
                                                                           class="right-bar-toggle ms-auto mr-5"><i
                        class="mdi mdi-close noti-icon"></i></a>
            <h5 class="m-0 me-2">Surveys</h5>
        </div>
        <div class="p-4 result"></div>
    </div>
    <!-- end slimscroll-menu-->
</div>
<!-- /Right-bar -->
<div class="rightbar-overlay"></div>
<div class="main-content">
    <div class="page-content">
        <div class="row">
            <div class="col-12">
                <div class="card"><br>
                    <div class="row image_container"><img
                                src="<?= base_url(); ?>assets/images/banners/SCHOOL102.png" alt="schools"></div>
                    <br>
                </div>
            </div>
        </div>

        <h4 class="card-title"
            style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;">
            <?= __("received_category_report") ?>
        </h4>
        <div class="row">
            <?php foreach ($categorys as $key => $category) : ?>
                <div class="col-md-6 col-xl-3">
                    <div class="card">
                        <div class="card-body">
                            <a href="<?= base_url('EN/schools/categorys-reports/' . $category['Id']) ?>"
                               class="btn btn-info waves-effect waves-light w-100 text-center"><i
                                        class="uil uil-file-alt mr-2 font-size-20"></i><?= $category['Cat_' . strtolower($activeLanguage)]; ?>
                                <?= __("report") ?>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

<!--        <h4 class="card-title"-->
<!--            style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;">-->
<!--            --><?php //= __("answers_survey_report") ?>
<!--        </h4>-->
<!--        --><?php
//        $this->load->view("Shared/Schools/wellness/inc/question_categories", [
//            "link" => "questions_reports",
//            "isqreport" => false,
//        ]);
//        ?>

        <h4 class="card-title"
            style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;">
            <?= __("questions_survey_report") ?>
        </h4>
        <?php
        $this->load->view("Shared/Schools/wellness/inc/question_categories", [
            "link" => "counter_questions",
            "isqreport" => true,
        ]);
        ?>
    </div>
</div>
<script src="<?= base_url(); ?>assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
<script>
    $('table').DataTable();
    $(".table").on('click', ".showsurveys", function (e) {
        $('.result').html('');
        if (!$('body').hasClass('right-bar-enabled')) {
            $('body').addClass('right-bar-enabled');
        }
        var id = $(this).attr('catid');
        var json_data = $.parseJSON($.ajax({
            url: '<?= base_url() ?>EN/schools/return_surveys_of_category',
            dataType: "json",
            async: false,
            type: 'POST',
            data: {
                cat_id: id,
            }
        }).responseText);
        if (json_data.status == "ok") {
            $('.right-bar h5.m-0.me-2').html(json_data.cat)
            var returneddata = json_data.data;
            for (let index = 0; index < returneddata.length; index++) {
                const element = returneddata[index];
                $('.result').append(append_html(json_data.data[index]));
            }
        }
    });

    function append_html(data) {
        var code = data.serv_code;
        var set = data.set_name_en;
        var choices_en_title = data.choices_en_title;
        var choices_ar_title = data.choices_ar_title;
        var publish_count = data.answers_counter;
        return ('<div class="card text-center"><div class="card-body"><div class="mb-4"> <div class="avatar-title bg-soft-primary rounded-circle text-primary count_in_list"> <strong class="display-4 m-0 text-primary">' + publish_count + '</strong> </div> </div><h5 class="font-size-16 mb-1"><a href="#" class="text-dark">' + code + '</a></h5> <p class="text-muted mb-2">' + set + '<br>' + choices_en_title + '<br>' + choices_ar_title + '</p> </div></div>');
    }
</script>
</html>