<?php /* Smarty version 1.5.2, created on 2003-09-24 13:32:39
         compiled from default/newmsg-result.htm */ ?>
<?php $this->_config_load($this->_tpl_vars['umLanguageFile'], "Newmessage", 'local'); ?>

<html>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<head>
	<title><?php echo $this->_config[0]['vars']['common_page_title']; ?>
</title>
	<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $this->_config[0]['vars']['default_char_set']; ?>
">
	<link rel="stylesheet" href="themes/default/webmail.css" type="text/css">
	<script language="JavaScript" src="themes/default/webmail.js" type="text/javascript"></script>

<?php echo $this->_tpl_vars['umJS']; ?>


</head>

<body leftmargin="0" marginwidth="0" topmargin="4" marginheight="3">

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include("default/pageheader.htm", array());
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<table align="center" width="758" border="0" cellspacing="0" cellpadding="0">
	<tr>
		
    	<td valign=top width="154"> 
			<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include("default/menu.htm", array());
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	    </td>
        <td width="1" bgcolor="#817B7B"><img width="1" height="1"></td>
		<td align="center" valign=top width="602" height=350 bgcolor=#ffffff >
			<table width="100%" border="0" cellspacing="1" cellpadding="0">
			<?php if ($this->_tpl_vars['umMailSent']): ?>
				<tr height=50>
					<td class=cent>
						<?php echo $this->_config[0]['vars']['result_success']; ?>
<br><br>
						<a href="msglist.php?sid=<?php echo $this->_tpl_vars['umSid']; ?>
&tid=<?php echo $this->_tpl_vars['umTid']; ?>
&lid=<?php echo $this->_tpl_vars['umLid']; ?>
"><?php echo $this->_config[0]['vars']['nav_msglist']; ?>
</a>
						&nbsp;&nbsp;&nbsp;&nbsp;
						<a href="newmsg.php?sid=<?php echo $this->_tpl_vars['umSid']; ?>
&tid=<?php echo $this->_tpl_vars['umTid']; ?>
&lid=<?php echo $this->_tpl_vars['umLid']; ?>
"><?php echo $this->_config[0]['vars']['nav_continue']; ?>
</a>
					</td>
				</tr>
			<?php else: ?>
				<tr height=50>
					<td class=cent>
						<?php echo $this->_config[0]['vars']['result_error']; ?>
<br><br>
						<font color=red><?php echo $this->_tpl_vars['umErrorMessage']; ?>
</font><br><br>
						<a href="javascript:history.go(-1)"><?php echo $this->_config[0]['vars']['nav_back']; ?>
</a>
					</td>
				</tr>
			<?php endif; ?>
			</table>
		</td>
		<td width="1" bgcolor="#817B7B"><img width="1" height="1"></td>
	</tr>
</table>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include("default/pagefooter.htm", array());
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

</body>
</html>
