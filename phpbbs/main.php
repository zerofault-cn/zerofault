<?
include_once $phpbbs_root_path.'/include/db_connect.php';
include_once $phpbbs_root_path.'/main_functions.php';
?>
<table width=760 border=0 cellpadding=0 cellspacing=0>
<tr><td width=170 height=10><img src="image/point1.gif" width="100%" height=1></td>
	<td width=10><img src="image/jiao1.gif" width=10 height=10></td>
	<td width=400><img src="image/point1.gif" width="100%" height=1></td>
	<td width=10><img src="image/jiao1.gif" width=10 height=10></td>
	<td width=170><img src="image/point1.gif" width="100%" height=1></td>
</tr>
<tr>
	<td width=170 valign=top>
	<?
	serverInfoTable();
	?>
	</td>
	<td width=10 height="100%" align="center"><img height="100%" src="image/point1.gif" width=1></td>
	<td width=400 valign=top>
	<?
	msgTable('message',7);
	?>
	</td>
	<td width=10 height="100%" align="center"><img height="100%" src="image/point1.gif" width=1></td>
	<td width=170 valign=top>
	<?
	newmusicTable();
	?>
	</td>
</tr>
</table>
<table width=760 border=0 cellpadding=0 cellspacing=0>
<tr>
	<td width=170 valign=top>
	<?
	astroTable();
	searchTable();
	?></td>
	<td width=10 height="100%" align="center"><img height="100%" src="image/point1.gif" width=1></td>
	<td width=400 valign=top>
	<?
	msgTable('tech',10);
	?></td>
	<td width=10 height="100%" align="center"><img height="100%" src="image/point1.gif" width=1></td>
	<td width=170 valign=top>
	<?
	newdownTable();
	?></td>
</tr>
</table>
<table width=760 border=0 cellpadding=0 cellspacing=0>
<tr>
	<td width=170 valign=top>
	<?
	jokedailyTable();
	?>
	</td>
	<td width=10 height="100%" align="center"><img height="100%" src="image/point1.gif" width=1></td>
	<td width=300 valign=top>
	<?
	msgTable('feeling',15);
	?></td>
	<td width=10 height="100%" align="center"><img height="100%" src="image/point1.gif" width=1></td>
	<td width=270 valign=top>
	<?
	msgtable('joke',15);
	?></td>
</tr>
</table>

