<a name="top"></a>

<h1>{L_PAGE_TITLE}</h1>

<p>{L_PAGE_DESC}</p>
<br />
<form name="post" method="post" action="{S_RESYNC_ACTION}">

<table cellspacing="1" cellpadding="4" border="0" align="center" class="forumline">
	<tr>
		<th colspan="2" class="thHead">{L_RESYNC_OPTIONS}</th>
	</tr>
	<tr>
		<td class="row2"><span class="gen">{L_FORUM_TOPICS}</span></td>
		<td class="row2"><input type="checkbox" name="forum_topics" value="1" checked="checked" /></td>
	</tr>
	<tr>
		<td class="row1"><span class="gen">{L_FORUM_POSTS}</span></td>
		<td class="row1"><input type="checkbox" name="forum_posts" value="1" checked="checked" /></td>
	</tr>
	<tr>
		<td class="row2"><span class="gen">{L_FORUM_LAST_POST}</span></td>
		<td class="row2"><input type="checkbox" name="forum_last_post" value="1" checked="checked" /></td>
	</tr>
	<tr>
		<td class="row1"><span class="gen">{L_TOPIC_REPLIES}</span></td>
		<td class="row1"><input type="checkbox" name="topic_replies" value="1" checked="checked" /></td>
	</tr>
	<tr>
		<td class="row2"><span class="gen">{L_TOPIC_LAST_POST}</span></td>
		<td class="row2"><input type="checkbox" name="topic_last_post" value="1" checked="checked" /></td>
	</tr>
</table>
<br /><br />
<table cellspacing="1" cellpadding="4" border="0" align="center" class="forumline">
	<tr>
	  <th class="thCornerL">{L_CATEGORY}</th>
	  <th class="thTop">{L_FORUM}</th>
	  <th class="thCornerR" width="100">{L_RESYNCQ}</th>
	</tr>
<!-- BEGIN forums -->
	<tr>
	  <td class="row{forums.ROW_CLASS}" align="center">{forums.CATEGORY_NAME}</td>
	  <td class="row{forums.ROW_CLASS}" align="center">{forums.FORUM_NAME}</td>
	  <td class="row{forums.ROW_CLASS}" align="center"><input type="checkbox" name="forum_{forums.FORUM_ID}" value="1" /></td>
	</tr>
<!-- END forums -->
<tr>
	  <td colspan="3" class="row1" align="center"> <span class="gensmall"><a href="{U_MODE_CHANGE}">{L_MODE_CHANGE}</a></span></td>
	</tr>
	<tr>
	  <td colspan="3" class="catBottom" align="center">
		<input type="submit" name="doresync" value="{L_DO_RESYNC}" class="mainoption" />&nbsp;&nbsp;<input type="reset" value="{L_RESET}" class="liteoption" name="reset" />
	  </td>
	</tr>
  </table>
</form>