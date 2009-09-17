<?php if (!defined('THINK_PATH')) exit();?>﻿<p class="page_title_text"><img src="../Public/Images/supplier.gif" align="absmiddle"/> Supplier</p>
<table cellpadding="2" border="1">
<tr>
	<th>Code</th>
	<th>Supplier Name</th>
	<th>Character</th>
	<th>Currency</th>
	<th>Address</th>
	<th></th>
</tr>
<?php if(is_array($result)): $i = 0; $__LIST__ = $result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): ++$i;$mod = ($i % 2 )?><tr>
	<td><?php echo ($item['code']); ?></td>
	<td><?php echo ($item['name']); ?></td>
	<td><?php echo ($item['character']['title']); ?></td>
	<td><?php echo ($item['currency']['title']); ?></td>
	<td><?php echo ($item['address']); ?></td>
	<td><a href="__URL__/form/id/<?php echo ($item['id']); ?>">Edit</td>
</tr><?php endforeach; endif; else: echo "" ;endif; ?>
</table>
<p class="center">
	<input type="button" onclick="javascript:document.location='__URL__/form';" value="Add a New Supplier" />
</p>