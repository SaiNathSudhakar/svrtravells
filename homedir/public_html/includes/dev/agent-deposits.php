<?
include_once("includes/functions.php");
agent_login_check();
$pageName="Deposit";

if($_SERVER['REQUEST_METHOD']=="POST")
{
	$path = "uploads/agents/".$_SESSION[$svra.'ag_unique_id']."/";
	if($_POST['source'] == 1){ $cq_drawn = ''; $cq_datepicker = '0000-00-00 00:00:00'; $cq_dd = ''; $cq_holder = ''; }
	else if($_POST['source'] == 2){ 
		$cq_drawn = (!empty($_POST['cq_drawn'])) ? $_POST['cq_drawn'] : ''; 
		$cq_datepicker = date('Y-m-d H:i:s', strtotime($_POST['cq_datepicker'])); 
		$cq_dd = (!empty($_POST['cq_dd'])) ? $_POST['cq_dd'] : ''; 
		$cq_holder = (!empty($_POST['cq_holder'])) ? $_POST['cq_holder'] : ''; 
	}
	else if($_POST['source'] == 3){ 
		$cq_drawn = ''; $cq_datepicker = '0000-00-00 00:00:00'; $cq_dd = ''; 
		$cq_holder = (!empty($_POST['cq_holder'])) ? $_POST['cq_holder'] : ''; 
	}
	$tans_cond = (!empty($_GET['id'])) ? " and ad_id <> '".$_GET['id']."'" : "";
	$transc_id = getdata("svr_agent_deposits", "count(ad_id)", "ad_transaction='".$_POST['transaction']."' $tans_cond");
	
	if($transc_id == 0)
	{
	  if($_FILES['attach']['size'] >= 1){	
		$file_upload = $path.make_filename(basename($_FILES["attach"]['name']));
		if(!file_exists($file_upload))	@mkdir($path, 0777, true);
		move_uploaded_file($_FILES['attach']['tmp_name'], $file_upload);
		$file_upload = basename($file_upload);
	  }
		
	  if(!empty($_GET['id'])){
		if($_FILES['attach']['size']==0){ 
				$file_upload = $_POST['attach_hid'];
		} else if($_FILES['attach']['size']>=1) {
			if(basename($_FILES['attach']['name'])<>$_POST['attach_hid']) {
				@unlink($path.$_POST['attach_hid']); 
			}
		}
	  }
	  if(!empty($file_upload))
	  {
		if(empty($_GET['id'])){
			mysql_query("insert into svr_agent_deposits(ad_id, ad_ag_id, ad_amount, ad_transaction, ad_bank, ad_drawn, ad_chq_issue_date, ad_dd_no, ad_acc_holder, ad_attach_slip, ad_type, ad_status, ad_addeddate) values('','".$_SESSION[$svra.'ag_id']."','".$_POST['amount']."','".$_POST['transaction']."','".$_POST['bank']."','".$cq_drawn."','".$cq_datepicker."','".$cq_dd."','".$cq_holder."','".basename($file_upload)."','".$_POST['source']."',1,'".$now_time."')");
		} else {
			mysql_query("update svr_agent_deposits set ad_amount='".$_POST['amount']."', ad_transaction='".$_POST['transaction']."', ad_bank='".$_POST['bank']."', ad_drawn='".$cq_drawn."', ad_chq_issue_date='".$cq_datepicker."', ad_dd_no='".$_POST['cq_dd']."', ad_acc_holder='".$cq_holder."', ad_attach_slip='".basename($file_upload)."', ad_type='".$_POST['source']."' where ad_id=".$_GET['id']." and ad_ag_id = ".$_SESSION[$svra.'ag_id']);
		}
		
		$data['subject'] = 'Deposit Request from Agent';
		$data['content'] = "<table align='left'><tr><td>Dear Sir,</td></tr><tr><td>&nbsp;</td></tr>
		<tr><td>".$_SESSION[$svra.'ag_fname']." has submitted deposit request of Rs.".$_POST['amount']." with Transactin ID ".$_POST['transaction'].".</td></tr>
		<tr><td>&nbsp;</td></tr><tr><td>Thanks & Regards, <br>SVR Tours and Travels</td></tr></table>";
		$data['to_email'] = 'janardhan@svrtravelsindia.com';
		send_email($data);
		
		header('location:agent-deposits-history.php');
	  } else {
		  $err = "Please upload Deposit Slip.";
	  }
	} else {
		$msg = "Transaction ID already exists";
	}
}

$cond = (!empty($_GET['id'])) ? " ad_id = '".$_GET['id']."'" : "1";

$sam = mysql_query("select ad_id, ad_ag_id, ad_amount, ad_transaction, ad_bank, ad_drawn, ad_chq_issue_date, ad_dd_no, ad_acc_holder, ad_attach_slip, ad_type, cnt_content from svr_agent_deposits
	left join svr_content_pages on cnt_id = 2
		where $cond and ad_status=1");
$count = mysql_num_rows($sam);	
if($count == 0 ) header('location:agent-deposits-history.php');
$fetch_sam = mysql_fetch_array($sam);

$designFILE = "design/agent-deposits.php";
include_once("includes/svrtravels-template.php");
?>