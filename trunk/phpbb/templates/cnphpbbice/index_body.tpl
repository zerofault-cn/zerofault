<table width="100%" cellspacing="0" cellpadding="2" border="0" align="center">
  <tr> 
	<td align="left" valign="bottom"><span class="gensmall">
	<!-- BEGIN switch_user_logged_in -->
	{LAST_VISIT_DATE}<br />
	<!-- END switch_user_logged_in -->
	{CURRENT_TIME}<br /></span><span class="nav"><a href="{U_INDEX}" class="nav">{L_INDEX}</a></span></td>
	<td align="right" valign="bottom" class="gensmall">
		<!-- BEGIN switch_user_logged_in -->
		<a href="{U_SEARCH_NEW}" class="gensmall">{L_SEARCH_NEW}</a><br /><a href="{U_SEARCH_SELF}" class="gensmall">{L_SEARCH_SELF}</a><br />
		<!-- END switch_user_logged_in -->
		<a href="{U_SEARCH_UNANSWERED}" class="gensmall">{L_SEARCH_UNANSWERED}</a></td>
  </tr>
</table>
<!-- BEGIN switch_user_logged_out -->
<form method="post" action="{S_LOGIN_ACTION}">
  <table width="100%" cellpadding="1" cellspacing="1" border="0" class="forumline">
	<tr> 
	  <td class="catLeft" align="center" valign="middle"><span class="gensmall">{L_USERNAME}: 
		<input class="post" type="text" name="username" size="10" />
		&nbsp;&nbsp;&nbsp;{L_PASSWORD}: 
		<input class="post" type="password" name="password" size="10" maxlength="32" />
		&nbsp;&nbsp; &nbsp;&nbsp;{L_AUTO_LOGIN} 
		<input class="text" type="checkbox" name="autologin" />
		&nbsp;&nbsp;&nbsp; 
		<input type="submit" class="mainoption" name="login" value="{L_LOGIN}" />
		</span> </td>
	</tr>
  </table>
</form>
<!-- END switch_user_logged_out -->

<!-- BEGIN catrow -->
<table width="100%" cellpadding="3" cellspacing="1" border="0" class="forumline">
   <tr align="left">
    <th height="28" colspan="6" class="thCornerL"><img src="templates/cnphpbbice/images/cella.gif" width="20" height="16" align="absmiddle"><a href="{catrow.U_VIEWCAT}" class="bnav">{catrow.CAT_DESC}</a></th>
  </tr>
  <tr> 
	<td width="52"  align="center" nowrap class="catLeft">&nbsp;</td>
	<td width="100%" class="catLeft">&nbsp;<span class="cattitle">{L_FORUM}</span>&nbsp;</td>
	<td width="50" align="center" nowrap  class="catLeft">&nbsp;<span class="cattitle">{L_TOPICS}</span>&nbsp;</td>
	<td width="50" align="center" nowrap  class="catLeft">&nbsp;<span class="cattitle">{L_POSTS}</span>&nbsp;</td>
	<td width="170" align="center" nowrap  class="catLeft">&nbsp;<span class="cattitle">{L_LASTPOST}</span>&nbsp;</td>
    <td width="140" align="center" nowrap class="catLeft">&nbsp;<span class="cattitle">{L_MODERATOR}&nbsp;</span></td>
  </tr>
  <!-- BEGIN forumrow -->
  <tr> 
	<td class="row1" align="center" valign="middle" height="50"><img src="{catrow.forumrow.FORUM_FOLDER_IMG}" alt="{catrow.forumrow.L_FORUM_FOLDER_ALT}" title="{catrow.forumrow.L_FORUM_FOLDER_ALT}" /></td>
	<td class="row1" width="100%" height="50"><span class="forumlink"> <a href="{catrow.forumrow.U_VIEWFORUM}" class="forumlink">{catrow.forumrow.FORUM_NAME}</a><br />
	  </span> <span class="genmed">{catrow.forumrow.FORUM_DESC}<br />
	  </span></td>
	<td align="center" valign="middle" class="row2"><span class="gensmall">{catrow.forumrow.TOPICS}</span></td>
	<td align="center" valign="middle" class="row2"><span class="gensmall">{catrow.forumrow.POSTS}</span></td>
	<td class="row2" align="center" valign="middle" height="50" nowrap="nowrap"> <span class="gensmall">{catrow.forumrow.LAST_POST}</span></td>
    <td class="row1" align="center" valign="middle" ><span class="gensmall">{catrow.forumrow.MODERATORS}</span></td>
  </tr>
  <!-- END forumrow -->
</table>
<br>

<!-- END catrow -->

<table width="100%" cellspacing="0" border="0" align="center" cellpadding="2">
  <tr> 
	<td align="left"><span class="gensmall"><a href="{U_MARK_READ}" class="gensmall">{L_MARK_FORUMS_READ}</a></span></td>
	<td align="right"><span class="gensmall">{S_TIMEZONE}</span></td>
  </tr>
</table>

<table width="100%" cellpadding="3" cellspacing="1" border="0" class="forumline">
  <tr> 
	<td class="catHead" colspan="2" height="28"><span class="cattitle"><a href="{U_VIEWONLINE}" class="cattitle">{L_WHO_IS_ONLINE}</a></span></td>
  </tr>
  <tr> 
	<td class="row1" align="center" valign="middle" rowspan="3"><img src="templates/cnphpbbice/images/whosonline.gif" alt="{L_WHO_IS_ONLINE}" /></td>
	<td class="row1" align="left" width="100%"><span class="gensmall">{TOTAL_POSTS} | {TOTAL_USERS} | 
	  {NEWEST_USER}</span>	</td>
  </tr>
  <tr> 
	<td class="row1" align="left"><span class="gensmall">{TOTAL_USERS_ONLINE} &nbsp; [ {L_WHOSONLINE_ADMIN} ] &nbsp; [ {L_WHOSONLINE_MOD} ]<br />{RECORD_USERS}<br />{LOGGED_IN_USER_LIST}</span></td>
  </tr>
  <!-- Start add - Birthday MOD -->
  <tr>
	<td class="row1" align="left"><span class="gensmall">{L_WHOSBIRTHDAY_TODAY}<br />{L_WHOSBIRTHDAY_WEEK}</span></td>
  </tr>
<!-- End add - Birthday MOD -->
</table>

<table width="100%" cellpadding="1" cellspacing="1" border="0">
<tr>
	<td align="left" valign="top"><span class="gensmall">{L_ONLINE_EXPLAIN}</span></td>
</tr>
</table>
<table width="100%" cellpadding="3" cellspacing="1" border="0" class="forumline">
  <tr> 
	<td class="catLeft" width="100%" height="22"><span class="cattitle"><a href="{U_LINKS}" class="cattitle" target="_blank">{L_LINKS}</a></span></td>
	<td class="catRight" nowrap="nowrap" align="center"><span class="cattitle">{SITENAME}</span></td>
  </tr>
  <tr> 
	<td class="row1" nowrap="nowrap"><iframe marginwidth="0" marginheight="0" src="{U_LINKS_JS}" frameborder="0" scrolling="no" width="100%" height="{SITE_LOGO_HEIGHT}"></iframe></td>
	<td class="row2" nowrap="nowrap"><img src="{U_SITE_LOGO}" alt="{SITENAME}" width="{SITE_LOGO_WIDTH}" height="{SITE_LOGO_HEIGHT}" border="0" /></td>
  </tr>
</table>

<br clear="all" />
<table cellspacing="3" border="0" align="center" cellpadding="0">
  <tr> 
	<td width="20" align="center"><img src="templates/cnphpbbice/images/folder_new_big.gif" alt="{L_NEW_POSTS}"/></td>
	<td><span class="gensmall">{L_NEW_POSTS}</span></td>
	<td>&nbsp;&nbsp;</td>
	<td width="20" align="center"><img src="templates/cnphpbbice/images/folder_big.gif" alt="{L_NO_NEW_POSTS}" /></td>
	<td><span class="gensmall">{L_NO_NEW_POSTS}</span></td>
	<td>&nbsp;&nbsp;</td>
	<td width="20" align="center"><img src="templates/cnphpbbice/images/folder_locked_big.gif" alt="{L_FORUM_LOCKED}" /></td>
	<td><span class="gensmall">{L_FORUM_LOCKED}</span></td>
  </tr>
</table>
