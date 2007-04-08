<?php /* Smarty version 1.5.2, created on 2003-09-24 13:30:06
         compiled from default/pageheader.htm */ ?>
<?php echo '
<script language="Javascript">
function contact(address)
{
	location.href = "mailto:"+address;
}
</script>
'; ?>


<table align="center" width="758" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td><img src="themes/default/images/mainhead.gif" width="758" height="8"></td>
  </tr>
</table>
<table align="center" width="758" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td rowspan="2" bgcolor="#817B7B" width="1"><img width="1" height="1"></td>
    <td width="222" height="100" rowspan="2">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td height="70" background="themes/default/images/winmaillogo_bg.gif"><img src="themes/default/images/winmaillogo.gif" width="222" height="70"></td>
          </tr>
          <tr>
            <td><img src="themes/default/images/winmaillogo_bottom.gif" width="222" height="30"></td>
          </tr>
        </table>    
    </td>
    <td height="20" align="right" background="themes/default/images/topbg.gif">
     <table width="507" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td width="307" align="center"><img src="themes/default/images/colorline.gif" width="265" height="3"></td>
	      <?php if ($this->_tpl_vars['umWebmasterEmail'] == "#@[]"): ?>
          <td width="20" valign="bottom"><a href="javascript:contact('<?php echo $this->_config[0]['vars']['webmaster_mail']; ?>
');"><img src="themes/default/images/contact_ico.gif" border=0 width="16" height="16"></a></td>
          <td width="80" valign="bottom"><a href="javascript:contact('<?php echo $this->_config[0]['vars']['webmaster_mail']; ?>
');" class="blue"><?php echo $this->_config[0]['vars']['contact_us']; ?>
</a></td>
	      <?php else: ?>
          <td width="20" valign="bottom"><a href="javascript:contact('<?php echo $this->_tpl_vars['umWebmasterEmail']; ?>
');"><img src="themes/default/images/contact_ico.gif" border=0 width="16" height="16"></a></td>
          <td width="80" valign="bottom"><a href="javascript:contact('<?php echo $this->_tpl_vars['umWebmasterEmail']; ?>
');" class="blue"><?php echo $this->_config[0]['vars']['contact_us']; ?>
</a></td>
	      <?php endif; ?>
          <td width="20" valign="bottom"><a href="javascript:goend()"><img src="themes/default/images/logout.gif" border=0 width="16" height="16"></a></td>
          <td width="80" valign="bottom"><a href="javascript:goend()" class="blue"><?php echo $this->_config[0]['vars']['logoff_mnu']; ?>
</a></td>
        </tr>
      </table>
    </td>
    <td rowspan="2" bgcolor="#817B7B" width="1"><img width="1" height="1"></td>
  </tr>
  <tr> 
    <td height="80" align="center" background="themes/default/images/topbg.gif"><img src="<?php echo $this->_config[0]['vars']['banner_url']; ?>
" width="468" height="60" border="0"></td>
  </tr>
</table>
<table align="center" width="758" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td rowspan="4" bgcolor="#817B7B" width="1"><img width="1" height="1"></td>
    <td width="169" height="45" rowspan="4"><img src="themes/default/images/welcome.gif" width="169" height="45"></td>
    <td height="21" background="themes/default/images/navbg.gif"><img src="themes/default/images/navgpic.gif" width="480" height="21"></td>
    <td width="1" rowspan="4" bgcolor="#817B7B"><img width="1" height="1"></td>
  </tr>
  <tr> 
    <td height="22" valign="bottom" background="themes/default/images/navbgline.jpg" class="bluebig">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&gt;&gt;&gt; <?php echo $this->_tpl_vars['umUserEmail']; ?>
</td>
  </tr>
  <tr> 
    <td bgcolor="#FFFFFF" height="1"><img width="1" height="1"></td>
  </tr>
  <tr> 
    <td bgcolor="#D6D6D6" height="1"><img width="1" height="1"></td>
  </tr>
</table>