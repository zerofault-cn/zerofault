<script language="JavaScript" type="text/javascript">
<!--
function checkForm() {
	formErrors = false;    

	if (document.linkdata.link_title.value == '') {
		formErrors = '{L_LINK_TITLE}';	
	} else if (document.linkdata.link_url.value == 'http://') {
		formErrors = '{L_LINK_URL}';	
	} else if (document.linkdata.link_logo_src.value == 'http://' ) {
		formErrors = '{L_LINK_LOGO_SRC}';	
	} else if (document.linkdata.link_category.value == '' ) {
		formErrors = '{L_LINK_CATEGORY}';	
	} else if (document.linkdata.link_desc.value == '' ) {
		formErrors = '{L_LINK_DESC}';	
	}

	if (formErrors) {
		alert('{L_PLEASE_ENTER_YOUR}' + formErrors);
		return false;
	} 
	
	return true;
}
//-->
</script>

<table width="100%" cellspacing="2" cellpadding="2" border="0" align="center">
	<tr> 
	  <td align="right" style="font-weight: bold;font-size: 11px; color: orange">&#149;&nbsp;<a href="{U_SITE_LINKS}">{LINKS_HOME}</a>&nbsp;&nbsp;&#149;&nbsp;<a href="{U_SITE_SEARCH}">{L_SEARCH_SITE}</a>&nbsp;&nbsp;&#149;&nbsp;<a href="{U_SITE_TOP}">{L_DESCEND_BY_HITS}</a>&nbsp;&nbsp;&#149;&nbsp;<a href="{U_SITE_NEW}">{L_DESCEND_BY_JOINDATE}</a>
	  </td>
	</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr> 
	  <!-- BEGIN lock -->
	  <td width="10%" nowrap="nowrap" valign="top">
		<!-- BEGIN logout -->
		<table border="0" cellpadding="0" cellspacing="1" width="100%" class="forumline">
		  <tr> 
			<th class="thHead" align="left">&nbsp;{L_LOGIN}</th>
		  </tr>
		<tr><td class="row1">
		<form method="post" action="{S_LOGIN_ACTION}">
		<table border="0" cellpadding="2" cellspacing="0" width="100%">
		<tr>
			<td class="row1">
			  <span class="gensmall">{L_LINK_REGISTER_GUEST_RULE}</span>
			</td>
		  </tr>
		  <tr>
			<td class="row1">
			  <span class="gensmall">{L_USERNAME}:</span><br /><input type="text" name="username" size="25" maxlength="40" value="" class="post" />
			</td>
		  </tr>
		  <tr>
			<td class="row1">
			  <span class="gensmall">{L_PASSWORD}:<br /><input type="password" name="password" size="25" maxlength="32" class="post" />
			</td>
		  </tr>
		  <tr> 
			<td class="row1"><span class="gensmall">{L_AUTO_LOGIN}: <input type="checkbox" name="autologin" /></span></td>
		  </tr>
		  <tr>
			<td class="row1" align="center"><input type="hidden" name="redirect" value="{U_SITE_LINKS}" /><input type="submit" name="login" class="mainoption" value="{L_LOGIN}" /><br /><br /><span class="gensmall"><a href="{U_REGISTER}">{L_REGISTER}</a></span></td>
		  </tr>
		</table></form>
		</td></tr>
		</table>
		<!-- END logout -->
		
		<!-- BEGIN submit -->
		<table border="0" cellpadding="0" cellspacing="1" width="100%" class="forumline">
		  <tr> 
			<th class="thHead" align="left">&nbsp;{L_LINK_REGISTER}</th>
		  </tr>
		<form name="linkdata" method="post" action="{U_LINK_REG}">
		<tr><td class="row1">
		<table border="0" cellpadding="2" cellspacing="0" width="100%">
			<tr> 
			  <td class="row1"><span class="gensmall">
			  {L_LINK_REGISTER_RULE}
			  </span></td>
			</tr>			
			<tr> 
			  <td class="row1"><br /><span class="gensmall">{L_LINK_TITLE}</span><br /><input type="text" name="link_title" value="" size="15" maxlength="20" class="post" style="width:160px"></td>
			</tr>
			<tr> 
			  <td class="row1"><span class="gensmall">{L_LINK_URL}</span><br /><input type="text" name="link_url" value="http://" size="15" maxlength="100" style="width:160px" class="post"></td>
			</tr>
			<tr> 
			  <td class="row1"><span class="gensmall">{L_LINK_LOGO_SRC}</span><br /><input type="text" size="15" maxlength="120" style="width:160px" name="link_logo_src" value="http://" class="post"><br /><span class="gensmall">[<a href="javascript: void(0)" onclick="var img_src=document.linkdata.link_logo_src.value;if(img_src=='http://' || img_src=='') img_src='images/links/no_logo88a.gif';_preview=window.open(img_src, '_preview', 'toolbar=no,width=200,height=100,top=300,left=300');">{L_PREVIEW}</a>]</span><br /><br /></td>
			</tr>
			<tr> 
			  <td class="row1">
			  	<span class="gensmall">{L_LINK_CATEGORY}</span><br />
				<select name="link_category" style="width:160px">
				  <option value="" selected>----------------</option>{LINK_CAT_OPTION}
				</select>
			  </td>
			</tr>
			<tr> 
			  <td class="row1"><span class="gensmall">{L_LINK_DESC}</span><br /><textarea name="link_desc" cols="15" rows="4" class="post" style="width:160px" maxsize="120" wrap="VIRTUAL"></textarea></td>
			</tr>
			
		</table>
		</td></tr>
		<tr> 
		  <td class="cat" align="center"><input type="submit" name="addlink" value="{L_SUBMIT}" class="liteoption"></td>
		</tr>
		</form>
		</table>
		<!-- END submit -->
	  </td>
	  <td width="10" nowrap="nowrap">&nbsp;</td>
	  <!-- END lock -->
	  <td width="100%" nowrap="nowrap" valign="top">
		<table border="0" cellpadding="3" cellspacing="1" width="100%" class="forumline">
		<tr>
			  <th class="thHead" align="left" colspan="2">&nbsp;{L_LINK_TITLE1}</th>
		</tr>
		<!-- BEGIN linkrow -->
		<tr>
		<td rowspan="2" valign="top" align="right" class="{linkrow.ROW_CLASS}">&nbsp;{linkrow.LINK_LOGO}&nbsp;</td>
		<td width="100%" class="{linkrow.ROW_CLASS}">
		<a href="{linkrow.LINK_URL}" target="_blank" class="genmed">{linkrow.LINK_TITLE}</a><br /><span class="genmed">{linkrow.LINK_DESC}</span>
		</td>
		</tr>
		<tr>
		<td class="{linkrow.ROW_CLASS}" align="center"><span class="genmed">{L_LINK_CATEGORY}: {linkrow.LINK_CATEGORY}&nbsp;&nbsp;,&nbsp;{L_LINK_JOINED}: {linkrow.LINK_JOINED}&nbsp;&nbsp;,&nbsp;{L_LINK_HITS}: {linkrow.LINK_HITS}&nbsp;&nbsp;,&nbsp;{L_LINK_SUBMITER}&nbsp;{linkrow.U_LINK_USER}</span></td>
		</tr>
		<!-- END linkrow -->
		</table><br />
		<table width="100%" cellspacing="0" cellpadding="0" border="0">
		  <tr> 
			<td valign="top"><span class="nav">{PAGE_NUMBER}</span></td>
			<td align="right"><span class="gensmall">{S_TIMEZONE}</span><br /><span class="nav">{PAGINATION}</span></td>
		  </tr>
		</table>	  
	  </td>
	</tr> 
</table>