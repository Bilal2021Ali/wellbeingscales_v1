<link href="<?php echo base_url() ?>assets/libs/@fullcalendar/core/main.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url() ?>assets/libs/@fullcalendar/daygrid/main.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url() ?>assets/libs/@fullcalendar/bootstrap/main.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url() ?>assets/libs/@fullcalendar/timegrid/main.min.css" rel="stylesheet" type="text/css" />
<body>
<div class="col-lg-12">
	<div class="card">
		<div class="card-body">
			<div id="calendar"></div>
		</div>
	</div>
</div> <!-- end col -->
</body>
	<!-- plugin js -->
<script src="<?php echo base_url() ?>assets/libs/moment/min/moment.min.js"></script>
<script src="<?php echo base_url() ?>assets/libs/jquery-ui-dist/jquery-ui.min.js"></script>
<script src="<?php echo base_url() ?>assets/libs/@fullcalendar/core/main.min.js"></script>
<script src="<?php echo base_url() ?>assets/libs/@fullcalendar/bootstrap/main.min.js"></script>
<script src="<?php echo base_url() ?>assets/libs/@fullcalendar/daygrid/main.min.js"></script>
<script src="<?php echo base_url() ?>assets/libs/@fullcalendar/timegrid/main.min.js"></script>
<script src="<?php echo base_url() ?>assets/libs/@fullcalendar/interaction/main.min.js"></script>
<!-- Calendar init -->
<?php
$arr = array();
$arrayOfPatient = $this->db->query("SELECT
l2_co_patient.Id,l2_co_patient.UserType,l2_co_monthly_result.Created as Date,
l2_co_monthly_result.Result as Temp_Result
FROM l2_co_patient 
JOIN `l2_co_monthly_result` ON `l2_co_monthly_result`.`UserId` = `l2_co_patient`.`Id`
AND `l2_co_monthly_result`.`UserType` = `l2_co_patient`.`UserType`
JOIN `l1_co_department` ON `l1_co_department`.`Id` = `l2_co_patient`.`Added_By`
GROUP BY `l2_co_monthly_result`.`Created` ")->result_array();
	foreach($arrayOfPatient as $patient_result){
		$normal = 0;	
		$moderate = 0;	
		$high = 0;	  
		$low = 0;	  
		if($patient_result['Temp_Result'] >= 36.3 && $patient_result['Temp_Result'] <= 37.5){
			$normal++;
		}elseif($patient_result['Temp_Result'] >= 37.6 && $patient_result['Temp_Result'] <= 38.4){
			$moderate++;
		}elseif($patient_result['Temp_Result'] >= 38.5 && $patient_result['Temp_Result'] <= 45){
			$high++;
		}elseif($patient_result['Temp_Result'] >= 0 && $patient_result['Temp_Result'] <= 36.2){
			$low++;
		}
		$arr[] = array("start" => $patient_result['Date'] , "title" => " $normal : طبيعي  " ,
					   "className" => 'bg-success' , "allDay" => "false" );
		$arr[] = array("start" => $patient_result['Date'] , "title" => " $high : عالي " , 
					   "className" => 'bg-danger' , "allDay" => "false" );
		$arr[] = array("start" => $patient_result['Date'] , "title" => "$low : منخفض " ,
					   "className" => 'bg-info' , "allDay" => "false" );
		$arr[] = array("start" => $patient_result['Date'] , "title" => " $moderate : معتدل " , 
					   "className" => 'bg-warning' , "allDay" => "false" );
	}
?>
<script>
	/*
	[
	{
      title: 'Meeting',
      start: new Date(y, m, d, 10, 30),
      allDay: false,
      className: 'bg-success'
    }, {
      title: 'Lunch',
      start: new Date("01-10-2021"),
      allDay: false,
      className: 'bg-danger'
    }
	];
	*/
	var defaultEvents = [];
    var date = new Date();
    var d = date.getDate();
    var m = date.getMonth();
    var y = date.getFullYear();
	console.log(new Date(y, m, d, 10, 30));
    var defaultEvents = <?php echo json_encode($arr); ?>
	
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
      plugins: ['bootstrap', 'interaction', 'dayGrid', 'timeGrid'],
      editable: true,
      droppable: true,
      selectable: true,
      defaultView: 'dayGridMonth',
      themeSystem: 'bootstrap',
      header: {
        left: 'prev,next today',
        center: 'title',
        right: 'listMonth'
      },
      events: defaultEvents
    });
    calendar.render();
</script>
</html>