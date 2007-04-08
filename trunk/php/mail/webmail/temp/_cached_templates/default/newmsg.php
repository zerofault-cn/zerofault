<?php /* Smarty version 1.5.2, created on 2003-09-24 13:31:56
         compiled from default/newmsg.htm */ ?>
<?php $this->_config_load($this->_tpl_vars['umLanguageFile'], "Newmessage", 'local'); ?>
<html>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<head>
	<title><?php echo $this->_config[0]['vars']['common_page_title']; ?>
 - <?php echo $this->_config[0]['vars']['newmsg_title']; ?>
</title>
	<link rel="stylesheet" href="themes/default/webmail.css" type="text/css">
	<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $this->_config[0]['vars']['default_char_set']; ?>
">
	<script language="JavaScript" src="themes/default/webmail.js" type="text/javascript"></script>

<?php echo $this->_tpl_vars['umJS']; ?>


</head>

<?php if ($this->_tpl_vars['umAdvancedEditor'] == 1): ?>
	<div id="hiddenCompose" style="position: absolute; left: 3; top: -100; visibility: hidden; z-index: 3">	      
	<form name="hiddencomposeForm">
	<textarea name="hiddencomposeFormTextArea"><?php echo $this->_run_mod_handler('smarty_mod_escape', true, $this->_tpl_vars['umBody'], "html"); ?>
</textarea>
	</form>
	</div>
<?php endif; ?>

<body leftmargin="0" marginwidth="0" topmargin="4" marginheight="3">

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include("default/pageheader.htm", array());
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<table align="center" width="758" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<form name=composeForm method=post action="newmsg.php" onSubmit="return false;">
		<?php echo $this->_tpl_vars['umForms']; ?>


		
		<td valign=top width="15%"> 
			<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include("default/menu.htm", array());
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
		</td>
        <td width="1" bgcolor="#817B7B"><img width="1" height="1"></td>
		<td align="center" valign=top width="602" height=350 bgcolor=#ffffff >
			<table width="100%" border=0 cellspacing=1 cellpadding=0 >
				<tr bgcolor=white>
					<td width="16%" height="18" class="headerright"><a href="javascript:addrpopup()"><img src="images/bookmark_it.gif" width="16" height="16" border="0" alt="<?php echo $this->_config[0]['vars']['address_tip']; ?>
"></a> &nbsp; <?php echo $this->_config[0]['vars']['to_hea']; ?>
 &nbsp;</td>
					<td class="default">&nbsp;<?php echo $this->_tpl_vars['umTo']; ?>

						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input type=button name=bt_enviar value="<?php echo $this->_config[0]['vars']['send_text']; ?>
" onClick=enviar() class=button>
					</td>
				</tr>	
				<tr bgcolor=white>
					<td height="18" class="headerright"><a href="javascript:addrpopup()"><img src="images/bookmark_it.gif" width="16" height="16" border="0" alt="<?php echo $this->_config[0]['vars']['address_tip']; ?>
"></a> &nbsp; <?php echo $this->_config[0]['vars']['cc_hea']; ?>
 &nbsp;</td>
					<td class="default">&nbsp;<?php echo $this->_tpl_vars['umCc']; ?>
</td>
				</tr>	
				<tr bgcolor=white>
					<td height="18" class="headerright"><a href="javascript:addrpopup()"><img src="images/bookmark_it.gif" width="16" height="16" border="0" alt="<?php echo $this->_config[0]['vars']['address_tip']; ?>
"></a> &nbsp; <?php echo $this->_config[0]['vars']['bcc_hea']; ?>
 &nbsp;</td>
					<td class="default">&nbsp;<?php echo $this->_tpl_vars['umBcc']; ?>
</td>
				</tr>	
				
				<tr bgcolor=white>
					<td height="18" class="headerright"><?php echo $this->_config[0]['vars']['subject_hea']; ?>
 &nbsp;</td>
					<td class="default">&nbsp;<?php echo $this->_tpl_vars['umSubject']; ?>
</td>
				</tr>	
				
				<tr>
					<td  class="headerright"><?php echo $this->_config[0]['vars']['priority_text']; ?>
 &nbsp;</td>
					<td class="default">&nbsp;<select name="priority">
							<option value="1"<?php if ($this->_tpl_vars['umPriority'] == 1): ?> selected<?php endif; ?>><?php echo $this->_config[0]['vars']['priority_high']; ?>

							<option value="3"<?php if ($this->_tpl_vars['umPriority'] == 3): ?> selected<?php endif; ?>><?php echo $this->_config[0]['vars']['priority_normal']; ?>

							<option value="5"<?php if ($this->_tpl_vars['umPriority'] == 5): ?> selected<?php endif; ?>><?php echo $this->_config[0]['vars']['priority_low']; ?>

						</select>
						
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						
						<?php if ($this->_tpl_vars['umAdvancedEditor'] == 1): ?>
							<a class=menu href="javascript:textmode()"><?php echo $this->_config[0]['vars']['text_mode']; ?>
</a>
						<?php else: ?>
							<a class=menu href="javascript:htmlmode()"><?php echo $this->_config[0]['vars']['html_mode']; ?>
</a>
						<?php endif; ?>
<!--						
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input type=button name=bt_envspell value="Spell Check" onClick=envspell() class=button>					</td>
-->
				</tr>


				<tr>
					<td class="headerright"><?php echo $this->_config[0]['vars']['content_hea']; ?>
 &nbsp;</td>
					<td class="default">
					<?php if ($this->_tpl_vars['umAdvancedEditor'] == 1): ?>
						<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include("default/advanced-editor.htm", array());
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
						<div id="hiddenCompose2" style="position: absolute; left: 3; top: -100; visibility: hidden; z-index: 3">	      
							<textarea cols=50 rows=15 name=body><?php echo $this->_run_mod_handler('smarty_mod_escape', true, $this->_tpl_vars['umBody'], "html"); ?>
</textarea>
						</div>
					<?php else: ?>
						<textarea cols=50 rows=15 name=body><?php echo $this->_run_mod_handler('smarty_mod_escape', true, $this->_tpl_vars['umBody'], "html"); ?>
</textarea>
					<?php endif; ?>

					</td>
				</tr>

				<tr bgcolor=white>
					<td height="20" class="headerright"><?php echo $this->_config[0]['vars']['attach_hea']; ?>
 &nbsp;</td>
					<td>
						<table width="100%" border=0 cellspacing=1 cellpadding=0>
							<?php if ($this->_tpl_vars['umHaveAttachs'] == 1): ?>
								<tr height=15>
									<td width="45%" class="headers"><?php echo $this->_config[0]['vars']['attch_name_hea']; ?>
</td>
									<td width="15%" class="headerright"><?php echo $this->_config[0]['vars']['attch_size']; ?>
 &nbsp;</td>
									<td width="30%" class="headers"><?php echo $this->_config[0]['vars']['attch_type_hea']; ?>
</td>
									<td width="10%" class="headers"><?php echo $this->_config[0]['vars']['attch_dele_hea']; ?>
</td>
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
									<tr height=15>
										<td width="50%" class="default"><img src="<?php echo $this->_tpl_vars['umAttachList'][$this->_sections['i']['index']]['iconfile']; ?>
" width="16" height="16" border="0"> &nbsp;<?php echo $this->_run_mod_handler('smarty_mod_escape', true, $this->_tpl_vars['umAttachList'][$this->_sections['i']['index']]['name'], "html"); ?>
</td>
										<td width="10%" class="right"><?php echo $this->_tpl_vars['umAttachList'][$this->_sections['i']['index']]['size']; ?>
Kb&nbsp;</td>
										<td width="30%" class="default"> &nbsp;<?php echo $this->_run_mod_handler('smarty_mod_truncate', true, $this->_tpl_vars['umAttachList'][$this->_sections['i']['index']]['type'], 23, "...", true); ?>
</td>
										<td width="10%" class="default"> &nbsp;<a href="<?php echo $this->_tpl_vars['umAttachList'][$this->_sections['i']['index']]['link']; ?>
">OK</a></td>
									</tr>
								<?php endfor; endif; ?>
							<?php else: ?>							
								<tr height=15>
									<td width="100%" class="headers" colspan=4> &nbsp;<?php echo $this->_config[0]['vars']['attch_no_hea']; ?>
</td>
								</tr>
							<?php endif; ?>
						</table>
						<table width="100%" border=0 cellspacing=1 cellpadding=0>
							<tr>
								<td width="100%" class="default"> &nbsp;<a href="javascript:upwin()" class="menu"><?php echo $this->_config[0]['vars']['attch_add_new']; ?>
</a></td>
							</tr>
						</table>
					</td>
				</tr>	

				<?php if ($this->_tpl_vars['umAddSignature']): ?>
				<tr>
					<td class="headerright"><?php echo $this->_config[0]['vars']['signature_name']; ?>
 &nbsp;</td>
					<td class="default">&nbsp;<select name="sign_name" onchange="javascript:chgsig();">
							<?php if (isset($this->_sections["i"])) unset($this->_sections["i"]);
$this->_sections["i"]['name'] = "i";
$this->_sections["i"]['loop'] = is_array($this->_tpl_vars['umSignatureList']) ? count($this->_tpl_vars['umSignatureList']) : max(0, (int)$this->_tpl_vars['umSignatureList']);
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
						 		<option value="<?php echo $this->_tpl_vars['umSignatureList'][$this->_sections['i']['index']]['content']; ?>
"><?php echo $this->_tpl_vars['umSignatureList'][$this->_sections['i']['index']]['name']; ?>
</option>
							<?php endfor; endif; ?>
						</select>
					</td>
				</tr>
				<tr>
					<td  class="headerright"><?php echo $this->_config[0]['vars']['signature_content']; ?>
 &nbsp;</td>
					<td class="default">&nbsp;<textarea name=sign cols=50 rows=5></textarea></td>
				</tr>
				<?php endif; ?>

				<tr height=30>
					<td class="default" colspan=2 align=center>
						<input type=hidden name=bgcolor value="<?php echo $this->_config[0]['vars']['umBgColor']; ?>
">
						<input type=button name=bt_enviar value="<?php echo $this->_config[0]['vars']['send_text']; ?>
" onClick=enviar() class=button>
					</td>
				</tr>	
			</table>
		</td>
		<td width="1" bgcolor="#817B7B"><img width="1" height="1"></td>
		</form>
	</tr>
</table>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include("default/pagefooter.htm", array());
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

</body>
</html> 