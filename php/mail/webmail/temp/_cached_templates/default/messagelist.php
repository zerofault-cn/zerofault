<?php /* Smarty version 1.5.2, created on 2003-09-24 13:30:06
         compiled from default/messagelist.htm */ ?>
<?php $this->_config_load($this->_tpl_vars['umLanguageFile'], "MessageList", 'local'); ?>
<?php smarty_func_um_welcome_message(array('messages' => $this->_tpl_vars['umNumMessages'],'unread' => $this->_tpl_vars['umNumUnread'],'boxname' => $this->_tpl_vars['umBoxName'],'var' => "umWelcomeMessage"), $this); if($this->_extract) { extract($this->_tpl_vars); $this->_extract=false; } ?>

<html>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<head>
	<title><?php echo $this->_config[0]['vars']['common_page_title']; ?>
 - <?php echo $this->_config[0]['vars']['messages_title']; ?>
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
			<form name=form1 action=msglist.php method=post>
			<table cellspacing=1 cellpadding=1 width="100%" border=0 bgcolor=White>
			<?php if ($this->_tpl_vars['umNumMessages'] > 0): ?>
				<tr height="20">
					<?php echo $this->_tpl_vars['umForms']; ?>

					<td colspan="6" class="default"> &nbsp;&nbsp;
					<?php echo $this->_tpl_vars['umWelcomeMessage']; ?>

					</td>
				</tr>
				<?php if ($this->_tpl_vars['umErrorMessage'] != ""): ?>
				<tr height="20">
					<td colspan="6" class="default"><font color=red><b> &nbsp;&nbsp;<?php echo $this->_tpl_vars['umErrorMessage']; ?>
</b></font></td>
				</tr>
				<?php endif; ?>
	
				<tr height="20">
				    <td width="5"  class="headers"><input type=checkbox name=chkall onclick="sel()"></td>
				    <td width="40"  class="headers"><img src="images/msg_read.gif" border="0" width="14" height="14" alt="">&nbsp;<img src="images/attach.gif" border="0" width="6" height="14" alt="">&nbsp;<img src="./images/prior_high.gif" width=5 height=11 border=0 alt=""></td>

					<?php if ($this->_tpl_vars['umFolder'] == "sent"): ?>
				    	<td width="160" class="headers">.:<b><a class="menu" href="javascript:sortby('toname')"><?php echo $this->_config[0]['vars']['to_hea']; ?>
<?php echo $this->_tpl_vars['umToArrow']; ?>
</a></b>:.</td>
					<?php else: ?>
				    	<td width="160" class="headers">.:<b><a class="menu" href="javascript:sortby('fromname')"><?php echo $this->_config[0]['vars']['from_hea']; ?>
<?php echo $this->_tpl_vars['umFromArrow']; ?>
</a></b>:.</td>
					<?php endif; ?>
				    <td width="210" class="headers">.: <b><a class="menu" href="javascript:sortby('subject')"><?php echo $this->_config[0]['vars']['subject_hea']; ?>
<?php echo $this->_tpl_vars['umSubjectArrow']; ?>
</a></b> :.</td>
				    <td width="120" class="headers">.:<b><a class="menu" href="javascript:sortby('date')"><?php echo $this->_config[0]['vars']['date_hea']; ?>
<?php echo $this->_tpl_vars['umDateArrow']; ?>
</a></b>:.</td>
				    <td width="70" class="headers">.:<b><a class="menu" href="javascript:sortby('size')"><?php echo $this->_config[0]['vars']['size_hea']; ?>
<?php echo $this->_tpl_vars['umSizeArrow']; ?>
</a></b>:.</td>
				</tr>
			
				<?php if (isset($this->_sections["i"])) unset($this->_sections["i"]);
$this->_sections["i"]['name'] = "i";
$this->_sections["i"]['loop'] = is_array($this->_tpl_vars['umMessageList']) ? count($this->_tpl_vars['umMessageList']) : max(0, (int)$this->_tpl_vars['umMessageList']);
$this->_sections["i"]['show'] = true;
$this->_sections["i"]['max'] = $this->_sections["i"]['loop'];
$this->_sections["i"]['step'] = 1;
$this->_sections["i"]['start'] = $this->_sections["i"]['step'] > 0 ? 0 : $this->_sections["i"]['loop']-1;
if ($this->_sections["i"]['show']) {
    $this->_sections["i"]['total'] = min(ceil(($this->_sections["i"]['step'] > 0 ? $this->_sections["i"]['loop'] - $this->_sections["i"]['start'] : $this->_sections["i"]['start']+1)/abs($this->_sections["i"]['step'])), $this->_sections["i"]['max']);
    if ($this->_sections["i"]['total'] == 0)
        $this->_sections["i"]['show'] = false;
} else
    $this->_sections["i"]['total'] = 0;
if ($this->_sections["i"]['show']):

            for ($this->_sections["i"]['index'] = $this->_sections["i"]['start'], $this->_sections["i"]['iteration'] = 1;
                 $this->_sections["i"]['iteration'] <= $this->_sections["i"]['total'];
                 $this->_sections["i"]['index'] += $this->_sections["i"]['step'], $this->_sections["i"]['iteration']++):
$this->_sections["i"]['rownum'] = $this->_sections["i"]['iteration'];
$this->_sections["i"]['index_prev'] = $this->_sections["i"]['index'] - $this->_sections["i"]['step'];
$this->_sections["i"]['index_next'] = $this->_sections["i"]['index'] + $this->_sections["i"]['step'];
$this->_sections["i"]['first']      = ($this->_sections["i"]['iteration'] == 1);
$this->_sections["i"]['last']       = ($this->_sections["i"]['iteration'] == $this->_sections["i"]['total']);
?>
				<tr height="20">
					<td class="default"><?php echo $this->_tpl_vars['umMessageList'][$this->_sections['i']['index']]['checkbox']; ?>
</td>
					<td class="default"><?php echo $this->_tpl_vars['umMessageList'][$this->_sections['i']['index']]['statusimg']; ?>
<?php echo $this->_tpl_vars['umMessageList'][$this->_sections['i']['index']]['attachimg']; ?>
<?php echo $this->_tpl_vars['umMessageList'][$this->_sections['i']['index']]['priorimg']; ?>
</td>

					<?php if ($this->_tpl_vars['umFolder'] == "sent"): ?>
						<?php if ($this->_tpl_vars['umAllowFromUrl']): ?>
							<td class="default">&nbsp;<acronym title="<?php echo $this->_config[0]['vars']['edit_mail']; ?>
<?php echo $this->_run_mod_handler('smarty_mod_default', true, $this->_run_mod_handler('smarty_mod_escape', true, $this->_tpl_vars['umMessageList'][$this->_sections['i']['index']]['tomail'], "html"), $this->_config[0]['vars']['no_recipient_text']); ?>
"><?php if ($this->_tpl_vars['umMessageList'][$this->_sections['i']['index']]['read'] == "false"): ?><b><?php endif; ?><a href="<?php echo $this->_tpl_vars['umMessageList'][$this->_sections['i']['index']]['composelinksent']; ?>
"><?php echo $this->_run_mod_handler('smarty_mod_default', true, $this->_run_mod_handler('smarty_mod_escape', true, $this->_run_mod_handler('smarty_mod_truncate', true, $this->_tpl_vars['umMessageList'][$this->_sections['i']['index']]['to'], 30, "...", true), "html"), $this->_config[0]['vars']['no_recipient_text']); ?>
</a><?php if ($this->_tpl_vars['umMessageList'][$this->_sections['i']['index']]['read'] == "false"): ?></b><?php endif; ?></acronym></td>
						<?php else: ?>
							<td class="default">&nbsp;<?php if ($this->_tpl_vars['umMessageList'][$this->_sections['i']['index']]['read'] == "false"): ?><b><?php endif; ?><?php echo $this->_run_mod_handler('smarty_mod_default', true, $this->_run_mod_handler('smarty_mod_escape', true, $this->_run_mod_handler('smarty_mod_truncate', true, $this->_tpl_vars['umMessageList'][$this->_sections['i']['index']]['to'], 30, "...", true), "html"), $this->_config[0]['vars']['no_recipient_text']); ?>
<?php if ($this->_tpl_vars['umMessageList'][$this->_sections['i']['index']]['read'] == "false"): ?></b><?php endif; ?></td>
						<?php endif; ?>
					<?php else: ?>
						<?php if ($this->_tpl_vars['umAllowFromUrl']): ?>
							<td class="default">&nbsp;<acronym title="<?php echo $this->_config[0]['vars']['reply_mail']; ?>
<?php echo $this->_run_mod_handler('smarty_mod_default', true, $this->_run_mod_handler('smarty_mod_escape', true, $this->_tpl_vars['umMessageList'][$this->_sections['i']['index']]['frommail'], "html"), $this->_config[0]['vars']['no_recipient_text']); ?>
"><?php if ($this->_tpl_vars['umMessageList'][$this->_sections['i']['index']]['read'] == "false"): ?><b><?php endif; ?><a href="<?php echo $this->_tpl_vars['umMessageList'][$this->_sections['i']['index']]['composelink']; ?>
"><?php echo $this->_run_mod_handler('smarty_mod_default', true, $this->_run_mod_handler('smarty_mod_escape', true, $this->_run_mod_handler('smarty_mod_truncate', true, $this->_tpl_vars['umMessageList'][$this->_sections['i']['index']]['from'], 30, "...", true), "html"), $this->_config[0]['vars']['no_sender_text']); ?>
</a><?php if ($this->_tpl_vars['umMessageList'][$this->_sections['i']['index']]['read'] == "false"): ?></b><?php endif; ?></acronym></td>
						<?php else: ?>
							<td class="default">&nbsp;<?php if ($this->_tpl_vars['umMessageList'][$this->_sections['i']['index']]['read'] == "false"): ?><b><?php endif; ?><?php echo $this->_run_mod_handler('smarty_mod_default', true, $this->_run_mod_handler('smarty_mod_escape', true, $this->_run_mod_handler('smarty_mod_truncate', true, $this->_tpl_vars['umMessageList'][$this->_sections['i']['index']]['from'], 30, "...", true), "html"), $this->_config[0]['vars']['no_sender_text']); ?>
<?php if ($this->_tpl_vars['umMessageList'][$this->_sections['i']['index']]['read'] == "false"): ?></b><?php endif; ?></td>
						<?php endif; ?>
					<?php endif; ?>

					<td class="default">&nbsp;<acronym title="<?php echo $this->_config[0]['vars']['read_mail']; ?>
<?php echo $this->_run_mod_handler('smarty_mod_default', true, $this->_run_mod_handler('smarty_mod_escape', true, $this->_tpl_vars['umMessageList'][$this->_sections['i']['index']]['subject'], "html"), $this->_config[0]['vars']['no_subject_text']); ?>
"><?php if ($this->_tpl_vars['umMessageList'][$this->_sections['i']['index']]['read'] == "false"): ?><b><?php endif; ?><a href="<?php echo $this->_tpl_vars['umMessageList'][$this->_sections['i']['index']]['readlink']; ?>
"><?php echo $this->_run_mod_handler('smarty_mod_default', true, $this->_run_mod_handler('smarty_mod_escape', true, $this->_run_mod_handler('smarty_mod_truncate', true, $this->_tpl_vars['umMessageList'][$this->_sections['i']['index']]['subject'], 30, "...", true), "html"), $this->_config[0]['vars']['no_subject_text']); ?>
</a><?php if ($this->_tpl_vars['umMessageList'][$this->_sections['i']['index']]['read'] == "false"): ?></b><?php endif; ?></acronym></td>
					<td class="cent"><?php if ($this->_tpl_vars['umMessageList'][$this->_sections['i']['index']]['read'] == "false"): ?><b><?php endif; ?><?php echo $this->_run_mod_handler('smarty_mod_date_format', true, $this->_tpl_vars['umMessageList'][$this->_sections['i']['index']]['date'], $this->_config[0]['vars']['date_format']); ?>
<?php if ($this->_tpl_vars['umMessageList'][$this->_sections['i']['index']]['read'] == "false"): ?></b><?php endif; ?></td>
					<td class="right"><?php if ($this->_tpl_vars['umMessageList'][$this->_sections['i']['index']]['read'] == "false"): ?><b><?php endif; ?><?php echo $this->_tpl_vars['umMessageList'][$this->_sections['i']['index']]['size']; ?>
Kb &nbsp;<?php if ($this->_tpl_vars['umMessageList'][$this->_sections['i']['index']]['read'] == "false"): ?></b><?php endif; ?></td>
				</tr>
				<?php endfor; endif; ?>
				
				<tr height="20">
					<td colspan="6" class="default">&nbsp; 
					<a class="menu" href="javascript:delemsg()"><?php echo $this->_config[0]['vars']['delete_selected_mnu']; ?>
</a> :: 
					<a class="menu" href="javascript:dropmsg()"><?php echo $this->_config[0]['vars']['drop_selected_mnu']; ?>
</a> :: 
					<a class="menu" href="javascript:movemsg()"><?php echo $this->_config[0]['vars']['move_selected_mnu']; ?>
</a> 
					<select name="aval_folders">
						<?php if (isset($this->_sections["i"])) unset($this->_sections["i"]);
$this->_sections["i"]['name'] = "i";
$this->_sections["i"]['loop'] = is_array($this->_tpl_vars['umAvalFolders']) ? count($this->_tpl_vars['umAvalFolders']) : max(0, (int)$this->_tpl_vars['umAvalFolders']);
$this->_sections["i"]['show'] = true;
$this->_sections["i"]['max'] = $this->_sections["i"]['loop'];
$this->_sections["i"]['step'] = 1;
$this->_sections["i"]['start'] = $this->_sections["i"]['step'] > 0 ? 0 : $this->_sections["i"]['loop']-1;
if ($this->_sections["i"]['show']) {
    $this->_sections["i"]['total'] = min(ceil(($this->_sections["i"]['step'] > 0 ? $this->_sections["i"]['loop'] - $this->_sections["i"]['start'] : $this->_sections["i"]['start']+1)/abs($this->_sections["i"]['step'])), $this->_sections["i"]['max']);
    if ($this->_sections["i"]['total'] == 0)
        $this->_sections["i"]['show'] = false;
} else
    $this->_sections["i"]['total'] = 0;
if ($this->_sections["i"]['show']):

            for ($this->_sections["i"]['index'] = $this->_sections["i"]['start'], $this->_sections["i"]['iteration'] = 1;
                 $this->_sections["i"]['iteration'] <= $this->_sections["i"]['total'];
                 $this->_sections["i"]['index'] += $this->_sections["i"]['step'], $this->_sections["i"]['iteration']++):
$this->_sections["i"]['rownum'] = $this->_sections["i"]['iteration'];
$this->_sections["i"]['index_prev'] = $this->_sections["i"]['index'] - $this->_sections["i"]['step'];
$this->_sections["i"]['index_next'] = $this->_sections["i"]['index'] + $this->_sections["i"]['step'];
$this->_sections["i"]['first']      = ($this->_sections["i"]['iteration'] == 1);
$this->_sections["i"]['last']       = ($this->_sections["i"]['iteration'] == $this->_sections["i"]['total']);
?>
							<option value="<?php echo $this->_run_mod_handler('smarty_mod_escape', true, $this->_tpl_vars['umAvalFolders'][$this->_sections['i']['index']]['path'], "html"); ?>
"><?php echo $this->_run_mod_handler('smarty_mod_escape', true, $this->_tpl_vars['umAvalFolders'][$this->_sections['i']['index']]['display'], "html"); ?>

						<?php endfor; endif; ?>
					</select>
					</td>
				</tr>
				<tr height="20">
					<td colspan="6" class="default"> &nbsp;&nbsp;
					<?php if ($this->_tpl_vars['umPreviousLink']): ?>
						<a href="<?php echo $this->_tpl_vars['umPreviousLink']; ?>
" class="navigation"><?php echo $this->_config[0]['vars']['previous_text']; ?>
</a> 
					<?php endif; ?>
					&nbsp;<?php echo $this->_tpl_vars['umNavBar']; ?>
&nbsp;
					<?php if ($this->_tpl_vars['umNextLink']): ?>
						<a href="<?php echo $this->_tpl_vars['umNextLink']; ?>
" class="navigation"><?php echo $this->_config[0]['vars']['next_text']; ?>
</a>
					<?php endif; ?>
					</td>
				</tr>
			<?php else: ?>		
				<tr height="50">
					<td colspan="6" class="cent"><br> &nbsp;&nbsp;<?php echo $this->_config[0]['vars']['no_messages']; ?>
 <b><?php echo $this->_run_mod_handler('smarty_mod_escape', true, $this->_tpl_vars['umBoxName'], "html"); ?>
</b><br><br></td>
				</tr>
			<?php endif; ?>
		
			<?php if ($this->_tpl_vars['umQuotaEnabled'] == 1): ?>
				<tr height="20">
					<td class="cent" colspan=6>&nbsp; <?php echo $this->_config[0]['vars']['quota_usage_info']; ?>
: <?php echo $this->_config[0]['vars']['quota_usage_used']; ?>
 <b><?php echo $this->_tpl_vars['umTotalUsed']; ?>
</b>Kb <?php echo $this->_config[0]['vars']['quota_usage_of']; ?>
 <b><?php echo $this->_tpl_vars['umQuotaLimit']; ?>
</b>Kb <?php echo $this->_config[0]['vars']['quota_usage_avail']; ?>
<br> <?php echo $this->_tpl_vars['umUsageGraph']; ?>
</td>
				</tr>
			<?php endif; ?>
			
			</table>
			</form>
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
