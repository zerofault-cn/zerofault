<?php if (!defined('THINK_PATH')) exit();?>﻿<p class="page_title_text"><img src="../Public/Images/users.gif" align="absmiddle"/> Staff - Add new staff</p>
<form action="__URL__/submit" method="post" target="_iframe">
<input type="hidden" name="id" value="<?php echo ($info["id"]); ?>" />
<table>
<tr>
	<td>Staff Code:</td>
	<td><input type="text" maxlength="10" size="15" name="code" value="<?php echo ($code); ?>" readonly="true" /></td>
</tr>
<tr>
	<td>Staff Name:</td>
	<td><input type="text" maxlength="40" size="15" name="name" value="<?php echo ($info["name"]); ?>" /></td>
</tr>
<tr>
	<td>Staff Realname:</td>
	<td><input type="text" maxlength="40" size="15" name="realname" value="<?php echo ($info["realname"]); ?>" /></td>
</tr>
<tr>
	<td>Init Password:</td>
	<td><input type="password" maxlength="40" size="15" name="password" value="" /></td>
</tr>
<tr>
	<td>E_mail:</td>
	<td><input type="text" maxlength="40" size="15" name="email" value="<?php echo ($info["email"]); ?>" /></td>
</tr>
<tr>
	<td>Department:</td>
	<td><select name="dept_id"><option value="">Select One</option><?php echo ($info["dept_opts"]); ?></select></td>
</tr>
<tr>
	<td>Leader:</td>
	<td><select name="leader_id"><option value="">Select One</option><?php echo ($info["leader_opts"]); ?></select></td>
</tr>
<tr>
	<td>Role:</td>
	<td><?php echo ($info["role_chks"]); ?></td>
</tr>
</table>
<p class="center">
<?php if($info['id'] == 0): ?><input type="Submit" value="Insert New Staff" name="submit"/>
<?php else: ?>
<input type="Submit" value="Update Staff Profile" name="submit"/><?php endif; ?>
</p>
</form>