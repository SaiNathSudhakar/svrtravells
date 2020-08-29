$(document).ready(function() {
	
	// FARES CATEGORY PAGE	
	$('#fare_type_dropdown').on("change", "#ftype_dp", function() {
		var fare_type = $('#ftype_dp').val();
		$("input:radio[name='adultchild']").prop('checked', false);
		$("#multiple").val('');
		console.log(fare_type);
		
		$.ajax({
			url: "ajax.php",
			async: false,
			type: "POST",
			data: "fare_type=" + fare_type + "&fares_cat=" + 1,
			dataType: "html",
			
			success: function(loc) {
				if( loc == '' ) { $('#loc_row').hide();	} else { $( "#loc_dp" ).html(loc); $('#loc_row').show(); }
				$(".sel_destination").multipleSelect({	placeholder: 'Select Locations', multiple: true, filter: true });
				$.ajax({
				 	url: "ajax.php",
				  	async: false,
				  	type: "POST",
				  	data: "fare_type=" + fare_type + "&fare_name=" + 1,
					dataType: "html",
					
				  	success: function(name)
					{	
						if(name != '' ) $('#fare_cat_row').show(); else $('#fare_cat_row').hide();
						if(fare_type == 1) $('#multiples_row, #adultchild_row').show(); else $('#multiples_row, #adultchild_row').hide();
						$('#fare_cat').html(name);
			  		}
				});
			}
		});
	});
	
	// FARES CATEGORY PAGE
	$('#sub_dp').on("change", "#sel_subcategory", function() { 
		$.post( "ajax.php", { subcat: $(this).val(), fares_cat: 1 })
		.done(function( data ) { 
			if(data != '') { $('#loc_row').show(); } else { $('#loc_row').hide(); }
			$( "#loc_dp" ).html( data ); $(".sel_destination").multipleSelect({	placeholder: 'Select Locations', multiple: true, filter: true });
		});
	});
	
	// FARES PAGE
	$( "#fare_type_dropdown1" ).on("change", "#ftype_dp", function() { 
		$('#fares_row').fadeOut('slow'); //alert($('#ftype_dp').val());
		$.post( "ajax.php", { fare_type: $('#ftype_dp').val(), fares: 1 })
		.done(function( data ) { //alert(data);
			if( data == '' ) { 
				$('#loc_row1').hide(); $('#sub_row1').hide(); 
			} else { 
				if($('#ftype_dp').val() == 1) { $( "#loc_dp1" ).html( data ); $('#loc_row1').show(); $('#sub_row1').hide(); $('#fare_date').show(); }
				if($('#ftype_dp').val() == 2) { $( "#sub_dp1" ).html( data ); $('#loc_row1').hide(); $('#sub_row1').show(); $('#fare_date').hide(); }
			}
	   });
	});
	
	// FARES PAGE
	$('#sub_dp1').on("change", "#sel_subcategory", function() {
		$('#fares_row').fadeOut('slow');
		$.post( "ajax.php", { subcat: $(this).val(), fares: 1 })
		.done(function( data ) { 
			if(data != '') { $('#loc_row1').show(); } else { $('#loc_row1').hide(); }
			$( "#loc_dp1" ).html( data ); 
		});
	});
	
	// Hotel Category PAGE

	$('#sub_dp2').on("change", "#sel_subcategory", function() {
		$('#fares_row').fadeOut('slow');
		$.post( "ajax.php", { subcat1: $(this).val(), fares: 1 })
		.done(function( data ) { 
			if(data != '') { $('#loc_row2').show(); } else { $('#loc_row2').hide(); }
			$( "#loc_dp2" ).html( data ); 
		});
	});
	
	$('#loc_dp2').on("change", "#sel_destination", function() {
		$('#fares_row').fadeOut('slow');
		$.post( "ajax.php", { subcat2: $(this).val(), fares: 1 })
		.done(function( data ) { 
			if(data != '') { $('#hloc_row2').show(); } else { $('#hloc_row2').hide(); }
			$( "#hloc_dp2" ).html( data ); 
		});
	});

	
	// FARES PAGE
	$('#loc_dp1').on("change", "#sel_destination", function() { 
		$.post( "ajax.php", { dest: $(this).val(), fares: 1 })
		.done(function( data ) { 
			if(data != '') $('#fares_row').fadeIn('slow'); else $('#fares_row').fadeOut('slow');
			$( "#fares_details" ).html( data );	
		});
	});
	
	// TOUR LOCATIONS PAGE
	$( "#tour_loc_dropdown" ).on("change", "#type_dp", function() { 
		$.post( "ajax.php", { type: $('#type_dp').val(), from_loc: 1 })
		.done(function( data ) { //alert(data);
			if( data == '' ) { 
				$('#loc_row').hide();
			} else { 
				//if($('#type_dp').val() == '1') 
				$( "#loc_dp" ).html( data );
				$('#loc_row').show();
			}
			$("#sel_destination").multipleSelect({ placeholder: 'Select Locations', multiple: true, filter: true });
		});
	});
	
	// PACKAGE PAGE
	/*$( "#type_row" ).on("change", "#type_dp", function() { 
		//$('select[id=sel_to_loc]').val(0);
		$.post( "ajax.php", { type: $('#type_dp').val(), package: 1 })
		.done(function( data ) { //alert(data);
			if(data != '') $( "#to_loc_dp" ).html( data ); else $('select[id=sel_from_loc]').val(0);
		});
	});
	
	// PACKAGE PAGE
	$( "#from_loc_dp" ).on("change", "#sel_from_loc", function() { 
		$('select[id=sel_to_loc]').val(0);
		$.post( "ajax.php", { from_loc: $('#sel_from_loc').val(), type: $('#type_dp').val(), package: 2 })
		.done(function( data ) { 
			if(data != '') $( "#to_loc_dp" ).html( data );
		});
	});*/
	
	// PACKAGE PAGE
	$( "#to_loc_dp" ).on("change", "#sel_to_loc", function() { //alert($(this).val());
		$.post( "ajax.php", { dest: $(this).val(), /*type: $('#type_dp').val(),*/ package: 3 })
		.done(function( data ) { //alert(data);
			if(data != '') $('.seats_row').fadeIn('slow'); else $('.seats_row').fadeOut('slow');
			$( "#seats_details" ).html( data );	
		});
	});
	
	// TO LOCATIONS PAGE	
	$('#cat_dropdown').on("change", "#cmb_cat", function() {
		$.post( "ajax.php", { cat: $(this).val(), to_loc: 1 })
		.done(function( data ) { 
			if(data == '' || $('#cmb_cat').val() == 1 || $('#cmb_cat').val()=='') { $('#subcat_row').hide(); $('#subsubcat_row').hide(); } else { $('#subcat_row').show(); }
			$( "#subcat_dropdown" ).html( data );
		});
	});
	
	$('#subcat_dropdown').on("change", "#cmb_subcat", function() {  
		$.post( "ajax.php", { subcat: $(this).val(), to_loc: 2 })
		.done(function( data ) { 
			if(data == '' || $('#cmb_cat').val() == 1 || $('#cmb_cat').val()=='' || $('#cmb_subcat').val()=='') { 
				$('#subsubcat_row').hide(); } else { $('#subsubcat_row').show(); }
			$( "#subsubcat_dropdown" ).html( data );
		});
	});
});	