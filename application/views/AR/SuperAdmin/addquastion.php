<!doctype html>
<html>
<head>
<meta charset="utf-8">
</head>
<style>
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
		transition: 0.2s all;
	}
	
	.floating_action_btn:hover {
		transform: rotateZ(45deg);
	}
	
.addchoices {
	display: inline-block;
    position: absolute !important;
    top: 5px;
    right: 0px;
	height: 30px;
    width: 30px;
    border-radius: 100%;
    border: 0px;
	visibility: hidden;
}
	
.addchoices.delete {
	right: 40px;
	visibility: hidden;
}	
	
	
[contenteditable="true"]:active,
[contenteditable="true"]:focus{
  border:none;
  outline:none;
  caret-color: #5b73e8;
}	
	
.Ready .delete , .Ready .addchoices{
	visibility: visible;
}
	
.choices {
	margin-left: 30px;
	border-left: 1px solid #495072;
	padding-left: 5px;
}	
	
.section_question h3 {
	padding-left: 10px;
	border-bottom: 1px solid transparent;
}	
	/*
.section_question h3:focus {
	padding-bottom: 10px;
	border-bottom: 1px solid #495072;
}	*/

</style>
<body>
<script>
	var qustions = [];
</script>	
<div class="main-content">
	<div class="page-content">
		<button type="button" class="floating_action_btn waves-effect waves-light" onClick="addquestion();">
			<i class="uil uil-plus"></i>
		</button>
		<div class="row">
			<div class="col-lg-12">
				<div class="card" style="border: 0px; ">
					<div class="card-body">
						<h1 onKeyDown="test();"></h1>
						<div class="loader"></div>
						<div class="show row"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</body>
	
<script>
	var set_id = <?php  echo $set_id;  ?>;
	function addquestion(){
		var rand_id = Math.random(1000,9999);
		var realId = addquestionToDb(rand_id);
		questionsFeedBack()
	}
	
	function showquestions(){
		// show
		$('.show').html('');
		qustions.map(function(question , index){
			$('.show').append(question.html + '<span index="' + index + '" class="index"></span></div>');
		});
		listener();
		listener_choices();
	}
	
	function questionsFeedBack(){
		qustions  = $.parseJSON($.ajax({
	    type: 'POST',
        url:  '<?php echo base_url() ?>AR/Dashboard/question',
        dataType: "json", 
		data: {
		  requestFor : 'All_questions',
		  set_id     : set_id,
		},
        async: false
		}).responseText);
		qustions.length <= 0 ?  $(".show").html('Start Add questions from the button ') : showquestions();
		console.log(qustions);
	}

	function listener(){
		var i;
		for (i = 1; i <= qustions.length; i++) {
			//console.log('Title' + i);
			document.getElementById("Title" + i).addEventListener("input", function() {
				var title_en = this.innerHTML;
				console.log(title_en);
				const real_d = $(this).parent().attr('realKey');
				UpdateTitle(real_d,title_en,'تم تغييره');
			}, false);
		}
	}
	
	function listener_choices(){
		var i;
		for (i = 0; i < qustions.length ; i++) {
				var h;
				console.log(' --------- ' + i);
				for(h = 0 ; h < qustions[i].choices.length ; h++){
					console.log("choice_" + (i+1) + "_" + (h+1));
					document.getElementById("choice_" + (i+1) + "_" + (h+1)).addEventListener("input", function() {
						var title_en = this.innerHTML;
						const real_d = $(this).attr('realKey');
						console.log(title_en);
						console.log(real_d);
						Update_choice(real_d,title_en,'تم تغييره');
					}, false);
				}
		}
	}
	
	function addquestionToDb(rands_id){
		var respons = $.parseJSON($.ajax({
	    type: 'POST',
        url:  '<?php echo base_url() ?>AR/Dashboard/question',
        dataType: "json", 
		data: {
		  requestFor : 'new',
		  for_set    : set_id,
		  rand       : rands_id,
		},
        async: false
		}).responseText);
		if(respons.status == "ok"){
			return respons.Id;
		}	
	}
	
	function UpdateTitle(realid,titleEn,titleAR){
	 $.ajax({
		 type: 'POST',
		 url: '<?php echo base_url(); ?>AR/Dashboard/question',
		 data: {
		  requestFor : 'Update_Title',
		  title_en   : titleEn,
		  title_ar   : titleAR,
		  id         : realid,
		 },
		 success: function (data) {
			 // set loader to checked
		 },
		 ajaxError: function(){
			 // 
		 }
	  });          
	}
	
	function Update_choice(realid,titleEn,titleAR){
	 $.ajax({
		 type: 'POST',
		 url: '<?php echo base_url(); ?>AR/Dashboard/addChoice',
		 data: {
		  requestFor : 'Update',
		  title_en   : titleEn,
		  title_ar   : titleAR,
		  id         : realid,
		 },
		 success: function (data) {
			 // set loader to checked
		 },
		 ajaxError: function(){
			 // 
		 }
	  });          
	}
	
	questionsFeedBack();
		
	$(document).on("click", ".section_question .delete", function() {
			var id = $(this).parent().attr('realkey');
			var index = $(this).parent().children('.index').attr('index');
			$.ajax({
			 type: 'POST',
			 url: '<?php echo base_url(); ?>AR/Dashboard/question',
			 data: {
			  requestFor : 'Delete',
			  id : id,
			 },
			 success: function (data) {
				 // set loader to checked
				 if(data.status == "ok"){
					console.log(qustions); 
				    qustions.splice(index, 1);
					console.log(qustions); 
					$('div[realkey="' + id + '"]').remove();
					questionsFeedBack();
				 }
			 },
			 ajaxError: function(){
				 // 
			 }
		  });     
	});
	
	$(document).on("click", ".section_question .delete_choise", function() {
			var id = $(this).attr('realkey');
			var index = $(this).parent().parent().parent().children('.index').attr('index');
			var choice_index = $(this).attr('choice_index');
			console.log(' Id is ' + id);
			console.log(' index is ' + index);
			console.log(' index of choice ' + choice_index);
			console.log(qustions[index].choices[(choice_index-1)]);
			$.ajax({
			 type: 'POST',
			 url: '<?php echo base_url(); ?>AR/Dashboard/addChoice',
			 data: {
			  requestFor : 'Delete',
			  id : id,
			 },
			 success: function (data) {
				 // set loader to checked
				 if(data.status == "ok"){
					console.log(qustions); 
				    qustions.splice(index, 1);
					console.log(qustions); 
					$('#choiceLa_'+ (Number(index)+1) +'_' + choice_index + '').parent().remove();
					questionsFeedBack();
				 }
			 },
			 ajaxError: function(){
				 // 
			 }
		  });   
	});
	
	$(document).on("click", ".section_question .choiceBtn", function() {
			var id = $(this).parent().attr('realkey');
			var index = $(this).parent().children('.index').attr('index');
			$.ajax({
			 type: 'POST',
			 url: '<?php echo base_url(); ?>AR/Dashboard/addChoice',
			 data: {
			  requestFor : 'new',
			  q_id : id,
			 },
			 success: function (data) {
				 // set loader to checked
				 if(data.status == "ok"){
					questionsFeedBack();
				 }
			 },
			 ajaxError: function(){
				 // 
			 }
		  });  
	});
	
</script>	
	
</html>