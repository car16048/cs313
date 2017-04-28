function ShowClicked() {
	alert('Clicked!');
}

function ChangeColor1() {
	var div1 = document.getElementById('div1');
	var txt1 = document.getElementById('txt1');
	
	div1.style.backgroundColor = txt1.value;
}

function ChangeColor2() {
	$('#div2').css('background-color', $('#txt2').val());
}

function Fade3() {
	var d3 = $('#div3');
	if (d3.css('display') == 'none') {
		d3.fadeIn(2000);
	} else {
		d3.fadeOut(2000);
	}
}