<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/libs/toastr/build/toastr.min.css">
<script src="<?php echo base_url(); ?>assets/libs/jquery/jquery.min.js"></script>
<script src="<?php echo base_url() ?>assets/libs/toastr/build/toastr.min.js"></script>
<script>
	var devices = devices_request();

	function syncData(devices) {
		var token = "89577b9b-195b-4db9-b408-231bf1dbd752";
		//console.log(devices);
		if (devices.length > 0) {
			devices.map(device => {
				getDeviceData(device._id);
				//console.log(device._id);
			});
		} else {
			console.log('Empty' + devices.length);
		}
	}
	//syncData(devices);	

	function devices_request() {
		var token = "89577b9b-195b-4db9-b408-231bf1dbd752";
		var davicesList = [];
		var davicesList = $.parseJSON($.ajax({
			type: 'POST',
			headers: {
				"Authorization": "Bearer " + token
			},
			url: 'https://api.environet.io/search/nodes',
			dataType: "json",
			async: false
		}).responseText);
		return davicesList;
	}


	function getDeviceData(dev_id) {
		var arr_data = Object();
		arr_data = {
			Device_Mac: "",
			humidity: "",
			ch2o: "",
			voc_EtOH: "",
			pm10: "",
			voc_Isobutylene: "",
			pm2_5: "",
			pm1: "",
			pm: "",
			dewpoint_f: "",
			dewpoint_c: "",
			Temperature_c: "",
			Temperature_f: "",
			Pressure: "",
			co2: "",
			aq: "",
			pc0_3: "",
			pc0_5: "",
			pc1: "",
			pc2_5: "",
			pc5: "",
			pc10: "",
		};
		console.log(arr_data);
		var token = "89577b9b-195b-4db9-b408-231bf1dbd752";
		var device_info = $.parseJSON($.ajax({
			type: 'POST',
			headers: {
				"Authorization": "Bearer " + token
			},
			url: 'https://api.environet.io/search/data_points',
			dataType: "json",
			async: false,
			data: {
				node_id: dev_id,
				last: 1,
			}
		}).responseText);
		if (device_info.length > 0) {
			console.log(device_info);
			device_info.map(function(one) {
				var i;
				console.log(one);
				console.log('++');
				arr_data['Device_Mac'] = one.device_id;
				if (one.name == "DewPoint" && one.unit == "°F") {
					arr_data["dewpoint_f"] = one.measurements[0][1];
				} else if (one.name == "DewPoint" && one.unit == "°C") {
					arr_data["dewpoint_c"] = one.measurements[0][1];
				} else if (one.name == "Humidity") {
					arr_data["humidity"] = one.measurements[0][1];
				} else if (one.name == "CH₂O") {
					arr_data["ch2o"] = one.measurements[0][1];
				} else if (one.name == "VOC (EtOH)") {
					arr_data["voc_EtOH"] = one.measurements[0][1];
				} else if (one.name == "VOC (Isobutylene)") {
					arr_data["voc_Isobutylene"] = one.measurements[0][1];
				} else if (one.name == "PM10") {
					arr_data["pm10"] = one.measurements[0][1];
				} else if (one.name == "PM2.5") {
					arr_data["pm2_5"] = one.measurements[0][1];
				} else if (one.name == "PM1") {
					arr_data["pm1"] = one.measurements[0][1];
				} else if (one.name == "PM") {
					arr_data["pm"] = one.measurements[0][1];
				} else if (one.name == "Temperature" && one.unit == "°C") {
					arr_data["Temperature_c"] = one.measurements[0][1];
				} else if (one.name == "Temperature" && one.unit == "°F") {
					arr_data["Temperature_f"] = one.measurements[0][1];
				} else if (one.name == "Pressure") {
					arr_data["Pressure"] = one.measurements[0][1];
				} else if (one.name == "CO₂") {
					arr_data["co2"] = one.measurements[0][1];
				} else if (one.name == "AQ") {
					arr_data["aq"] = one.measurements[0][1];
				} else if (one.name == "PC 0.3μm") {
					arr_data["pc0_3"] = one.measurements[0][1];
				} else if (one.name == "PC 0.5μm") {
					arr_data["pc0_5"] = one.measurements[0][1];
				} else if (one.name == "PC 1.0μm") {
					arr_data["pc1"] = one.measurements[0][1];
				} else if (one.name == "PC 2.5μm") {
					arr_data["pc2_5"] = one.measurements[0][1];
				} else if (one.name == "PC 5.0μm") {
					arr_data["pc5"] = one.measurements[0][1];
				} else if (one.name == "PC 10.0μm") {
					arr_data["pc10"] = one.measurements[0][1];
				}

			});
			console.log('Final is : ');
			console.log(arr_data);
			go_addData(arr_data);
		}
	}


	function go_addData(device_return) {
		$.ajax({
			type: 'POST',
			url: '<?php echo base_url(); ?>AR/Ajax/sync_device?syncing=true',
			data: {
				device_results: device_return
			},
			beforeSend: function() {
				// setting a timeout
			},
			success: function(data) {
				if (data == "success") {
					$('#preloader').fadeOut();
				}
			},
			ajaxError: function() {
				Swal.fire(
					'error',
					'oops!! we have a error',
					'error'
				)
			}
		});
	}

	syncData(devices);
</script>