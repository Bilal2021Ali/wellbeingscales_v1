<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
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
        <div class="rightbar-title d-flex align-items-center px-3 py-4">
            <a href="javascript:void(0);" class="right-bar-toggle ms-auto mr-5">
                <i class="mdi mdi-close noti-icon"></i>
            </a>
            <h5 class="m-0 me-2">Surveys</h5>
        </div>
        <div class="p-4 result">
        </div>
    </div> <!-- end slimscroll-menu-->
</div>
<!-- /Right-bar -->
<div class="rightbar-overlay"></div>
<body>
    <div class="main-content">
        <div class="page-content">
			<div class="row"><br>
                <div class="col-12"><br>
				<h4 class="card-title" style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">CH 035: Categories Reports</h4>
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive mb-0" data-pattern="priority-columns">
                                <table class="table">
                                    <thead>
                                        <th>#</th>
										<th class="text-center">Report</th>
                                        <th>Category Title</th>
										<th>Survey Counters</th>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($categorys as $key => $category) : ?>
                                            <tr id="cat_<?= $key; ?>">
                                                <td><?= $key + 1 ?></td>
												<td>
				                                      <a href="<?= base_url('EN/DashboardSystem/categorys_reports/' . $category['Id']) ?>">
                                                        <button class="btn btn-info waves-effect waves-light w-100 text-center"><i class="uil uil-file-alt mr-2 font-size-20"></i>Report</button>
                                                    </a>
                                                </td>
												<td><?= $category['Cat_en']; ?></td>
                                                <td><?= $category['counter_of_using']; ?></td>
												</tr>
                                        <?php endforeach; // end foreach starts in line 23  
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
				
				
            </div>
           
            
            <div class="row"><br>
                <div class="col-12"><br>
				<h4 class="card-title" style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">CH 036: Schools Reports</h4>
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive mb-0" data-pattern="priority-columns">
                                <table class="table">
                                    <thead>
                                        <th>#</th>
										<th class="text-center">Report</th>
                                        <th>School Name</th>
                                        <th>Published Surveys</th>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($schools as $key => $school) : ?>
                                            <tr id="cat_<?= $key; ?>">
                                                <td><?= $key + 1 ?></td>
												<td>
                                                    <a href="<?= base_url('EN/DashboardSystem/school-reports/' . $school['Id']) ?>">
                                                        <button class="btn btn-info waves-effect waves-light w-100 text-center"><i class="uil uil-file-alt mr-2 font-size-20"></i>Report</button>
                                                    </a>
                                                </td>
                                                <td><?= $school['school_name']; ?></td>
                                                <td><?= $school['surveysCount']; ?></td>
                                            
                                        <?php endforeach; ?>
										</tr>
                                </table>
                            </div>
                        </div>
                    </div>
                
                </div>
            </div>
            <br>

<!--            <h4 class="card-title" style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">CH 037: Questions Reports </h4>-->
            <!--            --><?php //$this->load->view("EN/Ministry/inc/question_categories", [
            //                "link" => "questions-reports",
            //            ]); ?>

            
            <h4 class="card-title" style="background: linear-gradient(90deg, rgba(116,83,163,1) 0%, rgba(121,195,236,1) 99%);padding: 10px;color: #ffffff;border-radius: 4px;margin-top: -30px;">CH 038: Answers Reports</h4>
            <?php $this->load->view("EN/Ministry/inc/question_categories", [
                // "showQuestionsReport" => true,
                "link" => "results-by-question-chart",
            ]); ?>
        </div>
    </div>
</body>
<script src="<?= base_url(); ?>assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?= base_url(); ?>assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
<script>
    $('table').DataTable();
    $(".table").on('click', ".showsurveys", function(e) {
        $('.result').html('');
        if (!$('body').hasClass('right-bar-enabled')) {
            $('body').addClass('right-bar-enabled');
        }
        var id = $(this).attr('catid');
        var json_data = $.parseJSON($.ajax({
            url: '<?= base_url() ?>EN/DashboardSystem/return_surveys_of_category',
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
        } else {
            $('body').removeClass('right-bar-enabled');
            Swal.fire({
                title: "Sorry.",
                text: ' We have an error. Please refresh the page and try again.',
                icon: 'error',
                confirmButtonColor: '#5b73e8'
            })
        }
    });
    function append_html(data) {
        var code = data.serv_code;
        var set = data.set_name_en;
        var choices_en_title = data.choices_en_title;
        var choices_ar_title = data.choices_ar_title;
        var publish_count = data.surveys_count_published;
        return ('<div class="card text-center"><div class="card-body"><div class="mb-4"> <div class="avatar-title bg-soft-primary rounded-circle text-primary count_in_list"> <strong class="display-4 m-0 text-primary">' + publish_count + '</strong> </div> </div><h5 class="font-size-16 mb-1"><a href="#" class="text-dark">' + code + '</a></h5> <p class="text-muted mb-2">' + set + '<br>' + choices_en_title + '</p> </div></div>');
    }
</script>
</html>