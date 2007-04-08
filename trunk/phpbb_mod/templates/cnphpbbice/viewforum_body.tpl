
<form method="post" action="{S_POST_DAYS_ACTION}">
  <table width="100%" cellspacing="2" cellpadding="2" border="0" align="center">
	<tr> 
	  <td colspan="2">
	    <table>
		  <tr>
			<td align="center"> {FORUM_ICON} </td>
			<td align="left" valign="bottom"><a class="maintitle" href="{U_VIEW_FORUM}">{FORUM_NAME}</a><br /><span class="gensmall"><b>{L_MODERATOR}: {MODERATORS}<br /><br />{LOGGED_IN_USER_LIST}</b></span></td>
	      </tr>
		</table>
	  </td>
	  <td align="right" valign="bottom" nowrap="nowrap"><span class="gensmall"><b>{PAGINATION}</b></span></td>
	</tr>
	<tr> 
	  <td align="left" valign="middle" width="50"><a href="{U_POST_NEW_TOPIC}"><img src="{POST_IMG}" border="0" alt="{L_POST_NEW_TOPIC}" /></a></td>
	  <td align="left" valign="middle" class="nav" width="100%"><span class="nav">&nbsp;&nbsp;&nbsp;<a href="{U_INDEX}" class="nav">{L_INDEX}</a> {FORUM_PATH}</span></td>
	  <td align="right" valign="bottom" class="nav" nowrap="nowrap"><span class="gensmall"><a href="{U_VIEW_FORUM_COMMEND}">{L_FORUM_COMMEND}</a><br /><a href="{U_MARK_READ}">{L_MARK_TOPICS_READ}</a></span></td>
	</tr>
  </table>

  <!-- BEGIN sub_forum -->
  <table width="100%" cellpadding="3" cellspacing="1" border="0" class="forumline">
  	<tr>
	  <th colspan="6" align="center" height="25" class="thCornerL" nowrap="nowrap"><img src="templates/cnphpbbice/images/cella.gif" width="20" height="16" align="absmiddle">{FORUM_NAME}</th>
    </tr>
	<tr>
  		<td width="52"  align="center" nowrap class="catLeft">&nbsp;</td>
  		<td width="100%" class="catLeft">&nbsp;<span class="cattitle">{sub_forum.L_FORUM}</span>&nbsp;</td>
  		<td width="50" align="center" nowrap  class="catLeft">&nbsp;<span class="cattitle">{L_TOPICS}</span>&nbsp;</td>
  		<td width="50" align="center" nowrap  class="catLeft">&nbsp;<span class="cattitle">{L_POSTS}</span>&nbsp;</td>
  		<td width="170" align="center" nowrap  class="catLeft">&nbsp;<span class="cattitle">{L_LASTPOST}</span>&nbsp;</td>
  		<td width="140" align="center" nowrap class="catLeft">&nbsp;<span class="cattitle">{sub_forum.L_MODERATOR}</span></td>
  		</tr>
  	<!-- BEGIN forumrow -->
  	<tr>
  		<td class="row1" align="center" valign="middle" height="50"><img src="{sub_forum.forumrow.FORUM_FOLDER_IMG}" alt="{sub_forum.forumrow.L_FORUM_FOLDER_ALT}" title="{sub_forum.forumrow.L_FORUM_FOLDER_ALT}" /></td>
  		<td class="row1" width="100%" height="50"><table width="100%" cellpadding="0" cellspacing="3" border="0"><tr><td>{sub_forum.forumrow.FORUM_ICON}</td><td width="100%"><span class="forumlink"> <a href="{sub_forum.forumrow.U_VIEWFORUM}" class="forumlink">{sub_forum.forumrow.FORUM_NAME}</a><br /></span> <span class="genmed">{sub_forum.forumrow.FORUM_DESC} {sub_forum.forumrow.FORUM_NAME_SUB}</span></td></tr></table></td>
  		<td align="center" valign="middle" class="row2"><span class="gensmall">{sub_forum.forumrow.TOPICS}</span></td>
  		<td align="center" valign="middle" class="row2"><span class="gensmall">{sub_forum.forumrow.POSTS}</span></td>
  		<td class="row2" align="center" valign="middle" height="50" nowrap="nowrap"><span class="gensmall">{sub_forum.forumrow.LAST_POST}</span></td>
  		<td class="row1" align="center" valign="middle" ><span class="gensmall">{sub_forum.forumrow.MODERATORS}</span></td>
  		</tr>
  	<!-- END forumrow -->
  	</table>
  <br />
  <!-- END sub_forum -->

  <table border="0" cellpadding="4" cellspacing="1" width="100%" class="forumline">
	<tr>
	  <th colspan="6" align="center" height="25" class="thCornerL" nowrap="nowrap"><img src="templates/cnphpbbice/images/cella.gif" width="20" height="16" align="absmiddle">{FORUM_NAME}</th>
    </tr>
	<tr> 
	  <td colspan="2" align="center"  class="catLeft" nowrap="nowrap">&nbsp;<span class="cattitle">{L_TOPICS}</span>&nbsp;</td>
	  <td width="50" align="center" class="catLeft" nowrap="nowrap">&nbsp;<span class="cattitle">{L_REPLIES}</span>&nbsp;</td>
	  <td width="100" align="center" class="catLeft" nowrap="nowrap">&nbsp;<span class="cattitle">{L_AUTHOR}</span>&nbsp;</td>
	  <td width="50" align="center" class="catLeft" nowrap="nowrap">&nbsp;<span class="cattitle">{L_VIEWS}</span>&nbsp;</td>
	  <td align="center" class="catLeft" nowrap="nowrap">&nbsp;<span class="cattitle">{L_LASTPOST}</span>&nbsp;</td>
	</tr>
	<!-- BEGIN topicrow -->
	{topicrow.S_TABLE}
	<tr> 
	  <td class="row1" align="center" valign="middle" width="20"><img src="{topicrow.TOPIC_FOLDER_IMG}" alt="{topicrow.L_TOPIC_FOLDER_ALT}" title="{topicrow.L_TOPIC_FOLDER_ALT}" /></td>
	  <td class="row1" width="100%"><span class="topictitle">{topicrow.NEWEST_POST_IMG}{topicrow.TOPIC_ATTACHMENT_IMG}{topicrow.TOPIC_TYPE}<a href="{topicrow.U_VIEW_TOPIC}" class="topictitle">{topicrow.TOPIC_TITLE}</a></span><span class="gensmall"><br />
		{topicrow.GOTO_PAGE}</span></td>
	  <td class="row2" align="center" valign="middle"><span class="postdetails">{topicrow.REPLIES}</span></td>
	  <td class="row3" align="center" valign="middle"><span class="name">{topicrow.TOPIC_AUTHOR}</span></td>
	  <td class="row2" align="center" valign="middle"><span class="postdetails">{topicrow.VIEWS}</span></td>
	  <td class="row3Right" align="center" valign="middle" nowrap="nowrap"><span class="postdetails">{topicrow.LAST_POST_TIME}<br />{topicrow.LAST_POST_AUTHOR} {topicrow.LAST_POST_IMG}</span></td>
	</tr>
	<!-- END topicrow -->
	<!-- BEGIN switch_no_topics -->
	<tr> 
	  <td class="row1" colspan="6" height="30" align="center" valign="middle"><span class="gen">{L_NO_TOPICS}</span></td>
	</tr>
	<!-- END switch_no_topics -->
	<tr> 
	  <td class="catBottom" align="center" valign="middle" colspan="6" height="26"><span class="genmed">{L_DISPLAY_TOPICS}:&nbsp;{S_SELECT_TOPIC_DAYS}&nbsp; 
		<input type="submit" class="liteoption" value="{L_GO}" name="submit" />
		</span></td>
	</tr>
  </table>

  <table width="100%" cellspacing="2" border="0" align="center" cellpadding="2">
	<tr> 
	  <td align="left" valign="middle" width="50"><a href="{U_POST_NEW_TOPIC}"><img src="{POST_IMG}" border="0" alt="{L_POST_NEW_TOPIC}" /></a></td>
	  <td align="left" valign="middle" width="100%"><span class="nav">&nbsp;&nbsp;&nbsp;<a href="{U_INDEX}" class="nav">{L_INDEX}</a> {FORUM_PATH}</span></td>
	  <td align="right" valign="middle" nowrap="nowrap"><span class="gensmall">{S_TIMEZONE}</span><br /><span class="nav">{PAGINATION}</span> 
	  </td>
	</tr>
	<tr>
	  <td align="left" colspan="3"><span class="nav">{PAGE_NUMBER}</span></td>
	</tr>
  </table>
</form>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
	<td align="right">{JUMPBOX}</td>
  </tr>
</table>

<table width="100%" cellspacing="0" border="0" align="center" cellpadding="0">
	<tr>
		<td align="left" valign="top"><table cellspacing="3" cellpadding="0" border="0">
        	<tr>
        		<td align="left"><img src="{FOLDER_NEW_IMG}" alt="{L_NEW_POSTS}" /></td>
        		<td class="gensmall">{L_NEW_POSTS}</td>
        		<td>&nbsp;&nbsp;</td>
        		<td align="center"><img src="{FOLDER_IMG}" alt="{L_NO_NEW_POSTS}" /></td>
        		<td class="gensmall">{L_NO_NEW_POSTS}</td>
        		<td>&nbsp;&nbsp;</td>
        		<td align="center"><img src="{FOLDER_GLOBAL_ANNOUNCE_IMG}" alt="{L_GLOBAL_ANNOUNCEMENT}" /></td>
        		<td class="gensmall">{L_GLOBAL_ANNOUNCEMENT}</td>
        		</tr>
        	<tr>
        		<td><img src="{FOLDER_HOT_NEW_IMG}" alt="{L_NEW_POSTS_HOT}" /></td>
        		<td class="gensmall">{L_NEW_POSTS_HOT}</td>
        		<td>&nbsp;&nbsp;</td>
        		<td align="center"><img src="{FOLDER_HOT_IMG}" alt="{L_NO_NEW_POSTS_HOT}" /></td>
        		<td class="gensmall">{L_NO_NEW_POSTS_HOT}</td>
        		<td>&nbsp;&nbsp;</td>
        		<td align="center"><img src="{FOLDER_ANNOUNCE_IMG}" alt="{L_ANNOUNCEMENT}" /></td>
        		<td class="gensmall">{L_ANNOUNCEMENT}</td>
        		</tr>
        	<tr>
        		<td class="gensmall"><img src="{FOLDER_LOCKED_NEW_IMG}" alt="{L_NEW_POSTS_LOCKED}" /></td>
        		<td class="gensmall">{L_NEW_POSTS_LOCKED}</td>
        		<td>&nbsp;&nbsp;</td>
        		<td class="gensmall"><img src="{FOLDER_LOCKED_IMG}" alt="{L_NO_NEW_POSTS_LOCKED}" /></td>
        		<td class="gensmall">{L_NO_NEW_POSTS_LOCKED}</td>
        		<td>&nbsp;&nbsp;</td>
        		<td align="center"><img src="{FOLDER_STICKY_IMG}" alt="{L_STICKY}" /></td>
        		<td class="gensmall">{L_STICKY}</td>
        		</tr>
        	<tr>
        		<td class="gensmall"><img src="{FOLDER_COMMEND_NEW_IMG}" alt="{L_COMMEND}" /></td>
        		<td class="gensmall">{L_NEW_COMMEND}</td>
        		<td>&nbsp;&nbsp;</td>
        		<td class="gensmall"><img src="{FOLDER_COMMEND_IMG}" alt="{L_COMMEND}" /></td>
        		<td class="gensmall">{L_NO_NEW_COMMEND}</td>
        		<td>&nbsp;&nbsp;</td>
        		<td align="center">&nbsp;</td>
        		<td class="gensmall">&nbsp;</td>
        		</tr>
        	</table></td>
		<td align="right" valign="top"><span class="gensmall">{S_AUTH_LIST}</span></td>
	</tr>
</table>
