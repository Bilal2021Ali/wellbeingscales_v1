<!doctype html>
<html>
<head>
<link href="<?php echo base_url() ?>assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url() ?>assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />	
<meta charset="utf-8">
</head>
<style>
	.select2.select2-container {
		width: 100% !important;
	}
	.loader {
		position: absolute;
		width: 100%;
		height: 100%;
		background: #fff;
		top: 0px;
		left: 0px;
		z-index: 100;
		text-align: center;
		padding: 50px;	 
	}
	
	.action {
		text-align: center;
	}
	
	.action .delete {
		color:  #F40003;
		font-size: 20px;
		cursor: pointer;
	}
	
</style>	
<style>
	.connected {
		text-align: center;
	}
</style>
<body>
<div class="main-content">
  <div class="page-content">
	  <div class="container">
          <div class="row">
              <div class="col-lg-4">
                  <div class="card">
                      <div class="card-body">
                        <form id="connect_new">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="loader" style="display: none;"> 
                                        <div class="spinner-border text-primary m-1" role="status" style="margin: auto !important;" >
                                            <span class="sr-only">Loading...</span>
                                        </div>
                                    </div>
                                <h3 class="text-center"> Connect With </h3>
                                    <div class="form-group">
                                        <label class="control-label">system</label><br>
                                        <select class="form-control select2" name="for">
                                            <?php  foreach($new_to_connect as $sys){  ?>
                                                <option value="<?php  echo $sys['Id'];  ?>">
                                                    <?php echo $sys['Dept_name']  ?>
                                                </option>
                                            <?php }   ?>
                                        </select>
                                        <input type="hidden" value="<?php echo $thisId;   ?>" name="from">
                                    </div>
                                    <button type="Submit" class="btn btn-primary btn-lg btn-block waves-effect waves-light mb-1">
                                        add 
                                    </button>	
                                </div>
                            </div>
                        </form>
                      </div>
                  </div>
              </div>
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <th>#</th>
                                <th>Dept Name</th>
                                <th>Date &amp; time</th>
                                <th>action</th>
                            </thead>
                            <tbody>
                                <?php  foreach($connects as $Key=>$connected){  ?>
                                <tr class="animate__animated" id="conn_<?php echo $connected['conn_id']; ?>">
                                    <td><?php  echo $Key+1; ?></td>
                                    <td><?php  echo $connected['Title']  ?></td>
                                    <td><?php  echo $connected['In']  ?></td>
                                    <td class="action"><i class="uil uil-trash delete" for="<?php  echo $connected['conn_id']  ?>"></i></td>
                                </tr>
                                <?php  }  ?>
                            </tbody>
                        </table>
                    </div>
                </div>  
            </div>   
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
<script src="<?php echo base_url() ?>assets/libs/select2/js/select2.min.js"></script>
<script>
$('.table').DataTable();
$('.select2').select2();
$("#connect_new").on('submit', function (e) {
     e.preventDefault();
     $.ajax({
          type: 'POST',
          url: '<?php echo base_url(); ?>EN/Dashboard/manage_dept_connect_ref',
          data: new FormData(this),
          contentType: false,
          cache: false,
          processData: false,
          beforeSend: function () {
			  $('.loader').fadeIn();
		  },
          success: function (data) {
			 if(data == "ok"){
			  location.reload();
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
				 'Oops! We have an unexpected error.',
				 'error'
			 );
          }
     });
});
    
$('.delete').each(function(){
	$(this).click(function(){
	var id = $(this).attr('for');
      Swal.fire({
        title: 'هل أنت متأكد',
        text: "لن تتمكن من التراجع عن هذا!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'نعم,أحذفها!',
        cancelButtonText: 'No, cancel!',
        confirmButtonClass: 'btn btn-success mt-2',
        cancelButtonClass: 'btn btn-danger ml-2 mt-2',
        buttonsStyling: false
      }).then(function (result) {
        if (result.value) {
		  //DELETE 	
		 $.ajax({
			 type: 'DELETE',
			 url: '<?php echo base_url(); ?>EN/Dashboard/manage_dept_connect_ref',
			 data: {
			  id : id,
			 },
			 success: function (data) {
				 if(data === "ok"){
				  Swal.fire({
					title: 'Deleted!',
					text: 'Your set has been deleted.',
					icon: 'success'
				  }).then(function (result) {
				  		$('#conn_' + id ).addClass('animate__flipOutX'); 
					setTimeout(function(){
				  		$('#conn_' + id ).remove(); 
					},800);  
				  });
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
				 'oops!! لدينا خطأ',
				 'error'
				 );
			 }
			 });          
        }
      });	
   });
});	    
</script>	
</body>
</html>