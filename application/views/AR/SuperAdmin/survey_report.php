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

</style>
<!-- Right Sidebar -->
<div class="right-bar">
    <div data-simplebar class="h-100">
        <div class="rightbar-title d-flex align-items-center px-3 py-4">
            <a href="javascript:void(0);" class="right-bar-toggle ms-auto mr-5">
                <i class="mdi mdi-close noti-icon"></i>
            </a>
            <h5 class="m-0 me-2">surveys</h5>
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
				<h4 class="card-title" style="background: #7D0552; padding: 10px;color: #ffffff;border-radius: 4px;">SU 015: Survey Category Management</h4>
		<h4 class="card-title" style="background: #307D7E; padding: 10px;color: #ffffff;border-radius: 4px;">
		0001: List of Surveys according to its Category<br>
				</h4>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <table class="table">
                                <thead>
                                    <th class="text-center">#</th>
                                    <th class="text-center">Code</th>
                                    <th>Category en</th>
                                    <th class="text-center">Survey Counter</th>
                                    <th class="text-center" class="text-center">Actions</th>
                                </thead>
                                <tbody>
                                    <?php foreach ($categorys as $key => $category) : ?>
                                        <tr id="cat_<?= $key; ?>">
                                            <td class="text-center"><?= $key + 1 ?></td>
                                            <td class="text-center"><?= $category['Code']; ?></td>
                                            <td><?= $category['Cat_en']; ?></td>
                                            <td class="text-center"><?= $category['counter_of_using']; ?></td>
                                            <td class="text-center">
                                                <i data-toggle="tooltip" data-placement="top" title="" data-original-title="<?= $category['counter_of_using'] == 0 ? "no surveys found !!" : "Surveys Used in this Category" ?>" catid="<?= $category['Id']; ?>" class="uil uil-plus-circle  btn <?= $category['counter_of_using'] == 0 ? "" : "showsurveys right-bar-toggle" ?> waves-effect <?= $category['counter_of_using'] == 0 ? "disabled" : "" ?> "></i>
                                            </td>
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
    </div>
</body>

<script src="<?php echo base_url(); ?>assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?php echo base_url(); ?>assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
<script>
    $('table').DataTable();
    $(".table").on('click', ".showsurveys", function(e) {
        $('.result').html('');
        if(!$('body').hasClass('right-bar-enabled')){
            $('body').addClass('right-bar-enabled');
        }
        var id = $(this).attr('catid');
        var json_data = $.parseJSON($.ajax({
        url:  '<?php echo base_url() ?>EN/Dashboard/return_surveys_of_category',
        dataType: "json", 
        async: false ,
		type: 'POST',
		data : {
            cat_id : id,
		}
        }).responseText);
        if(json_data.status == "ok"){
            $('.right-bar h5.m-0.me-2').html(json_data.cat)
            var returneddata = json_data.data;
            for (let index = 0; index < returneddata.length; index++) {
                const element = returneddata[index];
                $('.result').append(append_html(json_data.data[index]));
            }
        }        
    });

    function append_html(data){
        var code = data.serv_code;
        var set = data.set_name_en;
        var choices_en_title = data.choices_en_title;
        var choices_ar_title = data.choices_ar_title;
        var publish_count = data.counter_of_publish ?? 0;
        return('<div class="card text-center"><div class="card-body"><div class="mb-4"> <div class="avatar-title bg-soft-primary rounded-circle text-primary count_in_list"> <strong class="display-4 m-0 text-primary">'+ publish_count +'</strong> </div> </div><h5 class="font-size-16 mb-1"><a href="#" class="text-dark">'+ code +'</a></h5> <p class="text-muted mb-2">'+ set +'<br>' + choices_en_title +'<br>' + choices_ar_title + '</p> </div></div>');
    }

</script>

</html>