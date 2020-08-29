<?
if($_SERVER['REQUEST_METHOD']=="POST")
{
$email="";
for($e=0;$e<=10;$e++)
{
	if(!empty($_POST['email'.$e]))
	{
		$email.=$_POST['email'.$e].", ";
	}
}
$email=substr($email,0,-2);
//echo $email;
//exit;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title></title>
</head>
<body>
<form action="" method="post" name="form1">
<table width="50%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td width="200" align="center" valign="top">Seasons</td>
<td width="10" align="center" valign="top"><strong>:</strong></td>
<td align="left"><table width="100%" border="0" cellspacing="0" cellpadding="0">
<? if(empty($_GET['id'])) {?>
<tr>
  <td align="left"><div id="mastere"><div id="ac_gce">
  <input type="hidden" name="ac_gc_valide_1" id="ac_gc_valide_1" value="1" />
		<table border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td align="left"><input name="email1" type="text" class="box" id="email1" value="" size="35" /></td>
			<td>&nbsp;</td>
			<td align="center"><input type="hidden" name="p_email" id="p_email" value="1" /><img src="add.png" style="cursor:pointer;" border="0" onclick="add_ac_gce()"/></td>
		  </tr>
		</table>
	  </div></div></td>
</tr>

<? } else {?>

<tr>
<td align="left"><div id="ac_gce1">
	  <? $e=1; for($ee=0;$ee<=$m;$ee++){ ?>
	  <div id='ac_gc_sub_<?=$e;?>'>
			<input type="hidden" name="ac_gc_valide1_<?=$e;?>" id="ac_gc_valide1_<?=$e;?>" value="1" />
			<table border="0" cellpadding="0" cellspacing="0">
			  <tr>
				<td align="left"><input name="email<?=$e;?>" type="text" class="box" id="email<?=$e;?>" value='<?=$ex_email[$ee];?>' size="35" /></td>
				<td align="center"><? if($e>1){?><img src="del.png"  onclick="close_ac_gce1(<?=$e;?>)" width="16" height="16" border="0" style="cursor:pointer;" />
				<? } if($e==1 || $e==0){?><img src="add.png" style="cursor:pointer;" border="0"  onclick="add_ac_gce1()"/><? }?></td>
			  </tr>
			</table></div><? $e++;}?>
	  </div><input type="hidden" name="p_email_up" id="p_email_up" value="<?=$e-1;?>" />
	  <input type="hidden" name="p_email" id="p_email" value="<?=$e;?>" />
  <script type="text/javascript">js_acgce1=<?=$e-1;?>;</script></td>
</tr><? }?>
</table></td>
</tr>
  <tr>
    <td align="left">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="left">&nbsp;</td>
  </tr>
  <tr>
    <td align="left">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="left"><input type="submit" name="Submit" value="Submit" /></td>
  </tr>
  <tr>
    <td align="left">&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td align="left">&nbsp;</td>
  </tr>
</table>
</form>
</body>
</html>
<script language="javascript">
var js_acgce=1;
function add_ac_gce()
{
	js_acgce++;
	document.form1.p_email.value=js_acgce; 
	var contentID = document.getElementById('mastere');
	var newTBDiv = document.createElement('div');
	newTBDiv.setAttribute('id','ac_gce'+js_acgce);
	tmp_var ="<input type='hidden' title="+js_acgce+" name='ac_gc_valide_"+js_acgce+"' id='ac_gc_valide_"+js_acgce+"' value='1'>"
	tmp_var+="<table border='0' cellspacing='0' cellpadding='0'><tr>";
	tmp_var+="<td><input name='email"+js_acgce+"' type='text' class='box' id='email"+js_acgce+"' size='35'/></td>";
	tmp_var+="<td>&nbsp;</td>";
	tmp_var+="<td align='center'><img src='del.png' title='Click to Delete !' style='cursor:pointer;' alt='Click to Delete !' border='0' onclick='javascript:close_ac_gce("+js_acgce+")' /></td></tr></table>";
	newTBDiv.innerHTML=tmp_var;
	contentID.appendChild(newTBDiv);
}

function close_ac_gce(ac_gce_id){
	document.getElementById("ac_gce"+ac_gce_id).style.display='none';
	document.getElementById("mastere").removeChild(document.getElementById("ac_gce"+ac_gce_id));
	document.getElementById("ac_gc_valide_"+ac_gce_id).value="0";
}


function add_ac_gce1()
{
	js_acgce1++;
	document.form1.p_email.value=js_acgce1; 
	var contentID = document.getElementById('ac_gce1');
	var newTBDiv = document.createElement('div');
	newTBDiv.setAttribute('id','ac_gc_sub_'+js_acgce1);
	tmp_var ="<input type='hidden' name='ac_gc_valide1_"+js_acgce1+"' id='ac_gc_valide1_"+js_acgce1+"' value='1'>"
	tmp_var+="<table border='0' cellspacing='0' cellpadding='0'><tr>";
	tmp_var+="<td><input name='email"+js_acgce1+"' type='text' class='box' id='email"+js_acgce1+"' size='35'/></td>";
	tmp_var+="<td align='center'><img src='../images/del.png' style='cursor:pointer;' title='Click to Delete !' alt='Click to Delete !' border='0' onclick='javascript:close_ac_gce1("+js_acgce1+")'/></tr></table>";
	newTBDiv.innerHTML=tmp_var;
	contentID.appendChild(newTBDiv);
}

function close_ac_gce1(ac_gce1_id)
{
	document.getElementById("ac_gc_sub_"+ac_gce1_id).style.display='none';
	document.getElementById("ac_gce1").removeChild(document.getElementById("ac_gc_sub_"+ac_gce1_id));
	document.getElementById("ac_gc_valide1_"+ac_gce1_id).value="0";
}
</script>