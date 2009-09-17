<?php if (!defined('THINK_PATH')) exit();?>﻿<p class="page_title_text"><img src="../Public/Images/user.gif" align="absmiddle"/> Staff</p>
<table cellpadding="2" border="1">
<tr>
	<th>Staff Code</th>
	<th>Staff Name</th>
	<th>Department</th>
	<th>E_mail</th>
	<th>Leader</th>
	<th>Role</th>
	<th></th>
</tr>
<?php if(is_array($result)): $i = 0; $__LIST__ = $result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): ++$i;$mod = ($i % 2 )?><tr>
	<td><?php echo ($item['code']); ?></td>
	<td><?php echo ($item['name']); ?></td>
	<td>[<?php echo ($item['dept']['code']); ?>]<?php echo ($item['dept']['name']); ?></td>
	<td><?php echo ($item['email']); ?></td>
	<td><?php echo ($item['leader']['realname']); ?></td>
	<td><?php if($item['id'] == 1): ?>System Administrator
		<?php else: ?>
			<?php if(is_array($item['role'])): $j = 0; $__LIST__ = $item['role'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$role): ++$j;$mod = ($j % 2 )?><?php echo ($role['name']); ?><br /><?php endforeach; endif; else: echo "" ;endif; ?><?php endif; ?></td>
	<td><a href="__URL__/form/id/<?php echo ($item['id']); ?>">Edit</a></td>
</tr><?php endforeach; endif; else: echo "" ;endif; ?>
</table>
<p class="center">
	<input type="button" onclick="javascript:document.location='__URL__/form';" value="Add a new staff" />
</p>