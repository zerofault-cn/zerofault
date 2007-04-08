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
<form method="get" name="jumpbox" action="{S_JUMPBOX_ACTION}" onSubmit="if(document.jumpbox.f.value == -1){return false;}"><table cellspacing="0" cellpadding="0" border="0">
	<tr> 
		<td nowrap="nowrap"><span class="gensmall">{L_JUMP_TO}:&nbsp;
		<select name="{JUMP_NAME}" onchange="if(this.options[this.selectedIndex].value != -1){ forms['jumpbox'].submit() }"> 
		<script language="JavaScript">{S_JUMPBOX_SELECT}</script> 
		</select>
		&nbsp;<input type="submit" value="{L_GO}" class="liteoption" /></span></td>
	</tr>
</table></form>
