$(document).ready(function() {
	// Ticker
	$('#fade').list_ticker({
		speed:4000,
		effect:'fade'
	});
	
	// Facebox
	$('a[rel*=facebox]').facebox({
		loadingImage : 'images/loading.gif',
		closeImage   : 'images/btn_close.gif'
	});
	
	// Slider Images
	$(".sliderImages").jCarouselLite({
		btnNext: ".next",
		btnPrev: ".prev",
		visible: 1,
		easing: "easeInOutQuart",
		auto: 3000,
		speed: 1000
	});
	
	// Datepicker - Fixed Departured (Search Tracker)
	$("#datepicker1").datepicker({ 
		showOn: "button",
		buttonImage: "images/calendar.png",
		dateFormat: "dd-mm-yy",
		buttonImageOnly: true,
		changeYear:true, 
		changeMonth:true, 
		minDate: 0,
		beforeShowDay: function (d) {
			var dmy = "";
            dmy += ("00" + d.getDate()).slice(-2) + "-";
            dmy += ("00" + (d.getMonth() + 1)).slice(-2) + "-";
            dmy += d.getFullYear(); 
            if ($.inArray(dmy, availableDates) != -1) { 
            	return [true, "", "Available"];
            } else { 
            	return [false, "", "unAvailable"];
            }
		}
	});
	
	// Datepicker - Tour Packages (Search Tracker)
    $( "#datepicker2" ).datepicker({
		showOn: "button",
		buttonImage: "images/calendar.png",
		dateFormat: "dd-mm-yy",
		buttonImageOnly: true,
		changeYear:true, 
		changeMonth:true, 
		minDate: 1
	});
	
	$("#ar_from_date").datepicker({
		showOn: 'both',
		buttonImage: 'images/calendared.png',
		buttonImageOnly: true,
		dateFormat: 'dd/mm/yy',
		changeMonth: true,
		changeYear: true,
		numberOfMonths: 1,
		onClose:function(selectedDate){
			$("#ar_to_date").datepicker("option","minDate",selectedDate);																																								   		}																																																	
	});
	
	$("#ar_to_date").datepicker({
		showOn: 'both',
		buttonImage: 'images/calendared.png',
		buttonImageOnly: true,
		dateFormat: 'dd/mm/yy',
		changeMonth: true,
		changeYear: true,
		numberOfMonths: 1,
		onClose:function(selectedDate){
			$("#ar_from_date").datepicker("option","maxDate",selectedDate);
		}
	});
	
});