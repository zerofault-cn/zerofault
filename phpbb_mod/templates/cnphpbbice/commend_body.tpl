
<form method="post" action="{S_POST_DAYS_ACTION}">
  <table width="100%" cellspacing="2" cellpadding="0" border="0" align="center">
	<tr> 
	  <td align="center" valign="bottom" colspan="2"><h4><a href="{U_VIEW_COMMEND}">{COMMEND_NAME}</a></span></h4><br /></td>
	</tr>
	<tr> 
	  <td align="left" valign="middle" class="nav" width="100%"><span class="nav"><a href="{U_INDEX}" class="nav">{L_INDEX}</a> -> <a class="nav" href="{U_VIEW_FORUM}">{FORUM_NAME}</a> -> <a class="nav" href="{U_VIEW_COMMEND}">{COMMEND_NAME}</a></span></td>
	  <td align="right" valign="bottom" nowrap="nowrap"><span class="gensmall"><b>{PAGINATION}</b></span></td>
	</tr>
  </table>

  <table border="0" cellpadding="4" cellspacing="1" width="100%" class="forumline">
	<tr> 
	  <th class="thCornerL" colspan="2" align="center" height="25" nowrap="nowrap">&nbsp;{L_TOPICS}&nbsp;</th>
	  <th class="thTop" width="50" align="center" nowrap="nowrap">&nbsp;{L_REPLIES}&nbsp;</th>
	  <th class="thTop" width="50" align="center" nowrap="nowrap">&nbsp;{L_VIEWS}&nbsp;</th>
	  <th class="thTop" width="100" align="center" nowrap="nowrap">&nbsp;{L_AUTHOR}&nbsp;</th>
	  <th class="thCornerR" align="center" nowrap="nowrap">&nbsp;{L_LASTPOST}&nbsp;</th>
	</tr>
	<!-- BEGIN topicrow -->
	<tr> 
	  <td class="row1" align="center" valign="middle" width="20"><img src="{topicrow.TOPIC_FOLDER_IMG}" width="19" height="18" alt="{topicrow.L_TOPIC_FOLDER_ALT}" title="{topicrow.L_TOPIC_FOLDER_ALT}" /></td>
	  <td class="row1" width="100%"><span class="topictitle">{topicrow.NEWEST_POST_IMG}{topicrow.TOPIC_TYPE}<a href="{topicrow.U_VIEW_TOPIC}" class="topictitle">{topicrow.TOPIC_TITLE}</a></span><span class="gensmall"><br />
		{topicrow.GOTO_PAGE}</span></td>
	  <td class="row2" align="center" valign="middle"><span class="postdetails">{topicrow.REPLIES}</span></td>
	  <td class="row2" align="center" valign="middle"><span class="postdetails">{topicrow.VIEWS}</span></td>
	  <td class="row3" align="center" valign="middle"><span class="name">{topicrow.TOPIC_AUTHOR}</span></td>
	  <td class="row3" align="center" valign="middle" nowrap="nowrap"><span class="postdetails">{topicrow.LAST_POST_TIME}<br />{topicrow.LAST_POST_AUTHOR} {topicrow.LAST_POST_IMG}</span></td>
	</tr>
	<!-- END topicrow -->
	<!-- BEGIN switch_no_topics -->
	<tr> 
	  <td class="row1" colspan="6" height="30" align="center" valign="middle"><span class="gen">{L_NO_TOPICS}</span></td>
	</tr>
	<!-- END switch_no_topics -->
	<tr> 
	  <td class="catBottom" align="center" valign="middle" colspan="6" height="28"><span class="genmed">{L_DISPLAY_TOPICS}:&nbsp;{S_SELECT_TOPIC_DAYS}&nbsp; 
		<input type="submit" class="liteoption" value="{L_GO}" name="submit" />
		</span></td>
	</tr>
  </table>
<table border="0" cellpadding="0" cellspacing="0" class="tbl"><tr><td class="tbll"><img src="images/spacer.gif" alt="" width="8" height="4" /></td><td class="tblbot"><img src="images/spacer.gif" alt="" width="8" height="4" /></td><td class="tblr"><img src="images/spacer.gif" alt="" width="8" height="4" /></td></tr></table>

  <table width="100%" cellspacing="2" border="0" align="center" cellpadding="2">
	<tr>
	  <td align="left"><span class="nav">{PAGE_NUMBER}</span></td>
	</tr>
  </table>
</form>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
	<td align="right">{JUMPBOX}</td>
  </tr>
</table>

