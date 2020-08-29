<? if (substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')) ob_start("ob_gzhandler"); else ob_start();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1">
<body>
<div id="main_wrapper">
 <? include('header.php');?>
 <? include("menu.php");?>
 <div class="clear mt10">&nbsp;</div>
	<div id="mid_section">
		<div id="inner_mid">			  
			<!--<div class="inner_content">-->
			<? if(!empty($designFILE)){include($designFILE);}?>
			<!--</div>-->
			<div class="clear"></div>
		</div>
		<? include('right.php'); ?>
		<div class="clear"></div>
	</div>
 <div class="clear"></div>
</div>
<? include('footer.php'); ?>
</body>
</html>