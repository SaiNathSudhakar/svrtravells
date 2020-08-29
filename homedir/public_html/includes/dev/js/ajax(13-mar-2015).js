$(document).ready(function() {
	
	///////////////////////// SEARCH TRACKER ///////////////////////////////					   
	// TAB CHANGE
	$( "#mdiv3, #mdiv4" ).click(function(){
		var cat = $(this).data('num'); 
		$( ".category" ).val( cat );
	});
	
	$("#mdiv2").click(function(){ //alert('hi');
		//var a = $(this).val();
		$( "#div2" ).html( "<div style='vertical-align:middle;' class='mt20 ml30'><img src=images/loading.gif border=0><b>Loading...</b></div>" );
		$.post( "ajax.php", { search_bus_tracker : 1 })
		.done(function( data ){ //alert(data);
			if( data != '' ) $( "#div2" ).html( data );
	  	});
	});
	
	// FROM LOCATION CHANGE - FIXED DEPARTURES
	$( "#fd_from_dropdown" ).on("change", "#fdfromloc", function() { 
		if($('#fdfromloc').val() != '') 
			$( "#fd_to_dropdown" ).html( "<div style='vertical-align:middle;' class='ml30'><img src=images/loading.gif border=0><b>Loading...</b></div>" );	
		$('select[id=fdtoloc]').html( '<option value="">--- Select Arrival City ---</option>' );
		$('#datepicker1').val('');
		$( "#seat_avail_div" ).fadeOut('slow');
		$.post( "ajax.php", { from: $('#fdfromloc').val(), fares_cat: $('.category').val(), search_tracker : 1 })
		.done(function( data ) { 
			if( data != '' && $('#fdfromloc').val() != '') $( "#fd_to_dropdown" ).html( data );
	  	});
	});
	
	// FROM LOCATION CHANGE - TOUR PACKAGES
	$( "#hp_from_dropdown" ).on("change", "#hpfromloc", function() { 
		if($('#hpfromloc').val() != '') $( "#hp_to_dropdown" ).html( "<div style='vertical-align:middle;' class='ml30'><img src=images/loading.gif border=0><b> Loading...</b></div>" );	
		$('select[id=hptoloc]').html( '<option value="">--- Select Arrival City ---</option>' );
		$('#datepicker2').val('');
		$( "#seat_avail_div" ).fadeOut('slow');
		$.post( "ajax.php", { from: $('#hpfromloc').val(), fares_cat: $('.category').val(), search_tracker : 1 })
		.done(function( data ) { 
			if( data != '' && $('#hpfromloc').val() != '') $( "#hp_to_dropdown" ).html( data );
	  	});
	});
	
	// TO LOCATION CHANGE - FIXED DEPARTURES
	$('#fd_to_dropdown').change("fdtoloc", function(){ 
		availableDates = [];
		$('#datepicker1').val('');
		$.post( 'ajax.php', { to: $('#fdtoloc').val(), avail_tracker : 1 })
		 .done(function (date) { //alert(date);
			var result = date.trim();
			availableDates = result.split(",");
			$("#datepicker1").datepicker("refresh");
		 });
	});
	
	///////////////////////// TOUR PACKAGE BOOKING ///////////////////////////////
	
	$('input:radio[name=room_type]').change(function(){
		$( '#clear' ).trigger("keyup");											 
		$( '#pax_div' ).html( '<select name="pax" id="pax" class="list"><option value="">Select</option></select>' );
		$( 'select[id=vehicle]' ).val( 0 );
		$( '#min_pax' ).val( 0 );
	});
	
	$( "#vehicle_div" ).on("change", "#vehicle", function() {
		if(!$('input:radio[name=room_type]:checked').val()) { alert('Please Select Hotel Type'); $('select[id=vehicle]').val( 0 ); return false; }																																					
		if($('#vehicle').val() != '') $( "#pax_div" ).html( "<img src=images/loading.gif border=0><b> Loading...</b>" );
		$( '#clear' ).trigger("keyup");
		$.post( "ajax.php", { loc: $('#loc').val(), room_type: $('input:radio[name=room_type]:checked').val(), vehicle: $('#vehicle').val(), get_pax : 1 })
		.done(function( data ) { 
		  if( data != '' ) {
			  result = data.split('#');
			  $( "#pax_div" ).html( result[0] );
			  $( "#min_pax" ).val( result[1].trim() );
		  }
	  	});
	});
	
	$( "#pax_div" ).on("change", "#pax", function() { 
		if($('#pax').val() != '') $( "#adults_occ_div" ).html( "<img src=images/loading.gif border=0><b> Loading...</b>" );	
		if($('#pax').val() == '') $( '#clear' ).trigger("keyup"); 
		$('#adults_occ_fare, #adults_occ_total, #child_bed_fare, #child_bed_total, #child_nobed_fare, #child_nobed_total').val('');
		
		$.post( "ajax.php", { loc: $('#loc').val(), room_type: $('input:radio[name=room_type]:checked').val(), vehicle: $('#vehicle').val(), pax: $('#pax').val(), min_pax: $('#min_pax').val(), nights: $('#nights').val(), days: $('#days').val(), get_fares : 1 })
		.done(function( data ) { 
			if( data != '' ) { 
			  result = data.split('#');
			  $( "#tax" ).val( result[0].trim() );
			  $( "#totalfare" ).val( result[1].trim() );
			  $( "#adults_occ_div" ).html( result[2].trim() );
			  $( "#child_bed_div" ).html( result[3].trim() );
			  $( "#child_nobed_div" ).html( result[4].trim() );
		  }
	  	});
	});
	
	$('#room_occ_check').on('click', function(){
		if ($(this).is(':checked')) { 
			$( '#room_occ_div_2' ).fadeIn(); 
		} else { 
			$( '#room_occ_div_2' ).fadeOut(); 
			$( 'select[id=adults_occ]' ).val( 0 );
			$( '#adults_occ_fare, #adults_occ_total' ).val( '' );
			$( '#adults_occ' ).trigger("change");
		}
	});
	
	$('#child_bed_check').on('click', function(){
		if ($(this).is(':checked')) { 
			$( '#child_bed_div_2' ).fadeIn(); 
		} else { 
			$( '#child_bed_div_2' ).fadeOut(); 
			$( 'select[id=child_bed]' ).val( 0 );
			$( '#child_bed_fare, #child_bed_total' ).val( '' );
			$( '#child_bed' ).trigger("change");
		}
	});
	
	$('#child_nobed_check').on('click', function(){
		if ($(this).is(':checked')) { 
			$( '#child_nobed_div_2' ).fadeIn(); 
		} else { 
			$( '#child_nobed_div_2' ).fadeOut(); 
			$( 'select[id=child_nobed]' ).val( 0 );
			$( '#child_nobed_fare, #child_nobed_total' ).val( '' );
			$( '#child_nobed' ).trigger("change");
		}
	});
	
	$( "#adults_occ_div" ).on("change", "#adults_occ", function() {
		if((Number($('#adults_occ').val()) + Number($('#child_bed').val()) + Number($('#child_nobed').val())) > $('#pax').val()) { 
			alert('Pax exceed Number of Pax '); $(this).val($.data(this, 'current')); return false; 
		} $.data(this, 'current', $(this).val());
		$( "#child_bed, #child_bed_fare, #child_bed_total, #child_nobed, #child_nobed_fare, #child_nobed_total" ).val( '' );														
		$.post( "ajax.php", { loc: $('#loc').val(), room_type: $('input:radio[name=room_type]:checked').val(), vehicle: $('#vehicle').val(), pax: $('#pax').val(), min_pax: $('#min_pax').val(), nights: $('#nights').val(), days: $('#days').val(), new_pax: $('#adults_occ').val(), get_fares: 2 })
		.done(function( data ) { 
			if( data != '' ) { 
			  result = data.split('#');
			  $( "#tax" ).val( result[0].trim() );
			  $( "#totalfare" ).val( result[1].trim() );
			  $( "#adults_occ_fare" ).val( result[2] );
			  $( "#adults_occ_total" ).val( result[3] );
			  if( result[3] == 0 ) $( "#adults_occ_fare, #adults_occ_total" ).val( '' );
		  	}
	  	});
	});
	
	$( "#child_bed_div" ).on("change", "#child_bed", function() { 
		if((Number($('#adults_occ').val()) + Number($('#child_bed').val()) + Number($('#child_nobed').val())) > $('#pax').val()) { 
			alert('Pax exceed Number of Pax '); $(this).val($.data(this, 'current')); return false; 
		} $.data(this, 'current', $(this).val());
		
		if((Number($('#child_bed').val()) + Number($('#child_nobed').val())) == $('#pax').val()) { 
			alert('Please select atleast on Adult'); $(this).val($.data(this, 'adult')); return false; 
		} $.data(this, 'adult', $(this).val());
		
		$( "#child_nobed, #child_nobed_fare, #child_nobed_total" ).val( '' );													  
		$.post( "ajax.php", { loc: $('#loc').val(), room_type: $('input:radio[name=room_type]:checked').val(), vehicle: $('#vehicle').val(), pax: $('#pax').val(), min_pax: $('#min_pax').val(), nights: $('#nights').val(), days: $('#days').val(), new_pax: $('#adults_occ').val(), childbed_pax: $('#child_bed').val(), childnobed_pax: $('#child_nobed').val(), get_fares: 3 })
		.done(function( data ) {
			if( data != '' ) { 
			  result = data.split('#');
			  $( "#tax" ).val( result[0].trim() );
			  $( "#totalfare" ).val( result[1].trim() );
			  $( "#child_bed_fare" ).val( result[2] );
			  $( "#child_bed_total" ).val( result[3] );
			  if( result[3] == 0 ) $( "#child_bed_fare, #child_bed_total" ).val( '' );			  
		  	}
	  	});													
	});
	
	$( "#child_nobed_div" ).on("change", "#child_nobed", function() {
		if((Number($('#adults_occ').val()) + Number($('#child_bed').val()) + Number($('#child_nobed').val())) > $('#pax').val()) { 
			alert('Pax exceed Number of Pax '); $(this).val($.data(this, 'current')); return false; 
		} $.data(this, 'current', $(this).val());
		
		if((Number($('#child_bed').val()) + Number($('#child_nobed').val())) == $('#pax').val()) { 
			alert('Please select atleast on Adult'); $(this).val($.data(this, 'adult')); return false; 
		} $.data(this, 'adult', $(this).val());
		
		$.post( "ajax.php", { loc: $('#loc').val(), room_type: $('input:radio[name=room_type]:checked').val(), vehicle: $('#vehicle').val(), pax: $('#pax').val(), min_pax: $('#min_pax').val(), nights: $('#nights').val(), days: $('#days').val(), new_pax: $('#adults_occ').val(), childbed_pax: $('#child_bed').val(), childnobed_pax: $('#child_nobed').val(), get_fares: 4 })
		.done(function( data ) { 
			if( data != '' ) { 
			  result = data.split('#');
			  $( "#tax" ).val( result[0].trim() );
			  $( "#totalfare" ).val( result[1].trim() );
			  $( "#child_nobed_fare" ).val( result[2] );
			  $( "#child_nobed_total" ).val( result[3] );
			  if( result[3] == 0 ) $( "#child_nobed_fare, #child_nobed_total" ).val( '' );
		  	}
	  	});															
	});
	
	$('#clear').keyup(function(){
		$( '#tax, #totalfare' ).val('');
		
		$( '#adults_occ_div' ).html( '<select name="adults_occ" id="adults_occ"><option value="">Select</option></select>' );
		$( '#adults_occ_fare, #adults_occ_total' ).val('');
		$( '#room_occ_check' ).prop('checked', false); $('#room_occ_div_2').hide();
		
		$( '#child_bed_div' ).html( '<select name="child_bed" id="child_bed"><option value="">Select</option></select>' );
		$( '#child_bed_fare, #child_bed_total' ).val('');
		$( '#child_bed_check' ).prop('checked', false); $('#child_bed_div_2').hide();
		
		$( '#child_nobed_div' ).html( '<select name="child_nobed" id="child_nobed"><option value="">Select</option></select>' );
		$( '#child_nobed_fare, #child_nobed_total' ).val('');
		$( '#child_nobed_check' ).prop('checked', false); $('#child_nobed_div_2').hide();
	});
	
	$('input:radio[name=pickup]').change(function(){ 
		sel = $("input:radio[name='pickup']:checked").val();
		$('#place, #place_detail, #time').val('');
		if(sel == 1) { 
			$('#place_caption').html('Airport');
			$('#time_caption').html('Expected Arrival Time');
			$('#place_detail_caption').html('Flight No');
		}
		if(sel == 2) { 
			$('#place_caption').html('Railway Station');
			$('#time_caption').html('Expected Arrival Time');
			$('#place_detail_caption').html('Train No');
		}
		if(sel == 3) { 
			$('#place_caption').html('Address');
			$('#time_caption').html('Pickup Time');
			$('#place_detail_caption').html('Street No');
		}
	});
		
	$('input:radio[name=drop]').change(function(){
        sel = $("input:radio[name='drop']:checked").val();
		$('#place1, #place_detail1, #time1').val('');
		if(sel == 1) { 
			$('#place1_caption').html('Airport');
			$('#time1_caption').html('Departure Time');
			$('#place_detail1_caption').html('Flight No');
		}
		if(sel == 2) { 
			$('#place1_caption').html('Railway Station');
			$('#time1_caption').html('Departure Time');
			$('#place_detail1_caption').html('Train No');
		}
		if(sel == 3) { 
			$('#place1_caption').html('Address');
			$('#time1_caption').html('Drop Time');
			$('#place_detail1_caption').html('Street No');
		}
	});
	
	$('#pickup_check').on('click', function(){
		if ($(this).is(':checked')) { 
			$(".pickup").attr("disabled", "disabled");
			$("#place, #place_detail, #time").val('');
		} else {
			$(".pickup").removeAttr("disabled");
		}
	});
	
	$('#drop_check').on('click', function(){
		if ($(this).is(':checked')) { 
			pickup_radio = $("input:radio[name='pickup']:checked").val();
			$("input[name=drop][value="+pickup_radio+"]").attr('checked','checked');
			$("input:radio[name='drop']").trigger("change");
			$("#place1").val($("#place").val());
			$("#place_detail1").val($("#place_detail").val());
			$("#time1").val($("#time").val());
		} else {
			$("input[name=drop][value=1]").attr('checked','checked');
			$("input:radio[name='drop']").trigger("change");
			$("#place1, #place_detail1, #time1").val('');
		}
	});
	
	///////////////////////// FIXED DEPARTURE BOOKING ///////////////////////////////
	
	$('.qty').keyup(function() { 
		var totalsum = 0;
		var j = $("input:radio[name='ac_radio']:checked").val();
		var seats = $('#seatsavailable'+j).val();
		var totqty = totadult = totchild = 0;
		if(!j) { alert('Please Select AC / Non-AC'); $(this).val($.data(this, 'acnonac')); $('#ac0').focus(); return false; }
		$.data(this, 'acnonac', $(this).val()); 
		$('.qty').each(function(i) { 
			if(($(this).val()%$('#multiple'+i).val()) != 0) { 
				alert('Please enter multiples of ' + $('#multiple'+i).val()); 
				$(this).val($.data(this, 'multple')); return false; 
			} $.data(this, 'multple', $(this).val());
			k = $('#fare'+i+j).val();
			sum = Number($(this).val())*k;
			$('#calc_amount'+i).html(sum);
			$('#fare_person'+i).html(k+' = ');
			totalsum += sum;
			totqty += Number($(this).val());
			if($('#adultchild'+i).val() == 1) totadult += Number($(this).val());
			if($('#adultchild'+i).val() == 2) totchild += Number($(this).val());
		});
		if(totqty > seats) { alert('Total No. of Persons exceed Total Seats'); $(this).val($.data(this, 'seats')); return false; } 
		$.data(this, 'seats', $(this).val());
		$('#total_amount').html(totalsum);
		$('#totqty, #maxSeatAllowed, #NoSeatsSel').val(totqty);
		$('#totamount').val(totalsum);
		$('#totadult').val(totadult);
		$('#totchild').val(totchild);
	});
	
	$('input:radio[name=ac_radio]').change(function(){
		$('.qty').val(0);
		$('#bustype').val($('input:radio[name=ac_radio]:checked').attr('width'));
		$('.qty').trigger("keyup");												
	});
	
	$('#check_availability').on('click', function(){
		if($('#totqty').val() == 0){ alert('Please select atleast one Package'); return false; }
		if($('#totadult').val() == 0){ alert('Please select atleast one Adult'); return false; }
		//alert(parseFloat($('#totamount').val())+' > '+parseFloat($('#ag_dp').val()));
		if($('#ag_dp').data('num') && (parseFloat($('#totamount').val()) > parseFloat($('#ag_dp').val()))) { 
			alert("Your Balance Amount ("+ $('#ag_dp').val() +") is less than total fare ("+ $('#totamount').val() +")\n Please topup your account.");
			return false;
		}
		$('#bus_layout').fadeIn('slow'); $('.qty').attr('readonly', true); 
		//$('.ac_radio').attr('disabled', true);
		$('input:radio[name=ac_radio]:not(:checked)').attr('disabled', true);
		$('html, body').animate({ scrollTop: $('#bus_layout').offset().top}, 2000);
	});
	
	$('#fixed_booking_reset').on('click', function(){ 
		//$('.qty').trigger("keyup");
		currentOptedSeats = 0;
		if($('#totbustype').val() != 1) $('input:radio[name=ac_radio]').prop('checked', false);
		$('input:radio[name=ac_radio]').removeAttr('disabled');
		$('.qty').removeAttr('readonly');									   
		$('.qty, #total_amount').val(0); 
		$('.fare_person').html('0 =');
		$('.calc_amount').html('0');
		$('#optedSeatNos, #maxSeatAllowed, #NoSeatsSel').val('');
		
		$('.TB_selctd').attr('class', 'TB_avbl');
		$('#bus_layout').fadeOut('slow');
		
		$('html, body').animate({ scrollTop: $('#mid_position').offset().top}, 2000);
	});
	
	///////////////////////// CANCEL BUS BOOKING ///////////////////////////////
	
	$('#sumbit_cancel_ticket').on('click', function(){ 
		if($('#ticket').val() == ''){ alert('Please enter Ticket Number'); $('#ticket').focus(); return false; }
		if($('#email').val() == ''){ alert('Please enter email ID'); $('#email').focus(); return false; }
		if(!validEmail($('#email').val())){ alert('Please enter valid email ID'); $('#email').focus(); return false; }
		$.post( "ajax.php", { email: $('#email').val(), ticket: $('#ticket').val(), cancel_ticket : 1 })
		.done(function( data ) { //alert(data);
			var data = data.trim();
			var result = data.split('#');
			if(result[0] >= 1){ //alert(result[0]);
			  if(result[1] == 2) {
				$('#cancel_booking_1').hide();
				$('#cancel_booking_2').show();
				//var info = result[2].split('|'); alert(print_r(info));
				//var route = info[4]+' to '+info[5]; //alert(route);
				$('#orderid').val(result[2]);
				$('#canch').attr('href', 'CancelBusBooking.php?tin='+result[8]);
				$('#route').html(result[4]+' to '+result[5]);
				$('#travels').html(result[6]);
				$('#journey_date').html(result[3]);
				$('#amount').html('Rs. '+result[7]);
			  } else if(result[1] == 4) {
				  alert('Already Cancelled');
			  }
			} else if(result[0] == 0) { //alert(result[0]);
				$('#cancel_booking_2').hide();
				$('#txtErrMsg').show();
				$('#txtErrMsg').fadeOut(8000); 
			} else {
				$('#cancel_booking_2').hide();
				if(result[0] == -1)
					$('#agErrMsg').show().html('Please Login as agent to Cancel This Ticket');
				if(result[0] == -2)
					$('#agErrMsg').show().html('This ticket was not booked by Agent');
				if(result[0] == -3)
					$('#agErrMsg').show().html('This ticket was booked by another agent');
				$('#agErrMsg').fadeOut(8000); 
			}
		});
	});
	
	///////////////////////// TOUR FARE BOOKING ///////////////////////////////
	
	$('#sumbit_contact').on('click', function(){ 
		if($('#email').val() == ''){ alert('Please enter email ID'); $('#email').focus(); return false; }
		if(!validEmail($('#email').val())){ alert('Please enter valid email ID'); $('#email').focus(); return false; }
		$('.regdata').val('');
		$.post( "ajax.php", { email: $('#email').val(), tour_email : 1 })
		.done(function( data ) { //alert(data);
			var data = data.trim();
			var result = data.split('#');
			if(result[0] == 0){ 
				$('#emaill').val($('#email').val());
				$('#customer').val('');
				$('.pwd').show();
				$('.reg_row').fadeIn('slow');
				$('html, body').animate({ scrollTop: $('#registration_table').offset().top}, 2000);
				
			} else if(result[0] != 0 || result[0] != '') {
					
				$('a.login-window').trigger('click');
				$('#txtSubmit').on('click', function() { 
					$('#txtErrMsg').hide(); 
					if($('#txtPassword').val() != ''){
						var password = $('#txtPassword').val();
						if(result[1] == md5(password)){
							$('#mask, .login-popup').fadeOut(300 , function() { $('#mask').remove(); }); 
							$.post( "ajax.php", { info: result[2], tour_session : 1 })
							.done(function( data ) { 
								var info = result[2].split('|');
								$('#customer').val(info[1]);
								$('#title').val(info[2]);
								$('#fname').val(info[3]);
								$('#address').val(info[6]);
								$('#mobile').val(info[7]);
								$('#city').val(info[8]);
								if(info[8] != '') $('#city').attr('readonly', true); else $('#city').attr('class', 'textbox');
								$('#state').val(info[9]);
								if(info[9] != '') $('#state').attr('disabled', true); else $('#state').attr('class', 'textbox');
								$('#country').val(info[10]);
								if(info[10] != '') $('#country').attr('readonly', true); else $('#country').attr('class', 'textbox');
								$('.pwd').hide(); $('.nopwd').show();
								$('#emaill').val($('#email').val());
								$('.reg_row').fadeIn('slow');
								$('#email, .regdata').attr('readonly', true);
								$('#sumbit_contact').attr('disabled', true);
								$('html, body').animate({ scrollTop: $('#registration_table').offset().top}, 2000);
								
								$("#topinfo").load("topinfo.php");
								var refreshId = setInterval(function() {
									  $("#topinfo").load('topinfo.php');
								}, 3000);
								$.ajaxSetup({ cache: false });
								
							});
						} else {
							//alert('Wrong Password');
							$('#txtPassword').attr('class', 'error');
							$('#txtErrMsg').show();
							$('#txtErrMsg').fadeOut(2000, function() { $('#txtPassword').removeAttr('class'); $('#txtPassword').val(''); }); 
						}
					}
				});
			}
	  	});
	});
	//setTimeout( "jQuery('#error').fadeOut('slow');", 5000 );
	setTimeout( "jQuery('.msg').fadeOut('slow');", 5000 );
	
	/////////////// FIXED DEPARTURE - PICK UP POINTS
	$('#PickUpPointDiv').on('change', '#PickUpPoint', function() {
		$.post( "ajax.php", { pick_id: $('#PickUpPoint').val(), pickup_point : 1 })
		.done(function( data ) {
			if(data != '' && data != 0) {
				var dat = data.trim(); 
				var result = dat.split('#');
				$('#pickup_time').html(result[0].trim());
				$('#pickup_detail').html(result[1].trim());
				$('#PickUpTime').val(result[0].trim());
				$('#PickUpDetail').val(result[1].trim());
			} else {
				$('#PickUpTime').val($('#hid_pick_time').val());
				$('#PickUpDetail').val('');
				$('#pickup_time').html($('#hid_pick_time').val());
				$('#pickup_detail').html('');
			}
		});
	});
	
	$('.slimg').fadeIn('slow');
	
	$('a.login-window').click(function() {
		
		// Getting the variable's value from a link 
		var loginBox = $(this).attr('href');

		//Fade in the Popup and add close button
		$(loginBox).fadeIn(300);
		
		//Set the center alignment padding + border
		var popMargTop = ($(loginBox).height() + 24) / 2; 
		var popMargLeft = ($(loginBox).width() + 24) / 2; 
		
		$(loginBox).css({ 
			'margin-top' : -popMargTop,
			'margin-left' : -popMargLeft
		});
		
		// Add the mask to body
		$('body').append('<div id="mask"></div>');
		$('#mask').fadeIn(300);
		
		return false;
	});
	
	// When clicking on the button close or the mask layer the popup closed
	$('a.close, #mask').live('click', function() {
		$('#mask , .login-popup').fadeOut(300 , function() {
			$('#mask').remove();
		});
		return false;
	});
	
	$( "#somedivid" ).on("change", "#someid", function() {	
		$.post( "ajax.php", { somevar: $('#someinput').val() })
		.done(function( data ) { 
			if( data != '' ) {}
	  	});
	});
	
	$( "#printt" ).on("click", "#printticket", function() {		
		if($('#ticket').val() == '') { alert("Please enter ticket number"); $('#ticket').focus(); return false; }
		$( "#ticket-details" ).html( "<div style='margin-left:130px;'><img src=images/loader.gif border=0></div>" );
		$.post( "ajax.php", { ticket: $('#ticket').val(), printit: 1 })
		.done(function( data ) { 
			if( data != '' ) { $('#ticket-details').html(data); }
	  	});
	});
	
	/*$("#topinfo").load("topinfo.php");
	var refreshId = setInterval(function() {
		  $("#topinfo").load('topinfo.php');
	}, 3000);
	$.ajaxSetup({ cache: false });*/
	
});

$(document).keypress(function(e) {
    if(e.which == 13) {
        //alert('You pressed enter!');
		$('#txtSubmit').trigger('click');
    }
});