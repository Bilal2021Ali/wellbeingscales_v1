<!doctype html>
<html>
<head>
<meta charset="utf-8">
<script src="<?php echo base_url();?>assets/libs/apexcharts/apexcharts.min.js"></script> 
<script src="<?php echo base_url();?>assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script> 
<script src="<?php echo base_url(); ?>assets/libs/sweetalert2/sweetalert2.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/libs/toastr/build/toastr.min.css">
</head>

<style>
.lds-roller {
    display: inline-block;
    position: absolute;
    width: 64px;
    height: 64px;
    top: 40%;
    left: 50%;
}
.lds-roller div {
    animation: lds-roller 1.2s cubic-bezier(0.5, 0, 0.5, 1) infinite;
    transform-origin: 32px 32px;
}
.lds-roller div:after {
    content: " ";
    display: block;
    position: absolute;
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: #2D2D2D;
    margin: -3px 0 0 -3px;
}
.lds-roller div:nth-child(1) {
    animation-delay: -0.036s;
}
.lds-roller div:nth-child(1):after {
    top: 50px;
    left: 50px;
}
.lds-roller div:nth-child(2) {
    animation-delay: -0.072s;
}
.lds-roller div:nth-child(2):after {
    top: 54px;
    left: 45px;
}
.lds-roller div:nth-child(3) {
    animation-delay: -0.108s;
}
.lds-roller div:nth-child(3):after {
    top: 57px;
    left: 39px;
}
.lds-roller div:nth-child(4) {
    animation-delay: -0.144s;
}
.lds-roller div:nth-child(4):after {
    top: 58px;
    left: 32px;
}
.lds-roller div:nth-child(5) {
    animation-delay: -0.18s;
}
.lds-roller div:nth-child(5):after {
    top: 57px;
    left: 25px;
}
.lds-roller div:nth-child(6) {
    animation-delay: -0.216s;
}
.lds-roller div:nth-child(6):after {
    top: 54px;
    left: 19px;
}
.lds-roller div:nth-child(7) {
    animation-delay: -0.252s;
}
.lds-roller div:nth-child(7):after {
    top: 50px;
    left: 14px;
}
.lds-roller div:nth-child(8) {
    animation-delay: -0.288s;
}
.lds-roller div:nth-child(8):after {
    top: 45px;
    left: 10px;
}
@keyframes lds-roller {
0% {
transform: rotate(0deg);
}
100% {
transform: rotate(360deg);
}
}
.start_sync {
    cursor: pointer;
    position: fixed;
    z-index: 1000;
}
.start_sync i {
    font-size: 20px;
    cursor: pointer;
}
.infosCard {
    border: 0px;
    border-radius: 10px;
}
.tab-pane, .tab-content {
    width: 100%;
}
.dataShow {
    background: #fff;
    text-align: center;
    display: grid;
    align-items: center;
    padding-top: 10px;
}
.dataShow h4, .dataShow h5, .dataShow h6 {
    margin: 0px;
}
.dataShow img {
    margin: auto;
    width: 40px;
}
.why {
    position: absolute;
    top: 10px;
    cursor: pointer;
}
.why i {
    font-size: 20px;
}
.unit_f {
    font-size: 10px;
}
.start_sync {
    cursor: pointer;
    position: fixed;
    z-index: 1000;
}
.start_sync i {
    font-size: 20px;
    cursor: pointer;
}
.apexcharts-text.apexcharts-datalabel-label {
    font-size: 30px;
}
.infosCard h3 {
    font-size: 15px;
}
.open_more {
    border: 0px;
    text-align: center;
    height: 90%;
    margin-bottom : 20px;
}
.open_more i {
    font-size: 30px;
    margin: auto;
}
.open_more .row {
    margin: auto;
    margin-top: 20px;
}
.open_more .card-body {
    background: rgb(14 172 216);
    border-radius: 5px;
}
.open_more i, .open_more h3 {
    color: #fff;
}
.infosCard {
    transition: 0.5s all;
    cursor: default;
}
.infosCard .card-body {
    border: 3px solid;
    border-radius: 10px;
}
.infosCard .col-sm-12 {
    text-align: center;
}
.infosCard:hover {
    transition: 0.5s all;
    transform: scale(1.05);
}
.infosCard span {
    font-size: 10px;
}
</style>
<body>
<div id="preloader" style="display: block;">
  <div class="lds-roller">
    <div></div>
    <div></div>
    <div></div>
    <div></div>
    <div></div>
    <div></div>
    <div></div>
    <div></div>
  </div>
</div>
<?php
$data = $this->db->query( " SELECT 
`air_result_daily`.`device_id`,
air_result_daily.* ,
`air_areas`.`Description` as `Area`
FROM `air_result_daily` 
JOIN `air_areas` ON `air_areas`.`Id` = `air_result_daily`.`device_id`
WHERE `air_result_daily`.`User_type` = 'Company_Department' 
AND `air_result_daily`.`source_id` = '" . $sessiondata[ 'admin_id' ] . "' 
AND `air_areas`.`user_type` = 'Company_Department' AND
`air_areas`.`source_id` =  '" . $sessiondata[ 'admin_id' ] . "' 
ORDER BY `air_result_daily`.`Id` DESC " )->result_array();


function showCircle( $id, $result, $type, $condition_id, $img_url, $date = "--/--/--" ) {
  $ci = & get_instance();
  $conditions = $ci->db->query( " SELECT * FROM `air_levels` WHERE Id = '" . $condition_id . "' " )->result_array();
  $condition = $conditions[ 0 ];

  if ( $result > $condition[ 'good_from' ] && $result < $condition[ 'good_to' ] ) {
    $status = "Good";
    $f_t = $condition[ 'good_from' ] . "-" . $condition[ 'good_to' ];
    $color = $condition[ 'good_back_col' ];
    $f_color = $condition[ 'good_font_col' ];
  } elseif ( $result > $condition[ 'satisfactory_from' ] && $result < $condition[ 'satisfactory_to' ] ) {
    $status = "Satisfactory";
    $f_t = $condition[ 'satisfactory_from' ] . "-" . $condition[ 'satisfactory_to' ];
    $color = $condition[ 'satisfactory_back_col' ];
    $f_color = $condition[ 'satisfactory_font_col' ];
  } elseif ( $result > $condition[ 'moderatelypolluted_from' ] && $result < $condition[ 'moderatelypolluted_to' ] ) {
    $status = "Moderate";
    $f_t = $condition[ 'moderatelypolluted_from' ] . "-" . $condition[ 'moderatelypolluted_to' ];
    $color = $condition[ 'moderatelypolluted_back_col' ];
    $f_color = $condition[ 'moderatelypolluted_font_col' ];
  } elseif ( $result > $condition[ 'poor_from' ] && $result < $condition[ 'poor_to' ] ) {
    $status = "Poor";
    $f_t = $condition[ 'poor_from' ] . "-" . $condition[ 'poor_to' ];
    $color = $condition[ 'poor_back_col' ];
    $f_color = $condition[ 'poor_font_col' ];
  } elseif ( $result > $condition[ 'verypoor_from' ] && $result < $condition[ 'verypoor_to' ] ) {
    $status = "Very Poor";
    $f_t = $condition[ 'verypoor_from' ] . "-" . $condition[ 'verypoor_to' ];
    $color = $condition[ 'verypoor_back_col' ];
    $f_color = $condition[ 'verypoor_font_col' ];
  } elseif ( $result > $condition[ 'severe_from' ] && $result < $condition[ 'severe_to' ] ) {
    $status = "Severe";
    $f_t = $condition[ 'severe_from' ] . "-" . $condition[ 'severe_to' ];
    $color = $condition[ 'severe_back_col' ];
    $f_color = $condition[ 'severe_font_col' ];
  } else {
    $status = "Not Found";
    $f_t = "Not Found";
    $color = "#000";
    $f_color = "#000";
  }
  ?>
<?php
if ( $status !== "Not Found" ) {
  //
  ?>
<div class="col-sm-12">
  <h3 class="text-center" style="width: 100%;">
    <?php  echo $type  ?>
  </h3>
</div>
<div class="col-sm-12 dataShow" data-fColor="<?php  echo $f_color;  ?>" bkcolor="<?php  echo $color;  ?>"> <img src="<?php echo base_url() ?>assets/images/icons/<?php  echo $img_url  ?>" alt="" width="30px">
  <h4>
    <?php  echo $status;  ?>
  </h4>
  <h6 class="F_T">(
    <?php  echo $f_t  ?>
    )</h6>
  <h5> <span class="unit_f">
    <?php  echo $condition['unit']   ?>
    </span>
    <?php  echo $result  ?>
  </h5>
  <span>
  <?php  echo $date;  ?>
  </span> </div>
<?php  }else{  ?>
<div class="col-sm-12">
  <h3 class="text-center" style="width: 100%;">
    <?php  echo $type  ?>
  </h3>
</div>
<div class="col-sm-12" data-fColor="<?php  echo $f_color;  ?>"> <img src="<?php echo base_url() ?>assets/images/icons/<?php  echo $img_url  ?>" alt="" width="30px">
  <h4>NA/NA</h4>
  <h6 class="F_T">(-- / --)</h6>
  <h5> <span class="unit_f">NA / NA</span>--</h5>
  <span>
  <?php  echo $date;  ?>
  </span> </div>
<?php } ?>
<?php } ?>
<div class="main-content">
  <div class="page-content">
    <div class="container-fluid">
      <div class="start_sync"> <i class="uil uil-refresh"></i> </div>
      <?php  $exist = array();   ?>
      <?php  if(!empty($data)){  ?>
      <div class="row  justify-content-center">
        <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
          <?php  foreach($data as $devices){  ?>
          <?php
          if ( !in_array( $devices[ 'device_id' ], $exist ) ) {
            $exist[] = $devices[ 'device_id' ];
            ?>
          <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#Device<?php  echo $devices['device_id']  ?>" role="tab" aria-selected="false"> <span class="d-block d-sm-none"><i class="fas fa-home"></i></span> <span class="d-none d-sm-block">
            <?php  echo $devices['Area']  ?>
            </span> </a> </li>
          <?php  }  ?>
          <?php  }  ?>
        </ul>
      </div>
      <div class="tab-content p-3 text-muted">
        <?php
        $exist = array();
        foreach ( $data as $devices ) {
          if ( !in_array( $devices[ 'device_id' ], $exist ) ) {
            $exist[] = $devices[ 'device_id' ];
            ?>
        <div class="tab-pane col-xl-12 col-xl-auto" id="Device<?php echo  $devices['device_id']  ?>" role="tabpanel">
          <div class="row">
            <div class="col-xl-2">
              <div class="card infosCard">
                <div class="card-body">
                  <div class="row">
                    <?php  showCircle($devices['device_id']."_".rand(1000,50000),$devices['aq'],'AQ',1,"1000.png",$devices['aq_time']);  ?>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-2">
              <div class="card infosCard">
                <div class="card-body">
                  <div class="row">
                    <?php  showCircle($devices['device_id']."_".rand(1000,50000),$devices['ch2o'],'ch2O',2,"1001.png",$devices['ch2o_time']);  ?>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-2">
              <div class="card infosCard">
                <div class="card-body">
                  <div class="row">
                    <?php  showCircle($devices['device_id']."_".rand(1000,50000),$devices['co2'],'CO2',3,"1002.png",$devices['co2_time']);  ?>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-2">
              <div class="card infosCard">
                <div class="card-body">
                  <div class="row">
                    <?php  showCircle($devices['device_id']."_".rand(1000,50000),$devices['dewpoint_c'],'Dewpoint C',4,"1003.png",$devices['dewpoint_c_time']);  ?>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-2 hidden">
              <div class="card infosCard">
                <div class="card-body">
                  <div class="row">
                    <?php  showCircle($devices['device_id']."_".rand(1000,50000),$devices['dewpoint_f'],'Dewpoint F',5,"1004.png",$devices['dewpoint_f_time']);  ?>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-2">
              <div class="card infosCard">
                <div class="card-body">
                  <div class="row">
                    <?php  showCircle($devices['device_id']."_".rand(1000,50000),$devices['humidity'],'Humidity',6,"1005.png",$devices['humidity_time']);  ?>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-2">
              <div class="card infosCard">
                <div class="card-body">
                  <div class="row">
                    <?php  showCircle($devices['device_id']."_".rand(1000,50000),$devices['voc_EtOH'],'VOC EtOH',7,"1006.png",$devices['voc_EtOH_time']);  ?>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-2">
              <div class="card infosCard">
                <div class="card-body">
                  <div class="row">
                    <?php  showCircle($devices['device_id']."_".rand(1000,50000),$devices['voc_Isobutylene'],'VOC Isobutylene',8,"1007.png",$devices['voc_Isobutylene_time']);  ?>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-2">
              <div class="card infosCard">
                <div class="card-body">
                  <div class="row">
                    <?php  showCircle($devices['device_id']."_".rand(1000,50000),$devices['Temperature_c'],'Temperature C',9,"1008.png",$devices['Temperature_c_time']);  ?>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-2 hidden">
              <div class="card infosCard">
                <div class="card-body">
                  <div class="row">
                    <?php  showCircle($devices['device_id']."_".rand(1000,50000),$devices['Temperature_f'],'Temperature F',10,"1009.png",$devices['Temperature_f_time']); ?>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-2">
              <div class="card infosCard">
                <div class="card-body">
                  <div class="row">
                    <?php  showCircle($devices['device_id']."_".rand(1000,50000),$devices['Pressure'],'Pressure',11,"1010.png",$devices['Pressure_time']); ?>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-2">
              <div class="card infosCard">
                <div class="card-body">
                  <div class="row">
                    <?php  showCircle($devices['device_id']."_".rand(1000,50000),$devices['pc0_3'],'PC 0.3',12,"1011.png",$devices['pc0_3_time']); ?>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-2">
              <div class="card infosCard">
                <div class="card-body">
                  <div class="row">
                    <?php  showCircle($devices['device_id']."_".rand(1000,50000),$devices['pc0_5'],'PC 0.5',13,"1012.png",$devices['pc0_5_time']); ?>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-2">
              <div class="card infosCard">
                <div class="card-body">
                  <div class="row">
                    <?php  showCircle($devices['device_id']."_".rand(1000,50000),$devices['pc1'],'PC 1.0',14,"1013.png",$devices['pc1_time']); ?>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-2">
              <div class="card infosCard">
                <div class="card-body">
                  <div class="row">
                    <?php  showCircle($devices['device_id']."_".rand(1000,50000),$devices['pc2_5'],'PC 2.5',15,"1014.png",$devices['pc2_5_time']); ?>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-2">
              <div class="card infosCard">
                <div class="card-body">
                  <div class="row">
                    <?php  showCircle($devices['device_id']."_".rand(1000,50000),$devices['pc5'],'PC 5.0',16,"1015.png",$devices['pc5_time']); ?>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-2">
              <div class="card infosCard">
                <div class="card-body">
                  <div class="row">
                    <?php  showCircle($devices['device_id']."_".rand(1000,50000),$devices['pc10'],'PC 10.0',17,"1016.png",$devices['pc10_time']); ?>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-2">
              <div class="card infosCard">
                <div class="card-body">
                  <div class="row">
                    <?php  showCircle($devices['device_id']."_".rand(1000,50000),$devices['pm'],'PM',18,"1017.png",$devices['pm_time']);  ?>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-2">
              <div class="card infosCard">
                <div class="card-body">
                  <div class="row">
                    <?php  showCircle($devices['device_id']."_".rand(1000,50000),$devices['pm1'],'PM1',19,"1018.png",$devices['pm1_time']);  ?>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-2">
              <div class="card infosCard">
                <div class="card-body">
                  <div class="row">
                    <?php  showCircle($devices['device_id']."_".rand(1000,50000),$devices['pm2_5'],'PM2.5',20,"1019.png",$devices['pm2_5_time']);  ?>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-2">
              <div class="card infosCard">
                <div class="card-body">
                  <div class="row">
                    <?php  showCircle($devices['device_id']."_".rand(1000,50000),$devices['pm10'],'PM10',20,"1020.png",$devices['pm10_time']);  ?>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-2"> <a href="<?php echo base_url() ?>EN/Company_Departments/Realtime_Dashboard/<?php echo $devices['Device_Mac']  ?>">
              <div class="card open_more">
                <div class="card-body">
                  <div class="row"> <i class="uil uil-arrow-up-right"></i>
                    <h3>More Details</h3>
                  </div>
                </div>
              </div>
              </a> 
			 </div>
          </div>
        </div>
      <?php  }  ?>
      <?php  }   ?>
		</div>
    </div>
    <?php  }else{  ?>
    <div class="row">
      <div class="col-md-12">
        <div class="text-center">
          <div>
            <div class="row justify-content-center">
              <div class="col-sm-4">
                <div class="error-img"> <img src="<?php echo base_url() ?>assets/images/no_data_in_table.svg" 
										    alt="" class="img-fluid mx-auto d-block"> </div>
              </div>
            </div>
          </div>
          <h4 class="text-uppercase mt-4">No data </h4>
          <p class="text-muted">Sorry, we cannot find any results.  </p>
        </div>
      </div>
    </div>
    <?php  }  ?>
  </div>
</div>
</body>
<script src="<?php echo base_url() ?>assets/libs/toastr/build/toastr.min.js"></script>
<script>
$('.tab-pane').first().addClass('active');	
$('.nav-link').first().addClass('active');	
$('.dataShow').each(function(){
	var color  = $(this).attr('data-fcolor');
	var bk  = $(this).attr('bkcolor');
	$(this).children().not('.F_T').css( "color", "#"+color);
	$(this).parent(".row").parent('.card-body').not('.card').css( "border-color", "#"+color);
	//$(this).parent('.F_T').css( "background-color", "#"+color);
	console.log($(this).parents(".card-body"));
});	
	
var devices = devices_request();

function syncData(devices){
  var token  = "89577b9b-195b-4db9-b408-231bf1dbd752";
	//console.log(devices);
      if(devices.length > 0){
		 devices.map(device => {
			 getDeviceData(device._id);
			 //console.log(device._id);
		 }); 
	  }else{
		  	console.log('Empty' + devices.length);
	  }
}
//syncData(devices);	

function devices_request(){
    var token  = "89577b9b-195b-4db9-b408-231bf1dbd752";
	var davicesList = [];
	var davicesList = $.parseJSON($.ajax({
	    type: 'POST',
		headers: {
			  "Authorization": "Bearer "+ token
	    },
        url:  'https://api.environet.io/search/nodes',
        dataType: "json", 
        async: false
		}).responseText);
	    return davicesList;
}
	
	
function getDeviceData(dev_id){
	var arr_data = Object();
	arr_data = {
		Device_Mac 		: "",
		humidity   		: "",
		ch2o       		: "",
		voc_EtOH   		: "",
		pm10       		: "",
		voc_Isobutylene : "",
		pm2_5 			: "",
		pm1 		  	: "",
		pm 		  	    : "",
		dewpoint_f 	    : "",
		dewpoint_c 	    : "",
		Temperature_c   : "",
		Temperature_f   : "",
		Pressure 	  	: "",
		co2 	  	  	: "",
		aq 	  	  	    : "",
		pc0_3 	  	    : "",
		pc0_5 	  	    : "",
		pc1 	  	  	: "",
		pc2_5 	  	    : "",
		pc5	  	        : "",
		pc10 	  	    : "",
	};
	console.log(arr_data);
  	var token  = "89577b9b-195b-4db9-b408-231bf1dbd752";
	var device_info = $.parseJSON($.ajax({
	    type: 'POST',
		headers: {
			  "Authorization": "Bearer "+ token
	    },
        url:  'https://api.environet.io/search/data_points',
        dataType: "json", 
        async: false,
		data: {
			node_id : dev_id,
			last : 1,
		}
		}).responseText);
		if(device_info.length > 0){
			console.log(device_info);
			device_info.map(function(one){
				var i;
				console.log(one);
				console.log('++');
				arr_data['Device_Mac'] = one.device_id;
				if(one.name == "DewPoint" && one.unit == "°F"){
				   arr_data["dewpoint_f"] = one.measurements[0][1];	
				}else if(one.name == "DewPoint" && one.unit == "°C"){
				   arr_data["dewpoint_c"] = one.measurements[0][1];	
			    }else if(one.name == "Humidity"){
				   arr_data["humidity"] = one.measurements[0][1];	
			    }else if(one.name == "CH₂O"){
				   arr_data["ch2o"] = one.measurements[0][1];	
			    }else if(one.name == "VOC (EtOH)"){
				   arr_data["voc_EtOH"] = one.measurements[0][1];	
			    }else if(one.name == "VOC (Isobutylene)"){
				   arr_data["voc_Isobutylene"] = one.measurements[0][1];	
			    }else if(one.name == "PM10"){
				   arr_data["pm10"] = one.measurements[0][1];	
			    }else if(one.name == "PM2.5"){
				   arr_data["pm2_5"] = one.measurements[0][1];	
			    }else if(one.name == "PM1"){
				   arr_data["pm1"] = one.measurements[0][1];	
			    }else if(one.name == "PM"){
				   arr_data["pm"] = one.measurements[0][1];	
			    }else if(one.name == "Temperature" && one.unit == "°C"){
				   arr_data["Temperature_c"] = one.measurements[0][1];	
			    }else if(one.name == "Temperature" && one.unit == "°F"){
				   arr_data["Temperature_f"] = one.measurements[0][1];	
			    }else if(one.name == "Pressure"){
				   arr_data["Pressure"] = one.measurements[0][1];	
			    }else if(one.name == "CO₂"){
				   arr_data["co2"] = one.measurements[0][1];	
			    }else if(one.name == "AQ"){
				   arr_data["aq"] = one.measurements[0][1];	
			    }else if(one.name == "PC 0.3μm"){
				   arr_data["pc0_3"] = one.measurements[0][1];	
			    }else if(one.name == "PC 0.5μm"){
				   arr_data["pc0_5"] = one.measurements[0][1];	
			    }else if(one.name == "PC 1.0μm"){
				   arr_data["pc1"] = one.measurements[0][1];	
			    }else if(one.name == "PC 2.5μm"){
				   arr_data["pc2_5"] = one.measurements[0][1];	
			    }else if(one.name == "PC 5.0μm"){
				   arr_data["pc5"] = one.measurements[0][1];	
			    }else if(one.name == "PC 10.0μm"){
				   arr_data["pc10"] = one.measurements[0][1];	
			    }

			});
			console.log('Final is : ');
			console.log(arr_data);
			go_addData(arr_data);
		}
}
	
	
function go_addData(device_return){
	  $.ajax({
		  type: 'POST',
		  url: '<?php echo base_url(); ?>EN/Ajax/sync_device',
		  data: {
			  device_results : device_return
		  },
		  beforeSend: function() {
		  // setting a timeout
		  }, 
		  success: function (data) {
			  if(data == "success"){
				 $('#preloader').fadeOut();
			  }
		  },
		  ajaxError: function(){
		  Swal.fire(
		  'error',
		  'oops!! لدينا خطأ',
		  'error'
		  )
		  }
	  });
}	
	
$('.start_sync').click(function(){
	toastr.options = {
	  "closeButton": false,
	  "debug": false,
	  "newestOnTop": false,
	  "progressBar": true,
	  "positionClass": "toast-bottom-right",
	  "preventDuplicates": false,
	  "onclick": null,
	  "showDuration": 300,
	  "hideDuration": 1000,
	  "timeOut": 5000,
	  "extendedTimeOut": 1000,
	  "showEasing": "swing",
	  "hideEasing": "linear",
	  "showMethod": "fadeIn",
	  "hideMethod": "fadeOut"
	}
	Command: toastr["warning"](" The sync has started , Please wait.... ")
	syncData(devices);
});
	
</script>
</html>