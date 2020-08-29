// JavaScript Document
$(document).ready(function(){
  $('.bxslider').bxSlider({
						  pager: false,
							mode:'fade',
							pause: 3500,
							speed:2000,
							auto:true
						  });
});
function basename(path, suffix) 
{
  var b = path;
  var lastChar = b.charAt(b.length - 1);

  if (lastChar === '/' || lastChar === '\\') {
    b = b.slice(0, -1);
  }
  
  b = b.replace(/^.*[\/\\]/g, '');

  if (typeof suffix === 'string' && b.substr(b.length - suffix.length) == suffix) {
    b = b.substr(0, b.length - suffix.length);
  }

  return b;
}

function array_sum(array) 
{
  var key, sum = 0;

  if (array && typeof array === 'object' && array.change_key_case) { // Duck-type check for our own array()-created PHPJS_Array
    return array.sum.apply(array, Array.prototype.slice.call(arguments, 0));
  }

  // input sanitation
  if (typeof array !== 'object') {
    return null;
  }

  for (key in array) {
    if (!isNaN(parseFloat(array[key]))) {
      sum += parseFloat(array[key]);
    }
  }

  return sum;
}

function checkdate(input)
{	
	var validformat=/^\d{2}\/\d{2}\/\d{4}$/ //Basic check for format validity
	var returnval=false
	if (!validformat.test(input.value))
		alert("Invalid Date Format. Please correct and submit again.")
	else{ //Detailed check for valid date ranges
		var monthfield=input.value.split("/")[0]
		var dayfield=input.value.split("/")[1]
		var yearfield=input.value.split("/")[2]
		var dayobj = new Date(yearfield, monthfield-1, dayfield)
		if ((dayobj.getMonth()+1!=monthfield)||(dayobj.getDate()!=dayfield)||(dayobj.getFullYear()!=yearfield))
			alert("Invalid Day, Month, or Year range detected. Please correct and submit again.")
		else
			returnval=true
	}
	if (returnval==false) input.select()
	return returnval
}

function tab(id)
{	
	document.getElementById('div1').style.display="none";
	document.getElementById('mdiv1').className="tab_ac";
	document.getElementById('div2').style.display="none";
	document.getElementById('mdiv2').className="tab_ac";
	document.getElementById('div3').style.display="none";
	document.getElementById('mdiv3').className="tab_ac";
	document.getElementById('div4').style.display="none";
	document.getElementById('mdiv4').className="tab_ac";
	document.getElementById(id).style.display="block";
	document.getElementById('m'+id).className="tab_onac";
}

function print_r(arr,level) 
{
	var dumped_text = "";
	if(!level) level = 0;
	
	//The padding given at the beginning of the line.
	var level_padding = "";
	for(var j=0;j<level+1;j++) level_padding += "    ";
	
	if(typeof(arr) == 'object') { //Array/Hashes/Objects 
		for(var item in arr) {
			var value = arr[item];
			
			if(typeof(value) == 'object') { //If it is an array,
				dumped_text += level_padding + "'" + item + "' ...\n";
				dumped_text += print_r(value,level+1);
			} else {
				dumped_text += level_padding + "'" + item + "' => \"" + value + "\"\n";
			}
		}
	} else { //Stings/Chars/Numbers etc.
		dumped_text = "===>"+arr+"<===("+typeof(arr)+")";
	}
	return dumped_text;
}

function popupwindow(url, title, w, h)
{
	var left = (screen.width/2)-(w/2);
	var top = (screen.height/2)-(h/2);
	return window.open(url, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);
}

function chkNumeric(evt)
{	
	var charCode = (evt.which) ? evt.which : event.keyCode
	if (charCode > 31 && (charCode < 48 || charCode > 57))
		return false;
   	return true;
}

function validEmail(v)
{	
    var r = new RegExp("[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?");
    return (v.match(r) == null) ? false : true;
}

function validate(cat)
{	
	if(cat == 1){
		var i = document.fixed_departures.fdfromloc;
		var j = document.fixed_departures.fdtoloc;
		var k = document.fixed_departures.datepicker1;
		tab('div3');
	} else if(cat == 2){
		var i = document.holiday_package.hpfromloc;
		var j = document.holiday_package.hptoloc;
		var k = document.holiday_package.datepicker2;
		tab('div4');
	}
	var flid = i.value; var tlid = j.value; var date = k.value; 
	if(flid == '') { alert("Please select Departure City"); i.focus(); return false; }
	if(tlid == '') { alert("Please select Arrival City"); j.focus(); return false; }
	if(date == '') { alert("Please select Departure Date"); k.focus(); return false; }
	
	var url = basename(document.URL, "/");
	var page = url.split("?"); 
	var vars = "?lid="+tlid;
	if(page[0] == 'destination-details.php'){
		page = (cat == 1 ) ? 'fixed-departure-booking.php' : 'tour-package-booking.php';
	} else if (page[0] == 'index.php'){
		page = 'destination-details.php';
	} else { //if(page[0] == 'fixed-departure-booking.php')
		page = page[0]; //'fixed-departure-booking.php';	
	}
	window.location.href = siteurl + page + vars +"&date="+date;	
}

function validate_booking()
{
	var category = document.getElementById('category').value;
	if(category == 2){
		flag = 0; n = document.getElementById('totroomtype').value; 
		for(i=0; i < n; i++) {	if(document.getElementById('room_type_'+i).checked == true) { flag = flag + 1; }}
		if(flag == 0) { alert('Please select Hotel Type'); document.getElementById('room_type_0').focus(); return false; }
		if(document.getElementById('vehicle').value == ''){ alert("Please Select Vehicle"); document.getElementById('vehicle').focus(); return false; }
		if(document.getElementById('pax').value == ''){ alert("Please Select Pax"); document.getElementById('pax').focus(); return false; }
	}
	if(document.getElementById('title').value == '') { alert('Please Select Title'); document.getElementById('title').focus(); return false; }
	if(document.getElementById('fname').value == ''){ alert('Please Enter Name'); document.getElementById('fname').focus(); return false; }
	if(document.getElementById('address').value == '') { alert('Please Enter Address'); document.getElementById('address').focus(); return false; }
	if(document.getElementById('mobile').value == '') { alert('Please Enter Mobile'); document.getElementById('mobile').focus(); return false; }
	if(document.getElementById('city').value == '') { alert('Please Enter City'); document.getElementById('city').focus(); return false; }
	if(document.getElementById('state').value == '') { alert('Please Select State'); document.getElementById('state').focus(); return false; }
	if(document.getElementById('country').value == '') { alert('Please Enter Country'); document.getElementById('country').focus(); return false; }
	if(document.getElementById('emaill').value == '') { alert('Please Enter Email Address'); document.getElementById('emaill').focus(); return false; }
	if(document.getElementById('customer').value == ''){
		if(document.getElementById('password').value == '') { alert('Please Enter email Password'); document.getElementById('password').focus(); return false; }
	}
	if(document.getElementById('terms').checked == false) { alert('Please Agree to Our Terms and Conditions'); document.getElementById('terms').focus(); return false; }
	var fare = document.getElementById('totalfare').value;
	var bal = document.getElementById('ag_dp').value;
	var agent = document.getElementById('agent').value;
	if( agent != '' && parseFloat(fare) > parseFloat(bal) ){
		alert('Your Balance Amount ('+ bal +') is less than total fare ('+ fare +')\n Please topup your account.'); //return false;
	}
	if(category == 1){
		document.fixedbookingform.submit();
	} else if(category == 2){
		document.tourbookingform.submit();
	}
}

function validate_enquiries()
{	
	var d = document.enquiry_form;
	
	if(d.arrival_date.value == ""){ alert("Please Select Arrival Date"); d.arrival_date.focus(); return false; }
	if(d.departure_date.value == ""){ alert("Please Select Departure Date"); d.departure_date.focus(); return false; }
	//if(d.interests.length == ""){ alert("Please Select Interests"); d.interests.focus(); return false; }
	if(d.enquiry.value == ""){ alert("Please Enter Travel Plan/Requirements"); d.enquiry.focus(); return false; }
	if(d.adults.value == ""){ alert("Please Enter Number of Adults"); d.adults.focus(); return false; }
	if(d.email.value == ""){ alert("Please Enter Email"); d.email.focus(); return false; }
	if(!validEmail(d.email.value)){ alert("Please Enter Valid E-Mail Address"); d.email.value=""; d.email.focus(); return false; }
	if(d.phone.value == ""){ alert("Please Enter Phone"); d.phone.focus(); return false; }
	if(d.city.value == ""){ alert("Please Enter City"); d.city.focus(); return false; }
	if(d.state.value == ""){ alert("Please Select State"); d.state.focus(); return false; }
	if(d.country.value == ""){ alert("Please Enter Country"); d.country.focus(); return false; }
	if(d.rnd1.value == ""){ alert("Please Enter the Result"); d.rnd1.focus(); return false; }
	if(d.rnd1.value != d.cap_sum.value){ alert("Please Enter Correct Result"); d.rnd1.focus(); return false; }	
}

function validate_enqury()
{	
	var d = document.visa_form;
	
	if(d.travel_date.value == ""){ alert("Please Select Travel Date"); d.travel_date.focus(); return false; }
	if(d.name.value == ""){ alert("Please Enter Name"); d.name.focus(); return false; }
	
	if(d.people.value == ""){ alert("Please Enter Number of People"); d.people.focus(); return false; }
	if(d.email.value == ""){ alert("Please Enter Email"); d.email.focus(); return false; }
	if(!validEmail(d.email.value)){ alert("Please Enter Valid E-Mail Address"); d.email.value=""; d.email.focus(); return false; }
	if(d.phone.value == ""){ alert("Please Enter Phone"); d.phone.focus(); return false; }
	if(d.city.value == ""){ alert("Please Enter City"); d.city.focus(); return false; }
	if(d.state.value == ""){ alert("Please Select State"); d.state.focus(); return false; }
	if(d.country.value == ""){ alert("Please Enter Country"); d.country.focus(); return false; }
	if(d.rnd1.value == ""){ alert("Please Enter the Result"); d.rnd1.focus(); return false; }
	if(d.rnd1.value != d.cap_sum.value){ alert("Please Enter Correct Result"); d.rnd1.focus(); return false; }	
}

function validate_enquiries()
{	
	var d = document.flight_form;
	
	if(d.from_date.value == ""){ alert("Please Select From Date"); d.from_date.focus(); return false; }
	if(d.to_date.value == ""){ alert("Please Select To Date"); d.to_date.focus(); return false; }
	if(d.name.value == ""){ alert("Please Enter Name"); d.name.focus(); return false; }
	
	if(d.people.value == ""){ alert("Please Enter Number of People"); d.people.focus(); return false; }
	if(d.email.value == ""){ alert("Please Enter Email"); d.email.focus(); return false; }
	if(!validEmail(d.email.value)){ alert("Please Enter Valid E-Mail Address"); d.email.value=""; d.email.focus(); return false; }
	if(d.phone.value == ""){ alert("Please Enter Phone"); d.phone.focus(); return false; }
	if(d.city.value == ""){ alert("Please Enter City"); d.city.focus(); return false; }
	if(d.state.value == ""){ alert("Please Select State"); d.state.focus(); return false; }
	if(d.country.value == ""){ alert("Please Enter Country"); d.country.focus(); return false; }
	if(d.rnd1.value == ""){ alert("Please Enter the Result"); d.rnd1.focus(); return false; }
	if(d.rnd1.value != d.cap_sum.value){ alert("Please Enter Correct Result"); d.rnd1.focus(); return false; }	
}
var chk_email=/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+[\.]{1}[a-zA-Z]{2,4}$/;
function validate_enquiry()
{
	d=document.enquiry;
	if(d.txt_name.value==""){alert("Please Enter Your Name");d.txt_name.focus(); return false;}
	if(d.txt_phone.value==""){ alert("Please Enter Your Phone Number"); d.txt_phone.focus(); return false;}
	else if (d.txt_phone.value.length < 10){alert("Phone Number must contain atleast 10 characters"); d.txt_phone.focus(); return false;}
	else if(isNaN(d.txt_phone.value)){alert("Please Enter Only Numbers"); d.txt_phone.focus(); return false;}
	if(!chk_email.test(d.txt_email.value)){ alert("Please Enter Valid Email ID");d.txt_email.focus(); return false;}
	//if(d.txt_email.value==""){alert("Please Enter E-Mail ID "); d.txt_email.focus(); return false;}
	else if(!validEmail(d.txt_email.value)){alert("Please Enter A Valid E-Mail ID "); d.txt_email.focus(); return false;}
	if(d.txt_areaint.value==""){alert("Please Enter Area of Interest");d.txt_areaint.focus(); return false;}
	if(d.text_enquiry.value==""){alert("Please Enter Enquiry Message");d.text_enquiry.focus(); return false;}
	if (d.rnd1.value=="" || d.rnd1.value=='Result?'){ alert("Please Enter the Sum of Two Numbers !"); d.rnd1.value=""; d.rnd1.focus(); return false; }
	if (d.rnd1.value != c){ alert("Please Enter Correct Result"); d.rnd1.value=""; d.rnd1.focus(); return false; }
	return true;
}

function validate_agent_profile()
{	
	var d = document.profile;
	var chk_phone=/^\d{10}$/; //alert(d.rnd1.value +'!= '+ c);
	if(d.title.value==""){ alert("Please Select Title");d.title.focus(); return false;}
	if(d.fname.value==""){ alert("Please Enter First Name");d.fname.focus(); return false;}
	if(d.lname.value==""){ alert("Please Enter Last Name");d.lname.focus(); return false;}
	if(d.mobile.value==""){alert("Please Enter Mobile Number"); d.mobile.focus(); return false;}
	else if(!chk_phone.test(d.mobile.value)){ alert("Enter Valid Mobile Number");d.mobile.focus(); return false;}
	//if(d.landline.value==""){alert("Please Enter Landline Number"); d.landline.focus(); return false;}
	if(d.email.value==""){alert("Please Enter E-Mail ID"); d.email.focus(); return false;}
	else if(!validEmail(d.email.value)){ alert("Please Enter Valid E-Mail Address"); d.email.value=""; d.email.focus(); return false; }
	if(d.pancard.value==""){ alert("Please Enter Pan Card");d.pancard.focus(); return false;}
	if(d.address1.value==""){ alert("Please Enter Address");d.address1.focus(); return false;}
	if(d.city.value==""){ alert("Please Enter City");d.city.focus(); return false;}
	if(d.state.value==""){ alert("Please Select State");d.state.focus(); return false;}
	if(d.country.value==""){ alert("Please Enter Country");d.country.focus(); return false;}
	if(d.pincode.value==""){ alert("Please Enter Pincode");d.pincode.focus(); return false;}
	if(d.image.value=="" && d.old_img.value==""){ alert("Please Upload an image");d.image.focus(); return false;}
	if(d.rnd1.value==""){alert("Please Enter Result");d.rnd1.focus();return false;}
	if(d.rnd1.value != c){ alert("Please Enter Correct Result"); d.rnd1.focus(); return false; }
}
function validate_customer_profile()
{	
	var d = document.profile;
	var chk_phone=/^\d{10}$/;
	if(d.title.value==""){ alert("Please Select Title");d.title.focus(); return false;}
	if(d.fname.value==""){ alert("Please Enter First Name");d.fname.focus(); return false;}
	if(d.lname.value==""){ alert("Please Enter Last Name");d.lname.focus(); return false;}
	if(d.mobile.value==""){alert("Please Enter Mobile Number"); d.mobile.focus(); return false;}
	else if(!chk_phone.test(d.mobile.value)){ alert("Enter Valid Mobile Number");d.mobile.focus(); return false;}
	//if(d.landline.value==""){alert("Please Enter Landline Number"); d.landline.focus(); return false;}
	if(d.email.value==""){alert("Please Enter E-Mail ID"); d.email.focus(); return false;}
	else if(!validEmail(d.email.value)){ alert("Please Enter Valid E-Mail Address"); d.email.value=""; d.email.focus(); return false; }
	if(d.address1.value==""){ alert("Please Enter Address");d.address1.focus(); return false;}
	if(d.city.value==""){ alert("Please Enter City");d.city.focus(); return false;}
	if(d.state.value==""){ alert("Please Select State");d.state.focus(); return false;}
	if(d.country.value==""){ alert("Please Enter Country");d.country.focus(); return false;}
	if(d.pincode.value==""){ alert("Please Enter Pincode");d.pincode.focus(); return false;}
	if(d.rnd1.value==""){alert("Please Enter Result");d.rnd1.focus();return false;}
	if(d.rnd1.value != c){ alert("Please Enter Correct Result"); d.rnd1.focus(); return false; }
}

function validate_customer_password()
{	
	var d = document.editpassword;
	if(d.oldpass.value == '') { alert("Please Enter Old Password"); d.oldpass.focus(); return false; }
	if(d.newpass.value == '' || d.newpass.value.length < 6){ alert("Please Enter New 6-digit Password"); d.newpass.focus(); return false; }
	if(d.conpass.value == '') { alert("Please Re-Enter Correct Password"); d.conpass.focus(); return false; }
	if(d.newpass.value != d.conpass.value) { alert("Passwords Do Not Match"); d.conpass.focus(); return false; }
}

function validate_customer_forgotpwd()
{	
	var d = document.customer_forgot_form;
	if(d.email.value == "" ) { alert("Please Enter Email Address"); d.email.focus(); return false; } 
	else if(!validEmail(d.email.value)) { alert("Please Enter Valid Email Address"); d.email.focus(); return false; }
}

/*var chk_email=/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+[\.]{1}[a-zA-Z]{2,4}$/;
var chk_phone=/^\d{10}$/;*/
function validate_agent_deposit(i)
{ 	
	var chk_phone=/^\d{10}$/; var numbers = /^[1-9]\d*(((,\d{3}){1})?(\.\d{0,4})?)$/;
	var d = document.deposit; var deposit_type = getRadioVal(document.getElementById('deposit'), 'source');
	if(d.source[0].checked==false && d.source[1].checked==false && d.source[2].checked==false){
		alert('please select deposit type'); d.source[0].focus(); return false; }
	if(i == 1) { if(d.agent.value==""){ alert("Please Select Agent"); d.agent.focus(); return false; } }
	if(!chk_phone.test(d.mobile.value)){alert("Enter Valid Mobile Number");d.mobile.focus(); return false; }
	if(d.amount.value==""){ alert("Please Enter Amount"); d.amount.focus(); return false; }
	if(!numbers.test(d.amount.value)){ alert("Please Enter Numeric Characters Only"); d.amount.focus(); return false; }
	if(d.bank.value==""){ alert("Please Select Bank"); d.bank.focus(); return false; } 
	if(d.transaction.value==""){ alert("Please Enter Transaction ID"); d.transaction.focus(); return false; }
	if(deposit_type == 2 || deposit_type == 3){
		if(d.cq_holder.value==""){ alert("Please Enter Account Holder's Name"); d.cq_holder.focus(); return false;}
	}if(deposit_type == 2){
		if(d.cq_drawn.value==""){ alert("Please Enter Cheque Drawn on Bank"); d.cq_drawn.focus(); return false; }
		if(d.cq_datepicker.value==""){ alert("Please Enter Issue Date"); d.cq_datepicker.focus(); return false; }	
		if(d.cq_dd.value==""){ alert("Please Enter Cheque or DD No."); d.cq_dd.focus(); return false; }
	}
	if(d.attach.value=="" && d.attach_hid.value==""){ alert("Please Upload File"); d.attach.focus(); return false; }
}

/*function validate_cancel_booking()
{	
	var d = document.cancelbooking;
	if(d.ticket.value == '') { alert("Please Enter Ticket Number"); d.ticket.focus(); return false; }
	if(d.email.value == "" ) { alert("Please Enter Email Address"); d.email.focus(); return false; } 
	else if(!validEmail(d.email.value)) { alert("Please Enter Valid Email Address"); d.email.focus(); return false; }
}*/

function show_deposit_type(id){ 
	if(id==1){ //cash
		document.getElementById('cheq_draw_bank').style.display="none"; 
		document.getElementById('cheq_issu_date').style.display="none";
		document.getElementById('cheq_dd_no').style.display="none";
		document.getElementById('acc_holdr_name').style.display="none";
	}
	else if(id==2){ //cheque
		document.getElementById('cheq_draw_bank').style.display="";
		document.getElementById('cheq_issu_date').style.display="";
		document.getElementById('cheq_dd_no').style.display="";
		document.getElementById('acc_holdr_name').style.display="";
	}
	else if(id==3){ //trans
		document.getElementById('cheq_draw_bank').style.display="none";
		document.getElementById('cheq_issu_date').style.display="none";
		document.getElementById('cheq_dd_no').style.display="none";
		document.getElementById('acc_holdr_name').style.display="";
	}
}

function NumbersOnly(MyField, e, dec)
{
var key;
var keychar;
if (window.event)
   key = window.event.keyCode;
else if (e)
   key = e.which;
else
   return true;
keychar = String.fromCharCode(key);
if ((key==null) || (key==0) || (key==8) ||
    (key==9) || (key==13) || (key==27) )
   return true;
else if ((("0123456789()+-").indexOf(keychar) > -1))
   return true;
else if (dec && (keychar == "."))
   {
   MyField.form.elements[dec].focus();
   return false;
   }
else
   return false;
}

function getRadioVal(form, name) {
    var val;
    // get list of radio buttons with specified name
    var radios = form.elements[name];
    
    // loop through list of radio buttons
    for (var i=0, len=radios.length; i<len; i++) {
        if ( radios[i].checked ) { // radio checked?
            val = radios[i].value; // if so, hold its value in val
            break; // and break out of for loop
        }
    }
    return val; // return value of checked radio or undefined if none checked
}

function captcha()
{	
	var a = Math.floor(Math.random()*10);
	var b = Math.floor(Math.random()*10);
	c = a + b;
	document.getElementById("cap_sum").value = c;
	document.getElementById("rndnumber").innerHTML = a + ' + ' + b + ' = ';
}
window.onload=captcha;