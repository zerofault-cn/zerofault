<?php /* Smarty version 1.5.2, created on 2003-09-24 13:29:45
         compiled from default/login.htm */ ?>
<?php $this->_config_load($this->_tpl_vars['umLanguageFile'], "Login", 'local'); ?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
	<title><?php echo $this->_config[0]['vars']['common_page_title']; ?>
 - <?php echo $this->_run_mod_handler('smarty_mod_escape', true, $this->_config[0]['vars']['lng_title'], "html"); ?>
</title>
	<link rel="stylesheet" href="themes/default/webmail.css" type="text/css">
	<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $this->_config[0]['vars']['default_char_set']; ?>
">
</head>

<?php echo $this->_tpl_vars['umJS']; ?>


<?php echo '
<script language="Javascript">
function contact(address)
{
	location.href = "mailto:"+address;
}
</script>
'; ?>


<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="351" align="center">
      <table border="0" cellpadding="1" cellspacing="3" bgcolor="#FFFFFF">
        <tr>
          <td bgcolor="#999999">
            <table width="744" border="0" cellspacing="0" cellpadding="0">
              <tr> 
                <td width="78%" rowspan="2" bgcolor="#FFFFFF"><img src="themes/default/images/magiclogo.gif" width="162" height="65"></td>
                <td width="22%" height="25" valign="middle" bgcolor="#FFFFFF">
	           	<?php if ($this->_tpl_vars['umWebmasterEmail'] == "#@[]"): ?>
                	<a href="javascript:contact('<?php echo $this->_config[0]['vars']['webmaster_mail']; ?>
');"><img src="themes/default/images/contact_ico.gif" width="16" height="16" border=0> 
                  	<?php echo $this->_config[0]['vars']['contact_us']; ?>
</a>
                <?php else: ?>
                	<a href="javascript:contact('<?php echo $this->_tpl_vars['umWebmasterEmail']; ?>
');"><img src="themes/default/images/contact_ico.gif" width="16" height="16" border=0> 
                  	<?php echo $this->_config[0]['vars']['contact_us']; ?>
</a>
                <?php endif; ?>
                </td>
              </tr>
              <tr> 
                <td bgcolor="#FFFFFF">&nbsp;</td>
              </tr>
              <tr> 
                <td height="25" colspan="2" bgcolor="#FFFFFF">&nbsp;</td>
              </tr>
            </table>
            <table width="744" border="0" cellspacing="0" cellpadding="0">
              <tr> 
                <td rowspan=2 width="264" bgcolor="#FFFFFF"><img src="themes/default/images/mail_pic.jpg" width="264" height="102"></td>
                <td rowspan=2 background="themes/default/images/mail_pic2.jpg" bgcolor="#FFFFFF">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                	<tr>
	                	<td><img src="themes/default/images/winmail.gif" width="290" height="102"></td>
	                	<td height="34" align="center" valign="middle">
	                	<?php if ($this->_tpl_vars['umRegister'] != 0): ?>
	                		<a href="register.php"><?php echo $this->_config[0]['vars']['lng_register']; ?>
</a>
	                	<?php endif; ?>&nbsp;<br><br>
	                	</td>
                	</tr>
                </table>
                </td>
              </tr>
            </table>
            <table width="744" border="0" cellspacing="0" cellpadding="0">
              <tr> 
                <td width="349" valign="top" bgcolor="#FFFFFF"><img src="themes/default/images/mail_btpic1.jpg" width="349" height="96"></td>
                <td background="themes/default/images/mail_btpic2.jpg" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
					<form name="form1" action="login.php?retid=<?php echo $this->_tpl_vars['umRetID']; ?>
" method=post>
                      <tr valign="top"> 
                        <td width="18%" height="24" align="right" class="bld"><?php echo $this->_config[0]['vars']['lng_user_name']; ?>
:&nbsp;</td>
                        <td width="25%" align="left"><input type="text" size="12" name="f_user" value="<?php echo $this->_tpl_vars['umUser']; ?>
"></td>
                        <td width="57%"><?php if ($this->_tpl_vars['umAvailableServers'] != 0): ?><?php echo $this->_tpl_vars['umServer']; ?>
<?php endif; ?></td>
                      </tr>
                      <tr valign="top"> 
                        <td height="24" align="right" class="bld"><?php echo $this->_config[0]['vars']['lng_user_pwd']; ?>
:&nbsp;</td>
                        <td align="left"><input type="password" size="12" name="f_pass" value=""></td>
                        <td>&nbsp;</td>
                      </tr>
					<?php if ($this->_tpl_vars['umAllowSelectLanguage']): ?>
                      <tr valign="top"> 
                        <td height="24" align="right" class="bld"><?php echo $this->_config[0]['vars']['lng_language']; ?>
:&nbsp;</td>
                        <td colspan="2" align="left"><?php echo $this->_tpl_vars['umLanguages']; ?>
</td>
                      </tr>
					<?php endif; ?>
					<?php if ($this->_tpl_vars['umAllowSelectTheme']): ?>
                      <tr valign="top"> 
                        <td height="24" align="right" class="bld"><?php echo $this->_config[0]['vars']['lng_theme']; ?>
:&nbsp;</td>
                        <td align="left"><?php echo $this->_tpl_vars['umThemes']; ?>
</td>
                        <td><input name="submit" type="image" src="themes/default/images/loginbt.gif" width="48" height="18" border="0"></td>
                      </tr>
                    <?php else: ?>
                      <tr valign="top"> 
                        <td height="24" align="right" class="bld">&nbsp;</td>
                        <td colspan="2" align="left"><input name="submit" type="image" src="themes/default/images/loginbt.gif" width="48" height="18" border="0"></td>
                      </tr>
					<?php endif; ?>
                    </form>
                  </table></td>
              </tr>
            </table>
            <table width="744" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
              <tr>
                <td width="220"><img src="themes/default/images/mail_bt1.jpg" width="220" height="20"></td>
                <td background="themes/default/images/mail_bt2.jpg">&nbsp;</td>
              </tr>
            </table>
            <table width="744" border="0" cellspacing="0" cellpadding="0">
              <tr> 
                <td width="276" rowspan="2" valign="top"><img src="themes/default/images/mail_bt3.jpg" width="349" height="36"></td>
                <td width="468" bgcolor="#FFFFFF" height="2"><img width="1" height="1"></td>
              </tr>
              <tr> 
                <td height="34" align="right" background="themes/default/images/mail_rpt2.jpg"><a target="_blank" href="<?php echo $this->_config[0]['vars']['homepage_url']; ?>
"><?php echo $this->_config[0]['vars']['homepage']; ?>
</a>&nbsp;</td>
              </tr>
            </table>
            <table width="744" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
              <tr>
                <td height="70">&nbsp;</td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
</body>
</html>