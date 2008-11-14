<!-- INDIVIDUAL PAGE ENDS -->
<!-- GLOBAL FOOTER BEGINS -->
<br>
<br></td>
<td width="1" class="outliner"><img src="images/spacer.gif" border="0" width="1" height="1"></td>
</tr> </table> 
<table width="100%" cellpadding="0" cellspacing="0" border="0">
  <tr> 
    <td class="outliner"><img src="images/spacer.gif" border="0" width="1" height="1"></td>
  </tr>
</table></td>
</tr> </table> 
<table width="100%" cellpadding="0" cellspacing="0" border="0" >
  <tr> 
    <td width="1" class="outliner"><img src="images/spacer.gif" border="0" width="1" height="1"></td>
    <td class="footerAndHeadercolour">&nbsp;</td>
    <td class="footerAndHeadercolour" align="right">
      Processing time:<?= time::stoptiming(); ?>&nbsp;
    </td>
      <td width="1" class="outliner"><img src="images/spacer.gif" border="0" width="1" height="1"></td>
  </tr>
   <tr> 
    <td colspan="4" class="outliner"><img src="images/spacer.gif" border="0" width="1" height="1"></td>
    </tr>
</table>
</body>
</html>

<? 

if($db!=''){
	debug::message("disconnecting from database");
	$db->disconnect();
} ?>