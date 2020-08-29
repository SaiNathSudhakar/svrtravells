<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1">
<head>
<style>
.error_page {width:100%; padding:50px; margin:auto; text-align:center; height:200px; border:1px solid #eaeaea; vertical-align:middle;}
.error_page h1 {margin: 20px 0 0;}
.error_page p {margin: 10px 0; padding: 0;}		
a {color: #006699; text-decoration:none;}
a:hover {color: #9caa6d; text-decoration:underline;}
</style>
 <? include("includes/functions.php");?>
 <? include('includes/header.php');?>
 <? include("includes/menu.php");?>
 <div class="clear mt10">&nbsp;</div>
 <div class="mid_section">	  
	<div class="error_page mt20">
		<h1>404 Page Not Found</h1>
		<p>The page you are looking for cannot be found.</p>
		<p><a href="<?=$siteurl.'index.php';?>">Return to the homepage</a></p>
	</div><br /> 
	<div class="clear"></div>
 </div>
<? include('includes/footer.php'); ?>
</body>
</html>