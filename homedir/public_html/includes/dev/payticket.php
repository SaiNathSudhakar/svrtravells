<?php
ob_start();
include_once("includes/functions.php");
include_once "includes/api-functions.php";
//if($_SESSION[$svr.'busbook'] == '') header('location:BusBooking.php');

//$base_url = "http://api.seatseller.travel/";

//var_dump($_SESSION); exit;
// Merchant key here as provided by Payu
$MERCHANT_KEY = "MtnhMH";

// Merchant Salt as provided by Payu
$SALT = "zjEmzpcI";

// End point - change to https://secure.payu.in for LIVE mode
//$PAYU_BASE_URL = "https://test.payu.in";
$PAYU_BASE_URL = "https://secure.payu.in";
$action = '';

$posted = array();
if(!empty($_POST)) {
  foreach($_POST as $keyy => $value) {     
    $posted[$keyy] = htmlentities($value, ENT_QUOTES);
  }
}
//var_dump($posted); exit;
$formError = 0;

if(empty($posted['txnid'])) {
  // Generate random transaction id
  $txnid = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
} else {
  $txnid = $posted['txnid'];
}

$hash = '';
// Hash Sequence
//$hashSequence = "key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5|udf6|udf7|udf8|udf9|udf10";
$hashSequence = "key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5|udf6|udf7|udf8|udf9|udf10";

if(empty($posted['hash']) && sizeof($posted) > 0) {
  if(empty($posted['key'])|| empty($posted['txnid']) || empty($posted['amount']) || empty($posted['firstname']) || empty($posted['email']) 
  	|| empty($posted['phone']) || empty($posted['productinfo']) || empty($posted['surl']) || empty($posted['furl']) ) {
  	$formError = 1; 
  } else {
    $hashVarsSeq = explode('|', $hashSequence);
    $hash_string = '';
    foreach($hashVarsSeq as $hash_var) {
      $hash_string .= isset($posted[$hash_var]) ? $posted[$hash_var] : '';
      $hash_string .= '|';
    }
    $hash_string .= $SALT;
    $hash = strtolower(hash('sha512', $hash_string));
    $action = $PAYU_BASE_URL . '/_payment';
  }
} elseif(!empty($posted['hash'])) {
  $hash = $posted['hash'];
  $action = $PAYU_BASE_URL . '/_payment';
}
?>

<html>
<?
if(!empty($_GET['order_id']))
{	
	$order_id = $_GET['order_id'];
	$query = mysql_query("select ba_id, ba_trip_id, ba_source, ba_source_name, ba_destination_name, ba_destination, ba_total_fare, ba_address, ba_email, ba_mobile, ba_journey_date, ba_name from svr_api_orders_temp as ba
			where ba_id = '".$order_id."'");
	$row = mysql_fetch_array($query);
	
	$sourcee = $row['ba_source_name'];//getSourceName($row['ba_source']);
	$destination = $row['ba_destination_name'];//getDestinationName($row['ba_source'], $row['ba_destination']);
	$firstname = explode('#', $row['ba_source']);
	$product_info = 'Trip: From '.$sourcee.' to '.$destination.' on '.date('d/m/Y', strtotime($row['ba_journey_date']));
	$success_url = $site_url.'confirm-ticket.php?status=1&orderid='.$row['ba_id'];
	$failure_url = $site_url.'confirm-ticket.php?status=2&orderid='.$row['ba_id'];
} 

?>
<body onLoad="check();">
    <!--<h2>PayU Form</h2>-->
    <br/>
    <?php if($formError) { ?>
      <span style="color:red">Please fill all mandatory fields.</span>
      <br/><br/>
    <?php } ?>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	  <tr>
		<td align="center"><img src="<?=$siteurl?>images/svr-travels.jpg" /></td>
	  </tr>
	  <tr>
		<td height="10" align="center"></td>
	  </tr>
	  <tr>
		<td align="center"><img src="<?=$siteurl?>images/ajax-loader.gif" /></td>
	  </tr>
	  <tr>
		<td height="10" align="center"></td>
	  </tr>
	  <tr>
		<td align="center"><span class="style2">Please wait while we connect to our payment gateway ... </span></td>
	  </tr>
	  <tr>
		<td align="center">&nbsp;</td>
	  </tr>
	  <tr>
		<td align="center" class="style3">
			Please do not activate the Back-Button on your browser as data you have entered up to that moment will be lost.
		</td>
	  </tr>
	  <tr>
		<td align="center">&nbsp;</td>
	  </tr>
	</table>
    <form action="<?php echo $action; ?>" method="post" name="payuForm">
      <input type="hidden" name="key" value="<?php echo $MERCHANT_KEY ?>" />
      <input type="hidden" name="hash" value="<?php echo $hash ?>" />
      <input type="hidden" name="txnid" value="<?php echo $txnid ?>" />
      <table style="display:none">
        <tr>
          <td><b>Mandatory Parameters</b></td>
        </tr>
        <tr>
          <td>Amount: </td>
          <td><input name="amount" value="<?=(!empty($row['ba_total_fare'])) ? $row['ba_total_fare'] : ((!empty($_POST['amount'])) ? $_POST['amount'] : ''); ?>" /></td>
          <td>First Name: </td>
          <td><input name="firstname" id="firstname" value="<?=(!empty($firstname[0])) ? $firstname[0] : ((!empty($_POST['firstname'])) ? $_POST['firstname'] : ''); ?>" /></td>
        </tr>
        <tr>
          <td>Email: </td>
          <td><input name="email" id="email" value="<?=(!empty($row['ba_email'])) ? $row['ba_email'] : ((!empty($_POST['email'])) ? $_POST['email'] : ''); ?>" /></td>
          <td>Phone: </td>
          <td><input name="phone" value="<?=(!empty($row['ba_mobile'])) ? $row['ba_mobile'] : ((!empty($_POST['phone'])) ? $_POST['phone'] : ''); ?>" /></td>
        </tr>
        <tr>
          <td>Product Info: </td>
          <td colspan="3"><input name="productinfo" value="<?=(!empty($product_info)) ? $product_info : ''; ?>" size="64" /></td>
        </tr>
        <tr>
          <td>Success URI: </td>
          <td colspan="3"><input name="surl" value="<?=(!empty($success_url)) ? $success_url : ''; ?>" size="64" /></td>
        </tr>
        <tr>
          <td>Failure URI: </td>
          <td colspan="3"><input name="furl" value="<?=(!empty($failure_url)) ? $failure_url : ''; ?>" size="64" /></td>
        </tr>
        <tr>
          <td><b>Optional Parameters</b></td>
        </tr>
        <tr>
          <td>Last Name: </td>
          <td><input name="lastname" id="lastname" value="<?=(!empty($_POST['lastname'])) ? $_POST['lastname'] : ''; ?>" /></td>
          <td>Cancel URI: </td>
          <td><input name="curl" value="" /></td>
        </tr>
        <tr>
          <td>Address1: </td>
          <td><input name="address1" value="<?=(!empty($row['ba_address'])) ? $row['ba_address'] : ((!empty($_POST['address1'])) ? $_POST['address1'] : ''); ?>" /></td>
          <td>Address2: </td>
          <td><input name="address2" value="<?=(!empty($_POST['address2'])) ? $_POST['address2'] : ''; ?>" /></td>
        </tr>
        <tr>
          <td>City: </td>
          <td><input name="city" value="<?=(!empty($_POST['city'])) ? $_POST['city'] : ''; ?>" /></td>
          <td>State: </td>
          <td><input name="state" value="<?=(!empty($_POST['state'])) ? $_POST['state'] : ''; ?>" /></td>
        </tr>
        <tr>
          <td>Country: </td>
          <td><input name="country" value="<?=(!empty($_POST['country'])) ? $_POST['country'] : ''; ?>" /></td>
          <td>Zipcode: </td>
          <td><input name="zipcode" value="<?=(!empty($_POST['zipcode'])) ? $_POST['zipcode'] : ''; ?>" /></td>
        </tr>
        <tr>
          <td>UDF1: </td>
          <td><input name="udf1" value="<?=(!empty($posted['udf1'])) ? $posted['udf1'] : ''; ?>" /></td>
          <td>UDF2: </td>
          <td><input name="udf2" value="<?=(!empty($posted['udf2'])) ? $posted['udf2'] : ''; ?>" /></td>
        </tr>
        <tr>
          <td>UDF3: </td>
          <td><input name="udf3" value="<?=(!empty($posted['udf3'])) ? $posted['udf3'] : ''; ?>" /></td>
          <td>UDF4: </td>
          <td><input name="udf4" value="<?=(!empty($posted['udf4'])) ? $posted['udf4'] : ''; ?>" /></td>
        </tr>
        <tr>
          <td>UDF5: </td>
          <td><input name="udf5" value="<?=(!empty($posted['udf5'])) ? $posted['udf5'] : ''; ?>" /></td>
          <td>PG: </td>
          <td><input name="pg" value="<?=(!empty($posted['pg'])) ? $posted['pg'] : ''; ?>" /></td>
        </tr>
		<tr>
          <td>COD URL: </td>
          <td><input name="codurl" value="<?=(!empty($posted['codurl'])) ? $posted['codurl'] : ''; ?>" /></td>
          <td>TOUT URL: </td>
          <td><input name="touturl" value="<?=(!empty($posted['touturl'])) ? $posted['touturl'] : ''; ?>" /></td>
        </tr>
		<tr>
          <td>Drop Category: </td>
          <td><input name="drop_category" value="<?=(!empty($posted['drop_category'])) ? $posted['drop_category'] : ''; ?>" /></td>
          <td>Custom Note: </td>
          <td><input name="custom_note" value="<?=(!empty($posted['custom_note'])) ? $posted['custom_note'] : ''; ?>"></td>
        </tr>
		<tr>
          <td>Note Category: </td>
          <td><input name="note_category" value="<?=(!empty($posted['note_category'])) ? $posted['note_category'] : ''; ?>" /></td>
        </tr>
        <tr>
          <?php if(!$hash) { ?>
            <td colspan="4"><input type="submit" value="Submit" /></td>
          <?php } ?>
        </tr>
      </table>
    </form>
  </body>
</html>

<script>
var hash = '<?php echo $hash ?>';
function submitPayuForm() 
{ 
  if(hash == '') {
	return;
  }
  var payuForm = document.forms.payuForm;
  payuForm.submit();
}

function check()
{ 
  document.forms["payuForm"].submit();
}
</script>