<?
if(isset($_SESSION['tm_type'])){ $footerpath="".$logos['FOOTER']['path']; } else { $footerpath=$logos['FOOTER']['path']; }
?>
<table width="99%" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td align="left"><div class="f11 fl ml10" style="color:#ccdaed;"><?=getdata("svr_footer","f_desc","f_status=1");?><!--© <?//=date('Y')?> MoreVisas.--></div></td>
        <td align="right"><div class="fr f11 mr10" style="color:#ccdaed;">Powered By <a href="http://www.bitranet.com/" title="Website Design, Development, Maintenance &amp; Powered by BitraNet Pvt. Ltd.," target="_blank"><strong>BitraNet</strong></a><a href="<?//=$logos['FOOTER']['url']?>" target="_blank">
<!--
<img src="<?=$footerpath;?>" width="110" height="28" border="0" alt="<?=$logos['FOOTER']['alt']?>" title="<?=$logos['FOOTER']['alt']?>">
-->		
		</a></div></td>
      </tr>
    </table>