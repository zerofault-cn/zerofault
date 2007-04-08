<?php /* Smarty version 1.5.2, created on 2003-09-24 13:30:07
         compiled from default/menu.htm */ ?>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td bgcolor="#817B7B" width="1"><img width="1" height="1"></td>
          <td>
          <table width="154" border="0" cellspacing="0" cellpadding="0">
<!--  inbox     -->              
              <tr height="20" bgcolor="#EBE5E5" onmouseover="mOvr(this,'#D1D7ED');" onmouseout="mOut(this,'#EBE5E5');" onclick="javascript:goinbox();"> 
                <td width="10">&nbsp;</td>
                <td width="20" valign="bottom"><img src="themes/default/images/inbox.gif"  width="16" height="16" border=0></td>
				<td width="*" valign="bottom" colspan=2>
					<a class="menu" href="javascript:goinbox()"><?php echo $this->_config[0]['vars']['messages_mnu']; ?>
</a>
				</td>
              </tr>
              <tr bgcolor="#FFFFFF"> 
                <td colspan="4" height="1"><img width="1" height="1"></td>
              </tr>

<!--  compose     -->              
              <tr height="20" bgcolor="#EBE5E5" onmouseover="mOvr(this,'#D1D7ED');" onmouseout="mOut(this,'#EBE5E5');" onclick="javascript:newmsg();"> 
                <td>&nbsp;</td>
                <td valign="bottom"><img src="themes/default/images/compose.gif"  width="16" height="16" border=0></td>
				<td valign="bottom" colspan=2>
	          		<a class="menu" href="javascript:newmsg()"><?php echo $this->_config[0]['vars']['compose_mnu']; ?>
</a>
	          	</td>
              </tr>
              <tr bgcolor="#FFFFFF"> 
                <td colspan="4" height="1"><img width="1" height="1"></td>
              </tr>

<!--  folder     -->              
              <tr height="20" bgcolor="#EBE5E5" onmouseover="mOvr(this,'#D1D7ED');" onmouseout="mOut(this,'#EBE5E5');" onclick="javascript:folderlist();"> 
                <td>&nbsp;</td>
                <td valign="bottom"><img src="themes/default/images/folder.gif"  width="16" height="16" border=0></td>
				<td valign="bottom" colspan=2>
					<a class="menu" href="javascript:folderlist()"><?php echo $this->_config[0]['vars']['folders_mnu']; ?>
</a>
				</td>
              </tr>
              <tr bgcolor="#FFFFFF"> 
                <td colspan="4" height="1"><img width="1" height="1"></td>
              </tr>

<!--  search     -->              
              <tr height="20" bgcolor="#EBE5E5" onmouseover="mOvr(this,'#D1D7ED');" onmouseout="mOut(this,'#EBE5E5');" onclick="javascript:search();"> 
                <td>&nbsp;</td>
                <td valign="bottom"><img src="themes/default/images/search.gif"  width="16" height="16" border=0></td>
				<td valign="bottom" colspan=2>
					<a class="menu" href="javascript:search()"><?php echo $this->_config[0]['vars']['search_mnu']; ?>
</a>
				</td>
              </tr>
              <tr bgcolor="#FFFFFF"> 
                <td colspan="4" height="1"><img width="1" height="1"></td>
              </tr>
              
<!--  address     -->              
              <tr height="20" bgcolor="#D1D7ED"> 
                <td>&nbsp;</td>
                <td valign="bottom"><img src="themes/default/images/address.gif"  width="16" height="16" border=0></td>
				<td valign="bottom" colspan=2 class="menu"><?php echo $this->_config[0]['vars']['address_mnu']; ?>
</td>
              </tr>
              <tr bgcolor="#FFFFFF"> 
                <td colspan="4" height="1"><img width="1" height="1"></td>
              </tr>

              <tr height="20" bgcolor="#EBE5E5" onmouseover="mOvr(this,'#D1D7ED');" onmouseout="mOut(this,'#EBE5E5');" onclick="javascript:addresses();"> 
                <td width="10">&nbsp;</td>
                <td width="20" valign="bottom">&nbsp;</td>
                <td width="20" valign="bottom"><img src="themes/default/images/address.gif"  width="16" height="16" border=0></td>
				<td width="*" valign="bottom">
					<a class="menu" href="javascript:addresses()"><?php echo $this->_config[0]['vars']['personaddress_mnu']; ?>
</a>
				</td>
              </tr>
              <tr bgcolor="#FFFFFF"> 
                <td colspan="4" height="1"><img width="1" height="1"></td>
              </tr>
              
              <tr height="20" bgcolor="#EBE5E5" onmouseover="mOvr(this,'#D1D7ED');" onmouseout="mOut(this,'#EBE5E5');" onclick="javascript:group();"> 
                <td>&nbsp;</td>
                <td valign="bottom">&nbsp;</td>
                <td valign="bottom"><img src="themes/default/images/member.gif"  width="16" height="16" border=0></td>
				<td valign="bottom">
					<a class="menu" href="javascript:group()"><?php echo $this->_config[0]['vars']['group_mnu']; ?>
</a>
				</td>
              </tr>
              <tr bgcolor="#FFFFFF"> 
                <td colspan="4" height="1"><img width="1" height="1"></td>
              </tr>
              
              <tr height="20" bgcolor="#EBE5E5" onmouseover="mOvr(this,'#D1D7ED');" onmouseout="mOut(this,'#EBE5E5');" onclick="javascript:netaddress();"> 
                <td>&nbsp;</td>
                <td valign="bottom">&nbsp;</td>
                <td valign="bottom"><img src="themes/default/images/netaddress.gif"  width="16" height="16" border=0></td>
				<td valign="bottom">
					<a class="menu" href="javascript:netaddress()"><?php echo $this->_config[0]['vars']['netaddress_mnu']; ?>
</a>
				</td>
              </tr>
              <tr bgcolor="#FFFFFF"> 
                <td colspan="4" height="1"><img width="1" height="1"></td>
              </tr>

<!--  options     -->              
              <tr height="20" bgcolor="#D1D7ED"> 
                <td >&nbsp;</td>
                <td valign="bottom"><img src="themes/default/images/preferences.gif"  width="16" height="16" border=0></td>
				<td valign="bottom" colspan=2 class="menu"><?php echo $this->_config[0]['vars']['options_mnu']; ?>
</td>
              </tr>
              <tr bgcolor="#FFFFFF"> 
                <td colspan="4" height="1"><img width="1" height="1"></td>
              </tr>
              
              <tr height="20" bgcolor="#EBE5E5" onmouseover="mOvr(this,'#D1D7ED');" onmouseout="mOut(this,'#EBE5E5');" onclick="javascript:prefs();"> 
                <td >&nbsp;</td>
                <td valign="bottom">&nbsp;</td>
                <td valign="bottom"><img src="themes/default/images/preferences.gif"  width="16" height="16" border=0></td>
				<td valign="bottom">
					<a class="menu" href="javascript:prefs()"><?php echo $this->_config[0]['vars']['prefs_mnu']; ?>
</a>
				</td>
              </tr>
              <tr bgcolor="#FFFFFF"> 
                <td colspan="4" height="1"><img width="1" height="1"></td>
              </tr>

              <tr height="20" bgcolor="#EBE5E5" onmouseover="mOvr(this,'#D1D7ED');" onmouseout="mOut(this,'#EBE5E5');" onclick="javascript:userinfo();"> 
                <td>&nbsp;</td>
                <td valign="bottom">&nbsp;</td>
                <td valign="bottom"><img src="themes/default/images/user.gif"  width="16" height="16" border=0></td>
				<td valign="bottom">
					<a class="menu" href="javascript:userinfo()"><?php echo $this->_config[0]['vars']['userinfo_mnu']; ?>
</a>
				</td>
              </tr>
              <tr bgcolor="#FFFFFF"> 
                <td colspan="4" height="1"><img width="1" height="1"></td>
              </tr>
              
              <tr height="20" bgcolor="#EBE5E5" onmouseover="mOvr(this,'#D1D7ED');" onmouseout="mOut(this,'#EBE5E5');" onclick="javascript:signatures();"> 
                <td>&nbsp;</td>
                <td valign="bottom">&nbsp;</td>
                <td valign="bottom"><img src="themes/default/images/signature.gif"  width="16" height="16" border=0></td>
				<td valign="bottom">
					<a class="menu" href="javascript:signatures()"><?php echo $this->_config[0]['vars']['signature_mnu']; ?>
</a>
				</td>
              </tr>
              <tr bgcolor="#FFFFFF"> 
                <td colspan="4" height="1"><img width="1" height="1"></td>
              </tr>
              
              <tr height="20" bgcolor="#EBE5E5" onmouseover="mOvr(this,'#D1D7ED');" onmouseout="mOut(this,'#EBE5E5');" onclick="javascript:externalpop3();"> 
                <td>&nbsp;</td>
                <td valign="bottom">&nbsp;</td>
                <td valign="bottom"><img src="themes/default/images/externalpop3.gif"  width="16" height="16" border=0></td>
				<td valign="bottom">
					<a class="menu" href="javascript:externalpop3()"><?php echo $this->_config[0]['vars']['externalpop3_mnu']; ?>
</a>
				</td>
              </tr>
              <tr bgcolor="#FFFFFF"> 
                <td colspan="4" height="1"><img width="1" height="1"></td>
              </tr>
              
              <tr height="20" bgcolor="#EBE5E5" onmouseover="mOvr(this,'#D1D7ED');" onmouseout="mOut(this,'#EBE5E5');" onclick="javascript:autoforward();"> 
                <td>&nbsp;</td>
                <td valign="bottom">&nbsp;</td>
                <td valign="bottom"><img src="themes/default/images/autoforward.gif"  width="16" height="16" border=0></td>
				<td valign="bottom">
					<a class="menu" href="javascript:autoforward()"><?php echo $this->_config[0]['vars']['autoforward_mnu']; ?>
</a>
				</td>
              </tr>
              <tr bgcolor="#FFFFFF"> 
                <td colspan="4" height="1"><img width="1" height="1"></td>
              </tr>
              
              <tr height="20" bgcolor="#EBE5E5" onmouseover="mOvr(this,'#D1D7ED');" onmouseout="mOut(this,'#EBE5E5');" onclick="javascript:autoreply();"> 
                <td>&nbsp;</td>
                <td valign="bottom">&nbsp;</td>
                <td valign="bottom"><img src="themes/default/images/autoreply.gif"  width="16" height="16" border=0></td>
				<td valign="bottom">
					<a class="menu" href="javascript:autoreply()"><?php echo $this->_config[0]['vars']['autoreply_mnu']; ?>
</a>
				</td>
              </tr>
              <tr bgcolor="#FFFFFF"> 
                <td colspan="4" height="1"><img width="1" height="1"></td>
              </tr>
              
              <?php if ($this->_tpl_vars['umAllowSmsCgi']): ?>
              <tr height="20" bgcolor="#EBE5E5" onmouseover="mOvr(this,'#D1D7ED');" onmouseout="mOut(this,'#EBE5E5');" onclick="javascript:smscgi();"> 
                <td>&nbsp;</td>
                <td valign="bottom">&nbsp;</td>
                <td valign="bottom"><img src="themes/default/images/smscgi.gif"  width="16" height="16" border=0></td>
				<td valign="bottom">
					<a class="menu" href="javascript:smscgi()"><?php echo $this->_config[0]['vars']['smscgi_mnu']; ?>
</a>
				</td>
              </tr>
              <tr bgcolor="#FFFFFF"> 
                <td colspan="4" height="1"><img width="1" height="1"></td>
              </tr>
              <?php endif; ?>
              
              <tr height="20" bgcolor="#EBE5E5" onmouseover="mOvr(this,'#D1D7ED');" onmouseout="mOut(this,'#EBE5E5');" onclick="javascript:chgpassword();"> 
                <td >&nbsp;</td>
                <td valign="bottom">&nbsp;</td>
                <td valign="bottom"><img src="themes/default/images/password.gif"  width="16" height="16" border=0></td>
				<td valign="bottom">
					<a class="menu" href="javascript:chgpassword()"><?php echo $this->_config[0]['vars']['chgpassword_mnu']; ?>
</a>
				</td>
              </tr>
              <tr bgcolor="#FFFFFF"> 
                <td colspan="4" height="1"><img width="1" height="1"></td>
              </tr>
              
<!--  logout     -->              
              <tr height="20" bgcolor="#EBE5E5" onmouseover="mOvr(this,'#D1D7ED');" onmouseout="mOut(this,'#EBE5E5');" onclick="javascript:goend();"> 
                <td>&nbsp;</td>
                <td valign="bottom"><img src="themes/default/images/logout.gif"  width="16" height="16" border=0></td>
				<td valign="bottom" colspan=2>
					<a class="menu" href="javascript:goend()"><?php echo $this->_config[0]['vars']['logoff_mnu']; ?>
</a>
				</td>
              </tr>
              <tr bgcolor="#FFFFFF"> 
                <td colspan="4" height="1"><img width="1" height="1"></td>
              </tr>
              <tr bgcolor="#FFFFFF"> 
                <td colspan="4" height="1"><img width="1" height="1"></td>
              </tr>
            </table>
            </td>
        </tr>
        <tr> 
          <td bgcolor="#817B7B"><img width="1" height="1"></td>
          <td height="60" align="center" bgcolor="#DCDCDC">&nbsp;</td>
        </tr>
      </table>
      <img src="themes/default/images/leftbarbt.gif" width="155" height="12">