<form action="rss_add_source_2.php" method=post name=add onsubmit="return check()">
<table width="100%" border=0 cellspacing=1 cellpadding=2 bgcolor=black>
<caption>���RSS��Դ</caption>
<tr bgcolor=white>
	<td align=right>RSS����:</td>
	<td><input name=rss_source_name size=20></td>
</tr>
<tr bgcolor=white>
	<td align=right><span style="color:red">*</span>RSS��URL:</td>
	<td><input name=rss_source_url size=50></td>
</tr>
<tr bgcolor=white>
	<td align=right>��ҪԤȡ:</td>
	<td><input type=checkbox name=prefetch value=1></td>
</tr>
<tr bgcolor=white>
	<td align=right></td>
	<td><input type=submit value="&nbsp;&nbsp;��&nbsp;&nbsp;��&nbsp;&nbsp;" ></td>
</tr>
</table>
<input type=hidden name=select_flag>
</form>