<!doctype html>
<html lang="en">
<head>
</head>
<body>
<?php
$parent = $this->db->query("SELECT Added_By FROM `l1_school` 
WHERE Id = '".$sessiondata['admin_id']."' ORDER BY `Id` DESC")->result_array();        
$parentId =  $parent[0]['Added_By']; 
$parent_Infos = $this->db->query("SELECT * FROM `l0_organization` 
WHERE Id = '".$parentId."' ORDER BY `Id` DESC LIMIT 1")->result_array();
$parent_name = $parent_Infos[0]['Username'];                         
?>
<style>
	.data{
		padding: 20px;
	}	
	.user_data p{
		margin: 0px;
	}
	.footer{
	width: 100%;
    left: 0px;
	}
	.pagecon{
		margin-bottom: 70px;
	}
</style>
<div class="container-fluid" style="overflow: hidden;">	
    <div class="row">
      <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
          <h4 class="mb-0"><img src="<?php echo base_url(); ?>assets/images/icons/png_icons/student_card.png" style="width: 25px;margin: auto 5px;">Card(s)</h4>
			<button type="button" class="btn btn-primary btn-block waves-effect waves-light mt-2 mr-1" 
			onClick="Save_all_page_as_Pdf('maybe_test')" style="width: 340px;">
				<i class="uil uil-file mr-2"></i> Save as PDF
			</button>
          <div class="page-title-right">
            <ol class="breadcrumb m-0">
              <li class="breadcrumb-item"><a href="javascript: void(0);"><?php echo $parent_name ?></a></li>
              <li class="breadcrumb-item active"><?php echo $sessiondata['username']; ?></li>
            </ol>
          </div>
        </div>
      </div>
    </div>
    <div class="row pagecon">
		<?php 	foreach($user_data as $student): ?>
      <div class="col-4">
		 <?php 
		  $id = $student['Id'];
		  $text  = "";
		  $text .= "Site Code :".$student['Site_Code'].'\n';
		  $text .= "Description :".$student['Description'].'\n';
		  //print_r($student);
		  ?> 
        <div class="card">
          <div class="card-body">
			 <div class="card-title">Card For <?php echo $student['Site_Code']." ".$student['Description']; ?></div>
			 <div class="row" style="height: 112px;">
 			<div class="fOR8pRINT col-lg-8 " id="fOR8pRINT" >
			  <div class="col-lg-8 user_data">
				  <p> Created : <?php echo $student['Created']; ?></p>
				  <p> Site Code : <?php echo $student['Site_Code']; ?></p>
				  <p> Description  : <?php echo $student['Description']; ?></p>
			  </div>			  
			</div>
			  <div class="col-lg-4 data"  style="margin-top: -24px;">
			 	<div class="qr ToExp" id="qr_id<?php echo $student['Id']; ?>"></div>
				  <div style="margin-left: -7px;margin-top: 12px;">
			 		<canvas id="bcTarget_<?php echo $student['Id'] ?>" class="ToExp"></canvas>
				 </div>
			  </div>
		 </div>
</div>
        </div>
      </div>
		  <?php endforeach; ?>
    </div>
</div>
	
</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>	
<script src="<?php echo base_url(); ?>assets/libs/jspdf.min.js"></script>	
<script src="<?php echo base_url(); ?>assets/js/jquery-qrcode-min.js"></script>	
<script src="<?php echo base_url(); ?>assets/js/jquery-barcode.min.js"></script>	
<script>
<?php $count = 0; ?>	
var settings = {
barWidth: 1,
barHeight: 50,
moduleSize: 1,
showHRI: true,
addQuietZone: true,
marginHRI: 15, 
bgColor: "#FFFFFF",
color: "#000000",
fontSize: 10,
output : 'canvas',
posX: 0,
posY: 0,
x : 10,
y : 20,	
};	
<?php		
foreach($user_data as $data){
$id = $data['Id'];
$n_id = $data['Id'];
$text  = "";
$text .= "Site Code :".$student['Site_Code'].'\n';
$text .= "Description :".$student['Description'].'\n';
$count++;	
?>
$('#qr_id<?php echo $data['Id']; ?>').qrcode({
    // render method: 'canvas', 'image' or 'div'
    render: 'canvas',

    // version range somewhere in 1 .. 40
    minVersion: 1,
    maxVersion: 40,

    // error correction level: 'L', 'M', 'Q' or 'H'
    ecLevel: 'L',

    // offset in pixel if drawn onto existing canvas
    left: 0,
    top: 0,

    // size in pixel
    size: 100,

    // code color or image element
    fill: '#000',

    // background color or image element, null for transparent background
    background: null,
    // content
    text: `<?php echo $text; ?>`,

    // corner radius relative to module width: 0.0 .. 0.5
    radius: 0.02,

    // quiet zone in modules
    quiet: 0,

    // modes
    // 0: normal
    // 1: label strip
    // 2: label box
    // 3: image strip
    // 4: image box
    mode: 0,
    mSize: 0.1,
    mPosX: 0.5,
    mPosY: 0.5,
    fontname: 'sans',
    fontcolor: '#000',

    image: null
});
$("#bcTarget_<?php echo $data['Id']; ?>").barcode("<?php echo $n_id; ?>", "upc",settings);  

<?php } ?>
	
//fOR8pRINT

	
function Save_all_page_as_Pdf(name){
	    
		html2canvas($('.pagecon')).then(function(canvas){
		//document.body.appendChild(canvas);
		var imgdata = canvas.toDataURL('image/png');	
		/*var imgdata_bar = html2canvas($('#bcTarget')).then(function(img){
			img.toDataURL('image/png');
		});	*/
		var doc = new jsPDF();
		//var pr = document.querySelector('#fOR8pRINT');
 		//console.log(imgdata_bar);
		//doc.fromHTML(pr,15,15);
		<?php if($count >= 3){ ?>	
		doc.addImage(imgdata, 'PNG' , 0, 10,210,210);
		<?php }else{ ?>
		doc.addImage(imgdata, 'PNG' , 0, 10, 300,50);
		<?php } ?>
		//doc.addImage(imgdata_bar, 'PNG' , 120, 80);
		/* Add new page
		doc.addPage();
		doc.text(20, 20, 'Visit CodexWorld.com');*/

		// Save the PDF
		doc.save(name+'.pdf');
	});
}
	
function Save_As_Pdf(name,classname = 'data' ){
		html2canvas($('.'+classname)).then(function(canvas){
		//document.body.appendChild(canvas);
		var imgdata = canvas.toDataURL('image/png');	
		/*var imgdata_bar = html2canvas($('#bcTarget')).then(function(img){
			img.toDataURL('image/png');
		});	*/
		var doc = new jsPDF();
		var pr = document.querySelector('#fOR8pRINT');
 		//console.log(imgdata_bar);
		doc.fromHTML(pr,15,15);
		doc.addImage(imgdata, 'PNG' , 120, 20);
		//doc.addImage(imgdata_bar, 'PNG' , 120, 80);
		/* Add new page
		doc.addPage();
		doc.text(20, 20, 'Visit CodexWorld.com');*/

		// Save the PDF
		doc.save(name+'.pdf');
	});
}
	
/*	
function Save_As_Pdf(name){
	alert('test');
}*/
	
function prin_card(){
	html2canvas($('.data')).then(function(canvas){
	var imgdata = canvas.toDataURL('image/png');	
	var restorpage = document.body.innerHTML;
	var printcontent = document.getElementById('fOR8pRINT').innerHTML;
	document.body.innerHTML = printcontent;
	document.body.appendChild(canvas);
	window.print();
	location.reload();
	});
}	
	
	
</script>
</html>
