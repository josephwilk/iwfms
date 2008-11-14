<!-- LOGIN -->

<table border="0" cellpadding="2" cellspacing="0" width="300" align="center">
<tr>
<td class="bodybold" colspan="2">LOGIN</td>
</tr>
<tr>
<td height="1" colspan="2"><hr size="1"></td>
</tr>
<tr>
<td class="body">
Enter your login details below and press submit.
</tr>
<tr>
<td height="1" colspan="2"><hr size="1"></td>
</tr>
</table>
<form name="logger" method="post" action="authenticate.php">
<input type="hidden" name="mode" value="login">
<table border="0" cellpadding="2" cellspacing="0" width="300" align="center">
<tr> 
<td class="bodybold"><b><u>U</u>sername:</b></td>
<td>
<input accesskey="u" type="text" name="username" size="25" maxlength="16">
</td>
</tr>
<tr> 
<td class="bodybold"><b><u>P</u>assword:</b></td>
<td>
<input accesskey="p" type="password" size="25" name="password" maxlength="16">
</td>
</tr>
<tr> 
<td colspan="2" align="center"><br>
<input type="submit" name="submit" value="Submit" ></td>
</tr>
<tr>
<td height="1" colspan="2"><hr size="1"></td>
</tr>
</table>
</form>
<!-- LOGIN -->