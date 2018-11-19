$(document).ready(function(){
	$("#fp_cv_btn_btnlf").click(function() {
		document.getElementById('row').style.visibility = "hidden";
		document.getElementById('row').style.opacity = "0";
		document.getElementById('row').style.transition = "visibility 0s 1s, opacity 1s linear";
		setTimeout(function() {
			window.location.href ="/coverage/fiberstar-coverage";
		}, 1000);
	});
	$("#fp_cv_btn_btnlr").click(function() {
		document.getElementById('row').style.visibility = "hidden";
		document.getElementById('row').style.opacity = "0";
		document.getElementById('row').style.transition = "visibility 0s 1s, opacity 1s linear";
		setTimeout(function() {
			window.location.href ="/coverage/my-coverage";
		}, 1000);
	});
});