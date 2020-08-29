<? if (substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')) ob_start("ob_gzhandler"); else ob_start();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>

 <div class="clear mt10">&nbsp;</div>
	<div class="mid_section">
		<div id="inner_mid">			  
			<!--<div class="inner_content">-->
			<? if(!empty($designFILE)){include($designFILE);}?>
			<!--</div>-->
			<div class="clear"></div>
		</div>
    </div>    
		
</body>
</html>