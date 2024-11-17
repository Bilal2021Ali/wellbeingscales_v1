<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
<meta content="Themesbrand" name="author" />
<link rel="icon" type="image/png" href="<?php echo base_url();?>assets/images/fav_icon.png">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="icon" href="assets/images/favicon.ico" type="image/x-icon">
<!-- Plugins Core Css -->
<link rel="preconnect" href="https:/fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Almarai:wght@700&display=swap" rel="stylesheet">
<link href="<?php echo base_url();?>assets/css/icons.css" rel="stylesheet">
<link href="<?php echo base_url();?>assets/css/bootstrap.css" rel="stylesheet">
<link href="<?php echo base_url();?>assets/css/app-rtl.css" rel="stylesheet">
<link href="<?php echo base_url();?>assets/css/app.min.css" id="app-rtl-style" rel="stylesheet">
<script src="<?php echo base_url();?>assets/libs/jquery/jquery.min.js"></script>
<style>
 .app-search span{
	  top: 0px;
 } 
.badge {
border-radius: 14px;
}

*{
	font-family: 'Almarai', sans-serif;
}

.InfosCards h4,.InfosCards p{
  color: #fff;
} 
.InfosCards .card-body{
  border-radius: 5px;
}
.card{
border: 1px solid #0eacd8;
}

.menu-title{
font-size : 20px;
}

.notStatic{
border : 0px;
}


.sidebar li img{
 width: 28px;
}

.sidebar li span{
 font-size: 17px;
 margin-left : 13px;
}

.metismenu li {
display: block;
width: 100%;
margin: 2px auto;
}

.InfosCards p.mb-0:not(.mt-3){
	font-weight: bolder;
}    

.table th{
	font-size: 15px;
}

#sidebar-menu ul li a {
	display: block;
	padding: .6rem 1.1rem;
	color: #55affe;
	position: relative;
	font-size: 15px;
	font-weight: 500;
	-webkit-transition: all .4s;
	transition: all .4s;
	margin: 0 10px;
	border-radius: 3px;
}     

.main-content{
	margin-left : 0px !important;
}

*:not(input){
	text-transform: capitalize;
}

#page-topbar{
	width: 100% !important;
}


#sidebar-menu .has-arrow:after {
	float: left !important;
}

</style>       
<title> Not Found </title>
</head>
	
<body class="authentication-bg">
        <div class="my-5 pt-sm-5">
            <div class="container">

                <div class="row">
                    <div class="col-md-12">
                        <div class="text-center">
                            <div>
                                <div class="row justify-content-center">
                                    <div class="col-sm-4">
                                        <div class="error-img">
							<img src="<?php echo base_url(); ?>assets/images/db_error.svg" alt=""
								 class="img-fluid mx-auto d-block">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <h4 class="text-uppercase mt-4 ">500</h4>
                            <p class="text-muted"> Sorry, we have a problem in processing this request. </p>
                            <div class="mt-5">
					<a class="btn btn-primary waves-effect waves-light" onClick="reloade()">
						Retry <i class="uil uil-redo"></i>
					</a>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
</body>
<script>
function reloade(){
	location.reload();
}	
</script>	
</html>