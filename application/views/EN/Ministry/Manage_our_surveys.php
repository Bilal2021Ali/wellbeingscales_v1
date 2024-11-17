<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="<?php echo base_url(); ?>assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/libs/toastr/build/toastr.min.css">
    <link href="<?php echo base_url() ?>assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />

</head>
<body>
<style>

 /* The switch - the box around the slider */
.switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
}

/* Hide default HTML checkbox */
.switch input {
  opacity: 0;
  width: 0;
  height: 0;
}

/* The slider */
.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #CB0002;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #00bd06;
}

input:focus + .slider {
  box-shadow: 0 0 1px #00bd06;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}      

.floating_action_btn {
    position: fixed !important;
    bottom: 70px;
    right: 10px;
    border: 0px;
    width: 50px;
    height: 50px;
    background: #fff;
    border-radius: 100%;
    z-index: 1000;
    -webkit-box-shadow: 0 2px 4px rgba(15, 34, 58, 0.12);
    box-shadow: 0 2px 4px rgba(15, 34, 58, 0.12);
}
	
.odd {
    background: #ffeaf1 !important;
}	
	
.arabic , .arabic * {
	font-family: 'Almarai', sans-serif;
}

	
.delete {
	font-size: 23px;
	color: #fd0000;
	cursor: pointer;
}	
.delete_question {
	font-size: 23px;
	color: #fd0000;
	cursor: pointer;
	float: right;
	margin-bottom: 20px;
}	
	
.questions {
	font-size: 23px;
	color: #3c40c6;
	cursor: pointer;
}	

    
.use_ser {
    font-size: 23px;
    margin-left: 10px;
}

.hidden_inp {
    background-color: transparent;
    border: 0px;
    font-size: 16px;
    padding-top: 0px;
    margin-top: -5px;
}

</style>
<div class="main-content">
  <div class="page-content">
    <div class="card">
          <div class="card-body"> 
              <div class="table-responsive mb-0" data-pattern="priority-columns" data-simplebar="init">
                <table class="table dt-responsive nowrap">
                  <thead>
                    <th>#</th>
                    <th>code</th>
                    <th>Category</th> 
                    <th>Title</th>
                    <th>From</th>
                    <th>To</th>
                    <th>scale of ch</th>
                    <th>Completed</th>
                    <th>questions</th>
                    <th>Choices</th>
                    <th>status</th>
                    <th>Action</th>
                  </thead>
                  <tbody>
                    <?php  foreach($surveys as $key=>$survey){ ?>
                    <?php
                    $choices_count = $this->db->query( "SELECT Id FROM `sv_set_template_answers_choices`
                    WHERE `group_id` = '" . $survey[ 'group_id' ] . "' " )->num_rows();
                    $answers_count = $this->db->query( "SELECT Id FROM `sv_st_questions`
                    WHERE `survey_id` = '" . $survey[ 'main_survey_id' ] . "' " )->num_rows();
                    ?>
                    <tr id="serv_<?php  echo $survey['survey_id'];  ?>">
                      <td class="count"><?php  echo $key+1;  ?></td>
                      <td><?php  echo $survey['serv_code'];  ?></td>
                      <td><?php  echo $survey['Title_en'];  ?></td>
                      <td><?php  echo $survey['set_name_en'];  ?> </td>
                      <td><?php  echo $survey['From_date']; ?></td>
                      <td>
                        <input for_serv="<?php  echo $survey['survey_id'];  ?>" style="width: 122px;" type="text" class="form-control hidden_inp end_date" data-provide="datepicker" data-date-format="yyyy-mm-dd" value="<?php echo $survey['To_date']; ?>">
                      </td>
                      <td> <?php  echo $survey['choices_en_title'];  ?></td>
                      <td>0</td>
                      <td><?php  echo $answers_count;  ?></td>
                      <td><?php  echo $choices_count  ?></td>
                      <td>
                        <label class="switch"> 	
                          <input  type="checkbox" name="ischecked" serv_Id="<?php  echo $survey['survey_id'];  ?>"
                              <?php  echo $survey['status'] == 1 ? 'checked' : "";  ?>>
                          <span class="slider round"></span> 
                        </label>
                      </td> 
                      <td class="text-center">
                      <span  data-toggle="tooltip" data-placement="top" data-original-title="Show the survey questions">
                      <i class="uil uil-notes questions"  data-toggle="modal" data-target="#myModal" group="<?php echo $survey['main_survey_id']; ?>"></i> 
                      </span>
                      </td>
                    </tr>
                    <?php  }  ?>
                  </tbody>
                </table>
              </div>      
          </div>      
      </div> 
      <div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0" id="myModalLabel"> Questions in the Survey  </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card" style="border: 0px;box-shadow: 0px 0px 0px;">
                    <div class="card-body">
                        <div class="showquestions text-center mb-5" style="display: none;">
                            Loading...
                        </div>
                        <div class="question_list"></div>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>	  
  </div>
  </div>  
</div>  
<script src="<?php echo base_url(); ?>assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo base_url() ?>assets/libs/toastr/build/toastr.min.js"></script>
<script src="<?php echo base_url() ?>assets/libs/datatables.net-autoFill/js/dataTables.autoFill.min.js"></script>
<script src="<?php echo base_url() ?>assets/libs/datatables.net-autoFill-bs4/js/autoFill.bootstrap4.min.js"></script>
<script src="<?php echo base_url() ?>assets/libs/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
<script src="<?php echo base_url() ?>assets/libs/bootstrap-editable/js/index.js"></script>
<script src="<?php echo base_url(); ?>assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script> 
<script src="<?php echo base_url(); ?>assets/libs/parsleyjs/parsley.min.js"></script>
<script src="<?php echo base_url(); ?>assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script> 
<script src="<?php echo base_url(); ?>assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?php echo base_url(); ?>assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
<script src="<?php echo base_url(); ?>assets/libs/jszip/jszip.min.js"></script>
<script src="<?php echo base_url(); ?>assets/libs/pdfmake/build/pdfmake.min.js"></script>
<script src="<?php echo base_url(); ?>assets/libs/pdfmake/build/vfs_fonts.js"></script>
<script src="<?php echo base_url(); ?>assets/libs/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="<?php echo base_url(); ?>assets/libs/datatables.net-buttons/js/buttons.print.min.js"></script>
<script src="<?php echo base_url(); ?>assets/libs/datatables.net-buttons/js/buttons.colVis.min.js"></script>

<script>
//$('.table').DataTable();
var btns = $('.table').DataTable({
    lengthChange: false,
    buttons: ['copy', 'excel', 'pdf', 'colvis'],
  });
  btns.buttons().container().appendTo('#DataTables_Table_0_wrapper .col-md-6:eq(0)');

$('.questions').each(function(){
	$(this).click(function(){
		var groupid = $(this).attr('group');
		$('.question_list').html("");
		$('.showquestions').fadeIn();
		getquestions(groupid);
	});
});	

$('.end_date').each(function() {
  $(this).change(function() {
    const new_date = $(this).val();
    const serv_id = $(this).attr('for_serv');
    $.ajax({
     type: 'POST',
     url: '<?php echo base_url(); ?>EN/DashboardSystem/change_serv_status',
     data: {
      new_date : new_date,
      serv_id  : serv_id,
	    type     : 'update_date'
     },
     success: function (data) {
		 if(data === "ok"){
			toastr.options = {
			  "closeButton": false,
			  "debug": false,
			  "newestOnTop": false,
			  "progressBar": false,
			  "positionClass": "toast-top-right",
			  "preventDuplicates": false,
			  "onclick": null,
			  "showDuration": 300,
			  "hideDuration": 300,
			  "timeOut": 5000,
			  "extendedTimeOut": 1000,
			  "showEasing": "swing",
			  "hideEasing": "linear",
			  "showMethod": "fadeIn",
			  "hideMethod": "fadeOut"
			}
			Command: toastr["success"]("this survey end date now is : " + new_date);
		 }else{
			 Swal.fire(
			 'error',
			 'Oops! We have an unexpected error.',
			 'error'
			 );
		 }
     },
     ajaxError: function(){
		 Swal.fire(
		 'error',
		 'oops!! we have a error',
		 'error'
		 );
     }
     });
  });
});

	//question_list
function getquestions(roupid){
 $.ajax({
	 type: 'POST',
	 url: '<?php echo base_url(); ?>EN/DashboardSystem/get_questions_of_avalaible_surveys',
	 data: {
	  requestFor : 'All_questions',
	  group_id   : roupid,
	 },
	 success: function (data) {
		 if(data.length > 0){
		   $('.showquestions').fadeOut();
			 setTimeout(function(){
			   $('.question_list').html(data);
			 },800);
		 }
	 },
	 ajaxError: function(){
		 Swal.fire(
		 'error',
		 'oops!! we have a error',
		 'error'
		 );
	 }
 });	
}

$('input[type="checkbox"]').each(function(){
$(this).change(function(){
var Id = $(this).attr('serv_Id');
var status = this.checked ? "Enabled" : "Disabled";	
if(status == "Disabled"){
    Swal.fire({
        title: "What does this mean?",
        html: "When disabled, no one can use the survey.",
        icon: "warning",
        confirmButtonColor: "#f46a6a",
        cancelButtonColor: "#34c38f",
        confirmButtonText: "Ok, but you can change it anytime."
      }).then(function (result) {
        if (result.value) {
            update_status(Id);
            console.log(result.value);
        }
      });
}else{
  update_status(Id);
}
  }); 
});

function update_status(Id) {
    $.ajax({
     type: 'POST',
     url: '<?php echo base_url(); ?>EN/DashboardSystem/change_serv_status',
     data: {
      serv_id : Id,
	  type : 'change'
     },
     success: function (data) {
		 if(data === "ok"){
			toastr.options = {
			  "closeButton": false,
			  "debug": false,
			  "newestOnTop": false,
			  "progressBar": false,
			  "positionClass": "toast-top-right",
			  "preventDuplicates": false,
			  "onclick": null,
			  "showDuration": 300,
			  "hideDuration": 300,
			  "timeOut": 5000,
			  "extendedTimeOut": 1000,
			  "showEasing": "swing",
			  "hideEasing": "linear",
			  "showMethod": "fadeIn",
			  "hideMethod": "fadeOut"
			}
			Command: toastr["success"]("The survey status was updated. " + status);
		 }else{
			 Swal.fire(
			 'error',
			 'Oops! We have an unexpected error.',
			 'error'
			 );
		 }
     },
     ajaxError: function(){
		 Swal.fire(
		 'error',
		 'oops!! we have a error',
		 'error'
		 );
     }
     });
}

</script>
</body>
</html>