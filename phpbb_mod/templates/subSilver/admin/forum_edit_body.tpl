
<h1>{L_FORUM_TITLE}</h1>

<p>{L_FORUM_EXPLAIN}</p>

<script language="JavaScript"> 
function add_select(val,na,s,sort) 
{ 
	var temp=""; 
	if(sort>0) 
	{ 
		na="¡ú "+na;
	}
	for(var i=0;i<sort;i++) 
	{ 
		temp+="¡¡";
	}
	document.write('<option value="'+val+'" '+s+'>'+temp+na+'</option>'); 
} 
</script>

<form action="{S_FORUM_ACTION}" method="post">
  <table width="100%" cellpadding="4" cellspacing="1" border="0" class="forumline" align="center">
	<tr> 
	  <th class="thHead" colspan="2">{L_FORUM_SETTINGS}</th>
	</tr>
	<tr> 
	  <td class="row1">{L_FORUM_NAME}</td>
	  <td class="row2"><input type="text" size="25" name="forumname" value="{FORUM_NAME}" class="post" /></td>
	</tr>
	<tr> 
	  <td class="row1">{L_FORUM_DESCRIPTION}</td>
	  <td class="row2"><textarea rows="5" cols="45" wrap="virtual" name="forumdesc" class="post">{DESCRIPTION}</textarea></td>
	</tr>
	<tr> 
	  <td class="row1">{L_CATEGORY}</td>
	  <td class="row2"><select name="c"><script language="JavaScript">{S_CAT_LIST}</script></select></td>
	</tr>
	<tr> 
	  <td class="row1">{L_FORUM_STATUS}</td>
	  <td class="row2"><select name="forumstatus">{S_STATUS_LIST}</select></td>
	</tr>
	<tr> 
	  <td class="row1">{L_FORUM_ICON}</td>
	  <td class="row2"><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td width="200" nowrap="nowrap"><select name="forumicon" onChange="if (this.value!='') document.images['forumicon'].src = '../images/icons/' + this.value; else document.images['forumicon'].src = '../images/icons/no_icons.gif';" >{S_ICON_SELECT}</select></td><td align="left" width="100%">{FORUM_ICON_IMG}</td></tr><td colspan="2">{L_FORUM_ICON_EXPLAIN}</td></tr></table></td>
	</tr>
	<tr> 
	  <td class="row1">{L_AUTO_PRUNE}</td>
	  <td class="row2"><table cellspacing="0" cellpadding="1" border="0">
		  <tr> 
			<td align="right" valign="middle">{L_ENABLED}</td>
			<td align="left" valign="middle"><input type="checkbox" name="prune_enable" value="1" {S_PRUNE_ENABLED} /></td>
		  </tr>
		  <tr> 
			<td align="right" valign="middle">{L_PRUNE_DAYS}</td>
			<td align="left" valign="middle">&nbsp;<input type="text" name="prune_days" value="{PRUNE_DAYS}" size="5" class="post" />&nbsp;{L_DAYS}</td>
		  </tr>
		  <tr> 
			<td align="right" valign="middle">{L_PRUNE_FREQ}</td>
			<td align="left" valign="middle">&nbsp;<input type="text" name="prune_freq" value="{PRUNE_FREQ}" size="5" class="post" />&nbsp;{L_DAYS}</td>
		  </tr>
	  </table></td>
	</tr>
	<tr> 
	  <td class="catBottom" colspan="2" align="center">{S_HIDDEN_FIELDS}<input type="submit" name="submit" value="{S_SUBMIT_VALUE}" class="mainoption" /></td>
	</tr>
  </table>
</form>
		
<br clear="all" />
