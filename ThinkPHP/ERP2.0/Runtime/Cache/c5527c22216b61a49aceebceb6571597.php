<?php if (!defined('THINK_PATH')) exit();?>﻿<p class="page_title_text"> Commodity</p>
<table cellpadding="2" border="1">
<tr>
	<th>Commodity Code</th>
	<th>Commodity Name</th>
	<th></th>
</tr>
<?php if(is_array($result)): $i = 0; $__LIST__ = $result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): ++$i;$mod = ($i % 2 )?><tr>
	<td><?php echo ($item['code']); ?></td>
	<td><?php echo ($item['name']); ?></td>
	<td><a href="__URL__/form/id/<?php echo ($item['id']); ?>">Edit</a></td>
</tr><?php endforeach; endif; else: echo "" ;endif; ?>
</table>
<p class="center">
	<input type="button" onclick="javascript:document.location='__URL__/form';" value="Add a New Commodity" />
</p>