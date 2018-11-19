//Services
window.onload = function () {
	var acc = document.getElementsByClassName("accordion");
	var i;

	for (i = 0; i < acc.length; i++) {
	  acc[i].addEventListener("click", function() {
	    this.classList.toggle("active");
	    var panel = this.nextElementSibling;
	    if (panel.style.maxHeight){
	      panel.style.maxHeight = null;
	    } else {
	      panel.style.maxHeight = panel.scrollHeight + "px";
	    } 
	  });
	}
}

function rightsided(button) {
   if ($(button).hasClass('fa-chevron-up')) {
   		$(button).addClass('fa-chevron-down').removeClass('fa-chevron-up');
    }
    else {
    	$(button).addClass('fa-chevron-up').removeClass('fa-chevron-down');
    }
}