$(document).ready(function() {
	$( ".from, .to" ).datepicker({
		 changeMonth: true,
		 changeYear: true,
		 showButtonPanel: true,
		 dateFormat: 'MM yy',           
		 onClose: function(dateText, inst) {
			 var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
			 var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();            
			 $(this).datepicker('setDate', new Date(year, month, 1));
		 },
		 beforeShow : function(input, inst) {
			 if ((datestr = $(this).val()).length > 0) {
				 year = datestr.substring(datestr.length-4, datestr.length);
				 month = jQuery.inArray(datestr.substring(0, datestr.length-5), $(this).datepicker('option', 'monthNames'));
				 $(this).datepicker('option', 'defaultDate', new Date(year, month, 1));
				 $(this).datepicker('setDate', new Date(year, month, 1));   
			 }
			 var other = this.id == "from" ? ".to" : ".from";
			 var option = this.id == "from" ? "maxDate" : "minDate";       
			 if ((selectedDate = $(other).val()).length > 0) {
				 year = selectedDate.substring(selectedDate.length-4, selectedDate.length);
				 month = jQuery.inArray(selectedDate.substring(0, selectedDate.length-5), $(this).datepicker('option', 'monthNames'));
				 $(this).datepicker( "option", option, new Date(year, month, 1));
			 }
		 }
	 });
	
	$("#ar_from_date").datepicker({showOn:'both',buttonImage:'images/calendar.png',buttonImageOnly:true,dateFormat:'dd/mm/yy',changeMonth:true,changeYear:true,numberOfMonths:1,onClose:function(selectedDate){$("#ar_to_date").datepicker("option","minDate",selectedDate);}});
	$("#ar_to_date").datepicker({showOn:'both',buttonImage:'images/calendar.png',buttonImageOnly:true,dateFormat:'dd/mm/yy',changeMonth:true,changeYear:true,numberOfMonths:1,onClose:function(selectedDate){$("#ar_from_date").datepicker("option","maxDate",selectedDate);}});
	
	$("#cb_from_date").datepicker({showOn:'both',buttonImage:'images/calendar.png',buttonImageOnly:true,dateFormat:'dd/mm/yy',changeMonth:true,changeYear:true,numberOfMonths:1,onClose:function(selectedDate){$("#cb_to_date").datepicker("option","minDate",selectedDate);}});
	$("#cb_to_date").datepicker({showOn:'both',buttonImage:'images/calendar.png',buttonImageOnly:true,dateFormat:'dd/mm/yy',changeMonth:true,changeYear:true,numberOfMonths:1,onClose:function(selectedDate){$("#cb_from_date").datepicker("option","maxDate",selectedDate);}});	
	 
	 $("#btnShow").click(function(){
		 if($(".from").val().length == 0 || $(".to").val().length == 0){
			 alert('All fields are required');
		 }else{
			 alert('Selected Month Range :'+ $(".from").val() + ' to ' + $(".to").val());
		 }
	 });
	 
	 $( "#type_dp" ).on("change", "#type", function() {
	 	if($('#type').val() == '') { data = ''; }
		if($('#type').val() == 1) { data = 'Eg. Indica'; } 
		if($('#type').val() == 2) { data = 'Eg. 2-4'; } 
		$('#categ').html( data ); 
	});
	
	/*function() { $('#pwd').show(); $('#pwd-mask').hide(); },
	
	$(".pwd").on('hover', function() { alert('mouseover');
		$('#pwd').show(); $('#pwd-mask').hide();
	});*/
	
	/*$('.pwd').hover(function(){
        $('#pwd').show();
    }, function() {
        $('#mask-pwd').hide();
    });*/
	
	$('.pwd').on({
		'mouseenter':function(){ //alert('d');
			$('#pwd').fadeIn();
		},'mouseleave':function(){
			$('#mask-pwd').fadeOut();
		}
	});
	
});