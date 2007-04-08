<?php /* Smarty version 1.5.2, created on 2003-09-24 13:36:27
         compiled from default/register.htm */ ?>
<?php $this->_config_load($this->_tpl_vars['umLanguageFile'], "Register", 'local'); ?>
<html>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<head>
	<title><?php echo $this->_config[0]['vars']['common_page_title']; ?>
 - <?php echo $this->_config[0]['vars']['reg_title']; ?>
</title>
	<link rel="stylesheet" href="themes/default/webmail.css" type="text/css">
	<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $this->_config[0]['vars']['default_char_set']; ?>
">
	<script language="JavaScript" src="themes/default/webmail.js" type="text/javascript"></script>
	<?php echo $this->_tpl_vars['umJS']; ?>


<?php echo '
<script language="JavaScript">
	function CheckNumChar(str)
	{
	        var i,j,strTemp;
	        strTemp=\'0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ_.-\';
	        for (i=0;i<str.length;i++)  {
	             j=strTemp.indexOf(str.charAt(i));
	             if (j==-1)  {
	                  //说明不是数字或字符
	                  return 0;
	             }
	        }
	        //说明是数字或字符
	        return 1;
	}
	
	function checkValue() {
		sSix		= \'\';
		sUser		= \'\';
		sPassword		= \'\';
		sConfirmPwd		= \'\';
		
		frm = document.forms[0];
		if(frm.six){
			if (frm.six.options)
				sSix = frm.six.options[frm.six.selectedIndex].value;
			else
				sSix = frm.six.value;
		}
			
		if(frm.f_user)
			sUser = frm.f_user.value;
		if(frm.f_password)
			sPassword = frm.f_password.value;
		if(frm.f_confirmpwd)
			sConfirmPwd = frm.f_confirmpwd.value;
			
		if (sSix == \'\' || sUser == \'\' 
			|| sPassword == \'\' || sConfirmPwd == \'\'){
'; ?>

			alert('<?php echo $this->_config[0]['vars']['reg_empty']; ?>
');
<?php echo '
			return;
		}
			
		if (sPassword != sConfirmPwd){
'; ?>

			alert('<?php echo $this->_config[0]['vars']['pwd_pwdnoequal']; ?>
');
<?php echo '
			return;
		}
			
		if (CheckNumChar(sUser) == 0){
'; ?>

			alert('<?php echo $this->_config[0]['vars']['reg_invaildchar']; ?>
');
<?php echo '
			return;
		}
			
		frm.submit();
	}
	
	function goBack() {
		location.href=\'index.php\';
	}
</script>
'; ?>


</head>

<body leftmargin="0" marginwidth="0" topmargin="4" marginheight="3">
<table align="center" width="758" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td width="553"><img src="themes/default/images/reghead.jpg" width="553" height="116"></td>
      <td background="themes/default/images/reghead_bg.jpg"><img src="themes/default/images/winmail_logo.gif" width="180" height="116"></td>
    </tr>
</table>

<?php if ($this->_tpl_vars['umShowType'] != 1): ?>
<table align="center" width="758" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td height="300" align="center" bgcolor="#FFFFFF">
			<table align="center"  cellspacing=1 cellpadding=1 width="60%"  border=0 bgcolor="#333333">
				<form name=form1 action=register.php method=POST>
				<input type=hidden name=lid value="<?php echo $this->_tpl_vars['umLid']; ?>
">
				<input type=hidden name=tid value="<?php echo $this->_tpl_vars['umTid']; ?>
">
				<input type=hidden name=save value="yes">
				
          		<tr align="center" height="30"> 
					<td colspan=2 class=headers><b><?php echo $this->_config[0]['vars']['reg_title']; ?>
</b></td>
				</tr>
          		<tr height="20"> 
					<td class=headerright width="25%"><?php echo $this->_config[0]['vars']['reg_mailbox']; ?>
&nbsp;</td>
					<td class=default>&nbsp;<input type=text name=f_user size=16 maxlength=64 value="<?php echo $this->_run_mod_handler('smarty_mod_escape', true, $this->_tpl_vars['umUser'], "html"); ?>
" class="textbox">
					<?php if ($this->_tpl_vars['umAvailableServers'] != 0): ?><?php echo $this->_tpl_vars['umServer']; ?>
<?php endif; ?><font color=#ff0000>*</font></td>
				</tr>
          		<tr height="20"> 
					<td class=headerright><?php echo $this->_config[0]['vars']['reg_password']; ?>
&nbsp;</td>
					<td class=default>&nbsp;<input type=password name=f_password size=30 maxlength=64 class="textbox"><font color=#ff0000>*</font></td>
				</tr>
          		<tr height="20"> 
					<td class=headerright width="25%"><?php echo $this->_config[0]['vars']['reg_confirmpwd']; ?>
&nbsp;</td>
					<td class=default>&nbsp;<input type=password name=f_confirmpwd size=30 maxlength=64 class="textbox"><font color=#ff0000>*</font></td>
				</tr>
          		<tr height="20"> 
					<td class=headerright width="25%"><?php echo $this->_config[0]['vars']['reg_fullname']; ?>
&nbsp;</td>
					<td class=default>&nbsp;<input type=text name=f_fullname size=30 maxlength=120 value="<?php echo $this->_run_mod_handler('smarty_mod_escape', true, $this->_tpl_vars['umFullName'], "html"); ?>
" class="textbox"></td>
				</tr>
				<tr height="20"> 
						<td class=headerright width="25%"><?php echo $this->_config[0]['vars']['reg_ldaphomeaddress']; ?>
&nbsp;</td>
						<td class=default>&nbsp;<input type=text name=f_homeaddress size=30 maxlength=256 value="<?php echo $this->_run_mod_handler('smarty_mod_escape', true, $this->_tpl_vars['umHomeAddress'], "html"); ?>
" class="textbox"></td>
				</tr>
				<tr height="20"> 
						<td class=headerright width="25%"><?php echo $this->_config[0]['vars']['reg_ldaphomephone']; ?>
&nbsp;</td>
						<td class=default>&nbsp;<input type=text name=f_homephone size=30 maxlength=32 value="<?php echo $this->_run_mod_handler('smarty_mod_escape', true, $this->_tpl_vars['umHomePhone'], "html"); ?>
" class="textbox"></td>
				</tr>
				<tr height="20"> 
						<td class=headerright width="25%"><?php echo $this->_config[0]['vars']['reg_ldapmobile']; ?>
&nbsp;</td>
						<td class=default>&nbsp;<input type=text name=f_mobile size=30 maxlength=32 value="<?php echo $this->_run_mod_handler('smarty_mod_escape', true, $this->_tpl_vars['umMobile'], "html"); ?>
" class="textbox"></td>
				</tr>
				
				<tr height="20"> 
						<td class=headerright width="25%"><?php echo $this->_config[0]['vars']['reg_ldaporganizationunit']; ?>
&nbsp;</td>
						<td class=default>&nbsp;<input type=text name=f_organizationunit size=30 maxlength=128 value="<?php echo $this->_run_mod_handler('smarty_mod_escape', true, $this->_tpl_vars['umOrganizationUnit'], "html"); ?>
" class="textbox"></td>
				</tr>
				<tr height="20"> 
						<td class=headerright width="25%"><?php echo $this->_config[0]['vars']['reg_ldapjobtitle']; ?>
&nbsp;</td>
						<td class=default>&nbsp;<input type=text name=f_jobtitle size=30 maxlength=128 value="<?php echo $this->_run_mod_handler('smarty_mod_escape', true, $this->_tpl_vars['umJobTitle'], "html"); ?>
" class="textbox"></td>
				</tr>
				<tr height="20"> 
						<td class=headerright width="25%"><?php echo $this->_config[0]['vars']['reg_ldapoffice']; ?>
&nbsp;</td>
						<td class=default>&nbsp;<input type=text name=f_office size=30 maxlength=128 value="<?php echo $this->_run_mod_handler('smarty_mod_escape', true, $this->_tpl_vars['umOffice'], "html"); ?>
" class="textbox"></td>
				</tr>
				<tr height="20"> 
						<td class=headerright width="25%"><?php echo $this->_config[0]['vars']['reg_ldapofficephone']; ?>
&nbsp;</td>
						<td class=default>&nbsp;<input type=text name=f_officephone size=30 maxlength=32 value="<?php echo $this->_run_mod_handler('smarty_mod_escape', true, $this->_tpl_vars['umOfficePhone'], "html"); ?>
" class="textbox"></td>
				</tr>
					
	      		<tr height="50"> 
					<td class=headerright width="25%"><?php echo $this->_config[0]['vars']['reg_description']; ?>
&nbsp;</td>
					<td class=default>&nbsp;<textarea name=f_description cols=35 rows=5><?php echo $this->_run_mod_handler('smarty_mod_escape', true, $this->_tpl_vars['umDescription'], "html"); ?>
</textarea></td>
				</tr>
<!--					
				<tr height="20">
						<td class=headerright width="25%">&nbsp;</td>
						<td class=default><input type="checkbox" name=f_publicinfo value="1" <?php echo $this->_tpl_vars['umPublicInfo']; ?>
><?php echo $this->_config[0]['vars']['reg_ldappublicinfo']; ?>
</td>
				</tr>
-->						
				<?php if ($this->_tpl_vars['umShowType'] == -1): ?>
	          		<tr align="center" height="30"> 
						<td colspan=2 class=headers><font color=#ff0000><?php echo $this->_config[0]['vars']['reg_failure']; ?>
<br>
						<?php if ($this->_tpl_vars['umErrorCode'] == -1): ?>
							<?php echo $this->_config[0]['vars']['reg_dberror']; ?>

						<?php elseif ($this->_tpl_vars['umErrorCode'] == 1): ?>
							<?php echo $this->_config[0]['vars']['reg_existuser']; ?>

						<?php elseif ($this->_tpl_vars['umErrorCode'] == 2): ?>
							<?php echo $this->_config[0]['vars']['reg_existaliasuser']; ?>

						<?php elseif ($this->_tpl_vars['umErrorCode'] == 3): ?>
							<?php echo $this->_config[0]['vars']['reg_existgroup']; ?>

						<?php elseif ($this->_tpl_vars['umErrorCode'] == 4): ?>
							<?php echo $this->_config[0]['vars']['reg_userfull']; ?>

						<?php elseif ($this->_tpl_vars['umErrorCode'] == 5): ?>
							<?php echo $this->_config[0]['vars']['reg_domainstoragefull']; ?>

						<?php elseif ($this->_tpl_vars['umErrorCode'] == 6): ?>
							<?php echo $this->_config[0]['vars']['reg_domainuserfull']; ?>

						<?php endif; ?>
						</font></td>
					</tr>
				<?php endif; ?>
          		<tr height="20"> 
					<td class=default colspan=2 align=center height=30>
					<input type=button value="<?php echo $this->_config[0]['vars']['reg_register']; ?>
" class="button" onclick="javascript:checkValue();">
					&nbsp;&nbsp;&nbsp;&nbsp;
					<input type=button value="<?php echo $this->_config[0]['vars']['reg_back']; ?>
" class="button" onclick="javascript:goBack();">
					</td>
				</tr>
				</form>
			</table>
		</td>
	</tr>
</table>
<?php else: ?>
<table align="center" width="758" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td height="300" align="center" bgcolor="#FFFFFF">
			<table align="center"  cellspacing=1 cellpadding=1 width="60%"  border=0 bgcolor="#333333">
				<form name=form1 action=register.php method=POST>
				<input type=hidden name=lid value="<?php echo $this->_tpl_vars['umLid']; ?>
">
				<input type=hidden name=tid value="<?php echo $this->_tpl_vars['umTid']; ?>
">
				<input type=hidden name=save value="yes">
				
          		<tr align="center" height="30"> 
					<td colspan=2 class=headers><b><?php echo $this->_config[0]['vars']['reg_success']; ?>
</b></td>
				</tr>
			
				<?php if ($this->_tpl_vars['umNeedAffirm'] == 1): ?>
		          	<tr align="center" height="30"> 
						<td colspan=2 class=headers><?php echo $this->_config[0]['vars']['reg_affirmtip']; ?>
</td>
				</tr>
				<?php else: ?>
		          	<tr align="center" height="30"> 
						<td colspan=2 class=headers><?php echo $this->_config[0]['vars']['reg_successtip']; ?>
</td>
					</tr>
				<?php endif; ?>
				
		      	<tr height="20"> 
						<td class=headerright width="25%"><?php echo $this->_config[0]['vars']['reg_mailbox']; ?>
&nbsp;</td>
						<td class=default>&nbsp;<?php echo $this->_run_mod_handler('smarty_mod_escape', true, $this->_tpl_vars['umUser'], "html"); ?>
@<?php echo $this->_run_mod_handler('smarty_mod_escape', true, $this->_tpl_vars['umDomain'], "html"); ?>
</td>
				</tr>
		      	<tr height="20"> 
						<td class=headerright><?php echo $this->_config[0]['vars']['reg_password']; ?>
&nbsp;</td>
						<td class=default>&nbsp;<?php echo $this->_config[0]['vars']['reg_hide_pwd']; ?>
</td>
				</tr>
		      	<tr height="20"> 
						<td class=headerright width="25%"><?php echo $this->_config[0]['vars']['reg_fullname']; ?>
&nbsp;</td>
						<td class=default>&nbsp;<?php echo $this->_run_mod_handler('smarty_mod_escape', true, $this->_tpl_vars['umFullName'], "html"); ?>
</td>
				</tr>
					
				<tr height="20"> 
						<td class=headerright width="25%"><?php echo $this->_config[0]['vars']['reg_ldaphomeaddress']; ?>
&nbsp;</td>
						<td class=default>&nbsp;<?php echo $this->_run_mod_handler('smarty_mod_escape', true, $this->_tpl_vars['umHomeAddress'], "html"); ?>
</td>
				</tr>
				<tr height="20"> 
						<td class=headerright width="25%"><?php echo $this->_config[0]['vars']['reg_ldaphomephone']; ?>
&nbsp;</td>
						<td class=default>&nbsp;<?php echo $this->_run_mod_handler('smarty_mod_escape', true, $this->_tpl_vars['umHomePhone'], "html"); ?>
</td>
				</tr>
				<tr height="20"> 
						<td class=headerright width="25%"><?php echo $this->_config[0]['vars']['reg_ldapmobile']; ?>
&nbsp;</td>
						<td class=default>&nbsp;<?php echo $this->_run_mod_handler('smarty_mod_escape', true, $this->_tpl_vars['umMobile'], "html"); ?>
</td>
				</tr>
				
				<tr height="20"> 
						<td class=headerright width="25%"><?php echo $this->_config[0]['vars']['reg_ldaporganizationunit']; ?>
&nbsp;</td>
						<td class=default>&nbsp;<?php echo $this->_run_mod_handler('smarty_mod_escape', true, $this->_tpl_vars['umOrganizationUnit'], "html"); ?>
</td>
				</tr>
				<tr height="20"> 
						<td class=headerright width="25%"><?php echo $this->_config[0]['vars']['reg_ldapjobtitle']; ?>
&nbsp;</td>
						<td class=default>&nbsp;<?php echo $this->_run_mod_handler('smarty_mod_escape', true, $this->_tpl_vars['umJobTitle'], "html"); ?>
</td>
				</tr>
				<tr height="20"> 
						<td class=headerright width="25%"><?php echo $this->_config[0]['vars']['reg_ldapoffice']; ?>
&nbsp;</td>
						<td class=default>&nbsp;<?php echo $this->_run_mod_handler('smarty_mod_escape', true, $this->_tpl_vars['umOffice'], "html"); ?>
</td>
				</tr>
				<tr height="20"> 
						<td class=headerright width="25%"><?php echo $this->_config[0]['vars']['reg_ldapofficephone']; ?>
&nbsp;</td>
						<td class=default>&nbsp;<?php echo $this->_run_mod_handler('smarty_mod_escape', true, $this->_tpl_vars['umOfficePhone'], "html"); ?>
</td>
				</tr>
				
		  		<tr height="50"> 
					<td class=headerright width="25%"><?php echo $this->_config[0]['vars']['reg_description']; ?>
&nbsp;</td>
					<td class=default>&nbsp;<?php echo $this->_run_mod_handler('smarty_mod_escape', true, $this->_tpl_vars['umDescription'], "html"); ?>
</td>
				</tr>         		
		      		
				<tr height="20"> 			
						<td class=default colspan=2 align=center height=30>
						<input type=button value="<?php echo $this->_config[0]['vars']['reg_back']; ?>
" class="button" onclick="javascript:goBack();">
						</td>
				</tr>
				</form>
			</table>
		</td>
	</tr>
</table>
<?php endif; ?>
<table align="center" width="758" border="0" cellspacing="0" cellpadding="0">
    <tr>
		<td height="18" background="themes/default/images/regbt.gif" bgcolor="#FFFFFF">&nbsp;</td>
    </tr>
    <tr><td height="50" bgcolor="#AFB2B3">&nbsp;</td></tr>
    <tr>
		<td height="30" background="themes/default/images/regbt2.gif" bgcolor="#FFFFFF" align=center>&copy 2003 AMAX Information Technologies Inc. All Rights Reserved. </td>
    </tr>
</table>
</body>
</html>
