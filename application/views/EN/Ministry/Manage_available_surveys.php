<!doctype html>
<html>
<head>
<meta charset="utf-8">
 <link rel="preconnect" href="https:/fonts.gstatic.com">
 <link href="https://fonts.googleapis.com/css2?family=Almarai:wght@700&display=swap" rel="stylesheet">
 <link rel="stylesheet"  href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
 <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/libs/toastr/build/toastr.min.css">
</head>
<style>
.questions {
    font-size: 23px;
    color: #3c40c6;
    cursor: pointer;
}
    
.use_ser {
    font-size: 23px;
    margin-left: 10px;
}
    
</style>
<body>
<div class="main-content">
  <div class="page-content">
      <div class="card">
          <div class="card-body"> 
              <div class="table-responsive mb-0" data-pattern="priority-columns">
                <table class="table dt-responsive nowrap">
                  <thead>
                    <th>#</th>
                    <th>code</th>
                    <th>category</th>
                    <th>title</th>
                    <th>Scale</th>
                    <th>Completed</th>
                    <th>questions</th>
                    <th>Choices</th>
                    <th>Action</th>
                  </thead>
                  <tbody>
                    <?php  foreach($surveys as $key=>$survey){ ?>
                    <?php
                    $choices_count = $this->db->query( "SELECT Id FROM `sv_set_template_answers_choices`
                    WHERE `group_id` = '" . $survey[ 'group_id' ] . "' " )->num_rows();
                    ?>
                    <tr id="serv_<?php  echo $survey['survey_id'];  ?>">
                      <td class="count"><?php  echo $key+1;  ?></td>
                      <td><?php  echo $survey['serv_code'];  ?></td>
                      <td><?php  echo $survey['Title_en'];  ?></td>
                      <td><?php  echo $survey['set_name_en'];  ?></td>
                      <td><?php  echo $survey['choices_en_title'];  ?></td>
                      <td>0</td>
                      <td><?php  echo $survey['questions_count'];  ?></td>
                      <td><?php  echo $choices_count  ?></td>
                      <td class="text-center">
                      <span  data-toggle="tooltip" data-placement="top" data-original-title="Show the survey questions">
                      <i class="uil uil-notes questions"  data-toggle="modal" 
                      data-target="#myModal" group="<?php echo $survey['survey_id']; ?>"></i> 
                      </span>
                      <a href="<?php echo base_url() ?>EN/DashboardSystem/use_this_survey/<?php echo $survey['survey_id']; ?>"
                         class="use_ser"  data-toggle="tooltip" data-placement="top" data-original-title="Use this survey">
                          <i class="uil uil-channel"></i>
                      </a>
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
</body>
<script src="<?php echo base_url(); ?>assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo base_url() ?>assets/libs/toastr/build/toastr.min.js"></script>
<script src="<?php echo base_url() ?>assets/libs/datatables.net-autoFill/js/dataTables.autoFill.min.js"></script>
<script src="<?php echo base_url() ?>assets/libs/datatables.net-autoFill-bs4/js/autoFill.bootstrap4.min.js"></script>
<script src="<?php echo base_url() ?>assets/libs/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
<script src="<?php echo base_url() ?>assets/libs/bootstrap-editable/js/index.js"></script>	
<script>
$('.table').DataTable();
    
// show questions	
$('.questions').each(function(){
	$(this).click(function(){
		var groupid = $(this).attr('group');
		$('.question_list').html("");
		$('.showquestions').fadeIn();
		getquestions(groupid);
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
    
</script>
</html>