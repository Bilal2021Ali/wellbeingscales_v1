	const btn =  document.querySelector('.talk');

try{
	
	const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;

	const recognition = new SpeechRecognition();
	
	var start = document.getElementById("startmic");
	var dontknow = document.getElementById("dontUnderstant");
	var keyword = "";
	
	recognition.onstart = function(){
		playAudio(start);
		console.log("Yes Iam Active");
		$('.talk').addClass('Mic_On');
	};
	
	
	recognition.onresult = function(event){
		const current = event.resultIndex;
		const transcript = event.results[current][0].transcript;

		if(transcript.includes(keyword+'add members') || transcript.includes(keyword+'add a staff')){
			gotopage("index.php/schools/AddMembers");
		}else if(transcript.includes(keyword+'add a teacher')){
			gotopage("index.php/schools/AddMembers?last=Teacher");
		}else if(transcript.includes(keyword+'add a Student')){
			gotopage("index.php/schools/AddMembers?last=Student");
		}else if(transcript.includes('how are you')){
			say('i am fine , and you ?');	 
		}else if(transcript.includes('what is the name of today')){
			var days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
			var d = new Date();
			var dayName = days[d.getDay()];
			say("today is "+dayName);
	    }else if(transcript.includes('Mark all my notifications as read')){
			say('ok , i did it');
			setTimeout(function(){
				      $.ajax({
					  type: 'POST',
					  url: base_url+'index.php/Notifs/SetReaded',
					  });
					  $('#nots').html("");
			},1000);
		}else if(transcript.includes('show me the weather')){
		say('sorry i cant right now , i still waiting mohammad to teach me that ');	
		$('.wather').dropdown()
		}else{
			playAudio(dontUnderstant);
			setTimeout(function(){
				say('Sorry i dont have this skill right now');
			},1000);
		}
		console.log('You Said'+transcript);
		$('.talk').removeClass('Mic_On');
	};
	
	btn.addEventListener('click',() => {
		recognition.start();
	});
	


	function say(text){
			const speech = new SpeechSynthesisUtterance();
			speech.text = text;
			speech.volume = 1;
			speech.rate = 1;
			speech.pitch = 1;
			window.speechSynthesis.speak(speech);
			//alert('i am here');
	}
	
	function playAudio(audio) {
	  audio.play();
	}

	function gotopage(link){
		say('Ok, Here We Go !!');
		setTimeout(() => {
			location.href = base_url+link;
		}, 1000);
 	}
	
	
	
}catch(e){
	$('.talk').remove();
}


