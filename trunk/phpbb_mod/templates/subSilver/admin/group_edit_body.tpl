
<h1>{L_GROUP_TITLE}</h1>

<form action="{S_GROUP_ACTION}" method="post" name="post"><table border="0" cellpadding="3" cellspacing="1" class="forumline" align="center">
	<tr> 
	  <th class="thHead" colspan="2">{L_GROUP_EDIT_DELETE}</th>
	</tr>
	<tr>
	  <td class="row1" colspan="2"><span class="gensmall">{L_ITEMS_REQUIRED}</span></td>
	</tr>
	<tr> 
	  <td class="row1" width="38%"><span class="gen">{L_GROUP_NAME}:</span></td>
	  <td class="row2" width="62%"> 
		<input class="post" type="text" name="group_name" size="35" maxlength="40" value="{GROUP_NAME}" />
	  </td>
	</tr>
	<tr> 
	  <td class="row1" width="38%"><span class="gen">{L_GROUP_DESCRIPTION}:</span></td>
	  <td class="row2" width="62%"> 
		<textarea class="post" name="group_description" rows="5" cols="51">{GROUP_DESCRIPTION}</textarea>
	  </td>
	</tr>
	<tr> 
	  <td class="row1" width="38%"><span class="gen">{L_GROUP_MODERATOR}:</span></td>
	  <td class="row2" width="62%"><input class="post" type="text" name="username" maxlength="50" size="20" value="{GROUP_MODERATOR}" /> &nbsp; <input type="submit" name="usersubmit" value="{L_FIND_USERNAME}" class="liteoption" onClick="window.open('{U_SEARCH_USER}', '_phpbbsearch', 'HEIGHT=250,resizable=yes,WIDTH=400');return false;" /></td>
	</tr>

	<tr> 
	  <td class="row1" width="38%"><span class="gen">{L_GROUP_STATUS}:</span></td>
	  <td class="row2" width="62%"> 
		<input type="radio" name="group_type" value="{S_GROUP_OPEN_TYPE}" {S_GROUP_OPEN_CHECKED} /> {L_GROUP_OPEN} &nbsp;&nbsp;<input type="radio" name="group_type" value="{S_GROUP_CLOSED_TYPE}" {S_GROUP_CLOSED_CHECKED} />	{L_GROUP_CLOSED} &nbsp;&nbsp;<input type="radio" name="group_type" value="{S_GROUP_HIDDEN_TYPE}" {S_GROUP_HIDDEN_CHECKED} />	{L_GROUP_HIDDEN}</td> 
	</tr>
	<tr> 
	  <td class="row1" width="38%"><span class="gen">{L_GROUP_ALLOW_PM}:</span><br/>
	  <span class="gensmall">{L_GROUP_ALLOW_PM_EXPLAIN}</span></td>
	  <td class="row2" width="62%">
		<input type="radio" name="group_allow_pm" value="{S_GROUP_ALL_ALLOW_PM}" {S_GROUP_ALL_ALLOW_PM_CHECKED} /> {L_GROUP_ALL_ALLOW_PM} &nbsp;&nbsp;
		<input type="radio" name="group_allow_pm" value="{S_GROUP_REG_ALLOW_PM}" {S_GROUP_REG_ALLOW_PM_CHECKED} /> {L_GROUP_REG_ALLOW_PM} &nbsp;&nbsp;
		<input type="radio" name="group_allow_pm" value="{S_GROUP_PRIVATE_ALLOW_PM}" {S_GROUP_PRIVATE_ALLOW_PM_CHECKED} /> {L_GROUP_PRIVATE_ALLOW_PM} &nbsp;&nbsp;
		<input type="radio" name="group_allow_pm" value="{S_GROUP_MOD_ALLOW_PM}" {S_GROUP_MOD_ALLOW_PM_CHECKED} /> {L_GROUP_MOD_ALLOW_PM} &nbsp;&nbsp;
		<input type="radio" name="group_allow_pm" value="{S_GROUP_ADMIN_ALLOW_PM}" {S_GROUP_ADMIN_ALLOW_PM_CHECKED} /> {L_GROUP_ADMIN_ALLOW_PM} 
	  </td> 
	</tr>
	<tr> 
		<td class="row1" width="38%"><span class="gen">{L_GROUP_COUNT}:<br/>{L_GROUP_COUNT_MAX}:</span><br/><span class="gensmall">{L_GROUP_COUNT_EXPLAIN}</span></td>
		<td class="row2" width="62%"><input type="text" class="post" name="group_count" maxlength="12" size="12" value="{GROUP_COUNT}" /><br/><input type="text" class="post" name="group_count_max" maxlength="12" size="12" value="{GROUP_COUNT_MAX}" />
			<br/>&nbsp;&nbsp; <input type="checkbox" name="group_count_enable" {GROUP_COUNT_ENABLE_CHECKED} >&nbsp;{L_GROUP_COUNT_ENABLE}
			<br/>&nbsp;&nbsp; <input type="checkbox" name="group_count_update" value="0"/>&nbsp;{L_GROUP_COUNT_UPDATE}
			<br/>&nbsp;&nbsp; <input type="checkbox" name="group_count_delete" value="0"/>&nbsp;{L_GROUP_COUNT_DELETE}</td>
	</tr>
	<!-- BEGIN group_edit -->
	<tr> 
	  <td class="row1" width="38%"><span class="gen">{L_DELETE_MODERATOR}</span>
	  <br />
	  <span class="gensmall">{L_DELETE_MODERATOR_EXPLAIN}</span></td>
	  <td class="row2" width="62%"> 
		<input type="checkbox" name="delete_old_moderator" value="1">
		{L_YES}</td>
	</tr>
	<tr> 
	  <td class="row1" width="38%"><span class="gen">{L_GROUP_DELETE}:</span></td>
	  <td class="row2" width="62%"> 
		<input type="checkbox" name="group_delete" value="1">
		{L_GROUP_DELETE_CHECK}</td>
	</tr>
	<tr> 
	  <td class="row1"><span class="gen">{L_UPLOAD_QUOTA}</span></td>
	  <td class="row2">{S_SELECT_UPLOAD_QUOTA}</td>
	</tr>
	<tr> 
	  <td class="row1"><span class="gen">{L_PM_QUOTA}</span></td>
	  <td class="row2">{S_SELECT_PM_QUOTA}</td>
	</tr>
	<!-- END group_edit -->
	<tr> 
	  <td class="catBottom" colspan="2" align="center"><span class="cattitle"> 
		<input type="submit" name="group_update" value="{L_SUBMIT}" class="mainoption" />
		&nbsp;&nbsp; 
		<input type="reset" value="{L_RESET}" name="reset" class="liteoption" />
		</span></td>
	</tr>
</table>{S_HIDDEN_FIELDS}</form>
