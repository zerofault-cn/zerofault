<?php /* Smarty version 1.5.2, created on 2003-09-24 13:32:08
         compiled from default/readmsg.htm */ ?>
<?php $this->_config_load($this->_tpl_vars['umLanguageFile'], "Readmsg", 'local'); ?>
<html>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<head>
	<title><?php echo $this->_config[0]['vars']['common_page_title']; ?>
 - <?php echo $this->_run_mod_handler('smarty_mod_escape', true, $this->_tpl_vars['umPageTitle'], "html"); ?>
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
			<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
				<tr>
					<td bgcolor=white>
						<table width="100%" border=0 cellspacing=1 cellpadding=0>
							<?php echo $this->_tpl_vars['umReplyForm']; ?>
			
							<tr height="20">
								<td class=default colspan=2>&nbsp; 
									<?php if ($this->_tpl_vars['umHavePrevious'] == 1): ?>
									<a class="menu" href="<?php echo $this->_tpl_vars['umPreviousLink']; ?>
" title="<?php echo $this->_run_mod_handler('smarty_mod_escape', true, $this->_tpl_vars['umPreviousSubject'], "html"); ?>
"><?php echo $this->_config[0]['vars']['previous_mnu']; ?>
</a> :: 
									<?php endif; ?>
									<?php if ($this->_tpl_vars['umHaveNext'] == 1): ?>
									<a class="menu" href="<?php echo $this->_tpl_vars['umNextLink']; ?>
" title="<?php echo $this->_run_mod_handler('smarty_mod_escape', true, $this->_tpl_vars['umNextSubject'], "html"); ?>
"><?php echo $this->_config[0]['vars']['next_mnu']; ?>
</a> :: 
									<?php endif; ?>
									<a class="menu" href="javascript:goback()"><?php echo $this->_config[0]['vars']['back_mnu']; ?>
</a> :: 
									<a class="menu" href="javascript:reply()"><?php echo $this->_config[0]['vars']['reply_mnu']; ?>
</a> :: 
									<a class="menu" href="javascript:replyall()"><?php echo $this->_config[0]['vars']['reply_all_mnu']; ?>
</a> :: 
									<a class="menu" href="javascript:forward()"><?php echo $this->_config[0]['vars']['forward_mnu']; ?>
</a> :: 
									<a class="menu" href="javascript:catch_addresses()"><?php echo $this->_config[0]['vars']['catch_address']; ?>
</a> :: 
									<a class="menu" href="javascript:printit()"><?php echo $this->_config[0]['vars']['print_mnu']; ?>
</a> :: 
									<a class="menu" href="javascript:headers()"><?php echo $this->_config[0]['vars']['headers_mnu']; ?>
</a>
								</td>
							</tr>
	
							<tr bgcolor=white height="20">
								<td width="20%" class="headerright"><?php echo $this->_config[0]['vars']['from_hea']; ?>
 &nbsp;</td>
								<td class="default">
								<?php if (isset($this->_sections["i"])) unset($this->_sections["i"]);
$this->_sections["i"]['name'] = "i";
$this->_sections["i"]['loop'] = is_array($this->_tpl_vars['umFromList']) ? count($this->_tpl_vars['umFromList']) : max(0, (int)$this->_tpl_vars['umFromList']);
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
								 &nbsp;<a href="<?php echo $this->_tpl_vars['umFromList'][$this->_sections['i']['index']]['link']; ?>
" title="<?php echo $this->_run_mod_handler('smarty_mod_escape', true, $this->_tpl_vars['umFromList'][$this->_sections['i']['index']]['title'], "html"); ?>
"><?php echo $this->_run_mod_handler('smarty_mod_escape', true, $this->_run_mod_handler('smarty_mod_default', true, $this->_tpl_vars['umFromList'][$this->_sections['i']['index']]['name'], $this->_config[0]['vars']['no_sender_text']), "html"); ?>
</a>
								<?php endfor; endif; ?>
								</td>
							</tr>
							<tr bgcolor=white height="20">
								<td class="headerright"><?php echo $this->_config[0]['vars']['to_hea']; ?>
 &nbsp;</td>
								<td class="default">
								<?php if (isset($this->_sections["i"])) unset($this->_sections["i"]);
$this->_sections["i"]['name'] = "i";
$this->_sections["i"]['loop'] = is_array($this->_tpl_vars['umTOList']) ? count($this->_tpl_vars['umTOList']) : max(0, (int)$this->_tpl_vars['umTOList']);
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
?><?php if ($this->_tpl_vars['firstto'] == "no"): ?>;<?php endif; ?>&nbsp;<a href="<?php echo $this->_tpl_vars['umTOList'][$this->_sections['i']['index']]['link']; ?>
" title="<?php echo $this->_run_mod_handler('smarty_mod_escape', true, $this->_tpl_vars['umTOList'][$this->_sections['i']['index']]['title'], "html"); ?>
"><?php echo $this->_run_mod_handler('smarty_mod_escape', true, $this->_tpl_vars['umTOList'][$this->_sections['i']['index']]['name'], "html"); ?>
</a><?php smarty_func_assign(array('var' => "firstto",'value' => "no"), $this); if($this->_extract) { extract($this->_tpl_vars); $this->_extract=false; } ?><?php endfor; else: ?>&nbsp;<?php echo $this->_config[0]['vars']['no_recipient_text']; ?>
<?php endif; ?>
								</td>
							</tr>	
	
							<?php if ($this->_tpl_vars['umHaveCC']): ?>
								<tr bgcolor=white height="20">
									<td class="headerright"><?php echo $this->_config[0]['vars']['cc_hea']; ?>
 &nbsp;</td>
									<td class="default">
									<?php if (isset($this->_sections["i"])) unset($this->_sections["i"]);
$this->_sections["i"]['name'] = "i";
$this->_sections["i"]['loop'] = is_array($this->_tpl_vars['umCCList']) ? count($this->_tpl_vars['umCCList']) : max(0, (int)$this->_tpl_vars['umCCList']);
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
?><?php if ($this->_tpl_vars['firstcc'] == "no"): ?>;<?php endif; ?>&nbsp;<a href="<?php echo $this->_tpl_vars['umCCList'][$this->_sections['i']['index']]['link']; ?>
" title="<?php echo $this->_run_mod_handler('smarty_mod_escape', true, $this->_tpl_vars['umCCList'][$this->_sections['i']['index']]['title'], "html"); ?>
"><?php echo $this->_run_mod_handler('smarty_mod_escape', true, $this->_tpl_vars['umCCList'][$this->_sections['i']['index']]['name'], "html"); ?>
</a><?php smarty_func_assign(array('var' => "firstcc",'value' => "no"), $this); if($this->_extract) { extract($this->_tpl_vars); $this->_extract=false; } ?><?php endfor; endif; ?>
									</td>
								</tr>	
							<?php endif; ?>
	
							<tr bgcolor=white height="20">
								<td class="headerright"><?php echo $this->_config[0]['vars']['subject_hea']; ?>
 &nbsp;</td>
								<td class="default"> &nbsp;<?php echo $this->_run_mod_handler('smarty_mod_escape', true, $this->_run_mod_handler('smarty_mod_truncate', true, $this->_run_mod_handler('smarty_mod_default', true, $this->_tpl_vars['umSubject'], $this->_config[0]['vars']['no_subject_text']), 100, "...", true), "html"); ?>
</td>
							</tr>	
							<tr bgcolor=white height="20">
								<td class="headerright"><?php echo $this->_config[0]['vars']['date_hea']; ?>
 &nbsp;</td>
								<td class="default"> &nbsp;<?php echo $this->_run_mod_handler('smarty_mod_date_format', true, $this->_tpl_vars['umDate'], $this->_config[0]['vars']['date_format']); ?>
</td>
							</tr>	
							<?php if ($this->_tpl_vars['umHaveAttachments']): ?>
								<tr bgcolor=silver>
									<td class="headerright"><?php echo $this->_config[0]['vars']['attach_hea']; ?>
 &nbsp;</td>
									<td>
										<table width="100%" border=0 cellspacing=1 cellpadding=0>
											<tr bgcolor=#f1f1f1 height="20">
												<td class="headers" width="60%"> &nbsp;<b><?php echo $this->_config[0]['vars']['attch_name_hea']; ?>
</b> (<?php echo $this->_config[0]['vars']['attch_force_hea']; ?>
)</td>
												<td class="headers"> &nbsp;<b><?php echo $this->_config[0]['vars']['attch_size_hea']; ?>
</b></td>
												<td class="headers"> &nbsp;<b><?php echo $this->_config[0]['vars']['attch_type_hea']; ?>
</b></td>
											</tr>
											<?php if (isset($this->_sections["i"])) unset($this->_sections["i"]);
$this->_sections["i"]['name'] = "i";
$this->_sections["i"]['loop'] = is_array($this->_tpl_vars['umAttachList']) ? count($this->_tpl_vars['umAttachList']) : max(0, (int)$this->_tpl_vars['umAttachList']);
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
												<tr bgcolor=white height="20">
													<td class="default">&nbsp;
													<?php if ($this->_tpl_vars['umAttachList'][$this->_sections['i']['index']]['normlink'] == ""): ?>
														<img src="<?php echo $this->_tpl_vars['umAttachList'][$this->_sections['i']['index']]['iconfile']; ?>
" width="16" height="16" border="0">&nbsp;<?php echo $this->_run_mod_handler('smarty_mod_escape', true, $this->_run_mod_handler('smarty_mod_truncate', true, $this->_tpl_vars['umAttachList'][$this->_sections['i']['index']]['name'], 30, "...", true), "html"); ?>
&nbsp;<a href="<?php echo $this->_tpl_vars['umAttachList'][$this->_sections['i']['index']]['downlink']; ?>
"><img src="./images/download.gif" width="16" height="16" border="0" alt=""></a>
													<?php else: ?> 
														<a href="<?php echo $this->_tpl_vars['umAttachList'][$this->_sections['i']['index']]['normlink']; ?>
"><img src="<?php echo $this->_tpl_vars['umAttachList'][$this->_sections['i']['index']]['iconfile']; ?>
" width="16" height="16" border="0">&nbsp;<?php echo $this->_run_mod_handler('smarty_mod_escape', true, $this->_run_mod_handler('smarty_mod_truncate', true, $this->_tpl_vars['umAttachList'][$this->_sections['i']['index']]['name'], 30, "...", true), "html"); ?>
</a>&nbsp;<a href="<?php echo $this->_tpl_vars['umAttachList'][$this->_sections['i']['index']]['downlink']; ?>
"><img src="./images/download.gif" width="16" height="16" border="0" alt=""></a>
													<?php endif; ?>
													</td>
													<td class="right"><?php echo $this->_tpl_vars['umAttachList'][$this->_sections['i']['index']]['size']; ?>
Kb &nbsp;</td>
													<td class="default"> &nbsp;<?php echo $this->_tpl_vars['umAttachList'][$this->_sections['i']['index']]['type']; ?>
</td>
												</tr>
											<?php endfor; endif; ?>
										</table>
									</td>
								</tr>	
							<?php endif; ?>
							<tr height="20">
								<td colspan=2 class="default">
									<table width="100%" border=0 cellspacing=1 cellpadding=0>
										<tr bgcolor=white>
											<td width="60%"<?php echo $this->_tpl_vars['umBackImg']; ?>
<?php echo $this->_tpl_vars['umBackColor']; ?>
><font color=black><?php echo $this->_tpl_vars['umMessageBody']; ?>
</font></td>
										</tr>
									</table>
								</td>
							</tr>
							<tr height="20">
								<form name=move action="msglist.php" method=POST>
										<?php echo $this->_tpl_vars['umDeleteForm']; ?>

										<td class=default colspan=2>
										<a class="menu" href="javascript:deletemsg()"><?php echo $this->_config[0]['vars']['delete_mnu']; ?>
</a> ::
										<a class="menu" href="javascript:movemsg()"><?php echo $this->_config[0]['vars']['move_mnu']; ?>
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
								</form>
							</tr>
						</table>
					</td>
				</tr>
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