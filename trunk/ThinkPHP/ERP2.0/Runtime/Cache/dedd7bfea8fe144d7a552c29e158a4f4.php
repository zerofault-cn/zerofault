<?php if (!defined('THINK_PATH')) exit();?>	<table id="table" border="1" cellpadding="3" cellspacing="0" width="100%" bordercolor="#999999" style="border-collapse:collapse;">
	<tr bgcolor="#ededed">
		<th width="5%">ID</th>
		<th width="15%">角色名称</th>
		<th>拥有权限</th>
		<th width="10%">操作</th>
	</tr>
	<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): ++$i;$mod = ($i % 2 )?><tr bgcolor="<?php if(($mod)  ==  "1"): ?>#FFFFE1<?php endif; ?>" class="<?php if(($item["status"])  ==  "0"): ?>gray<?php endif; ?>">
		<td><?php echo ($item["id"]); ?></td>
		<td><label id="<?php echo ($item['id']); ?>"><?php echo ($item['name']); ?></label></td>
		<td class="a_left">
			<?php if(is_array($item['Node'])): $j = 0; $__LIST__ = $item['Node'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$node): ++$j;$mod = ($j % 2 )?><?php if(empty($node['title'])): ?><?php echo ($node['name']); ?><?php else: ?><?php echo ($node['title']); ?><?php endif; ?>
				( <?php echo ($node['subNode']); ?> )
				<br /><?php endforeach; endif; else: echo "" ;endif; ?>
		</td>
		<td>
			<a href="__URL__/index/id/<?php echo ($item['id']); ?>" title="编辑"><img src="../Public/Image/options-edit.gif" alt="编辑" align="absmiddle"/></a>
			<a href="__URL__/update/id/<?php echo ($item['id']); ?>/f/status/v/<?php echo intval(!$item['status']);?>" target="_iframe" title='<?php if($item["status"] == 0): ?>启用<?php else: ?>禁用<?php endif; ?>'><?php if($item['status'] == 0): ?><img src="../Public/Image/add.gif" alt="启用" align="absmiddle"/><?php else: ?><img src="../Public/Image/delete.gif" alt="禁用" align="absmiddle"/><?php endif; ?></a>
			<img class="delete" id="<?php echo ($item['id']); ?>" name="<?php echo ($item['name']); ?>" src="../Public/Image/cross.gif" alt="彻底删除" align="absmiddle"/>
		</td>
	</tr><?php endforeach; endif; else: echo "" ;endif; ?>
	</table>
	<div class="addForm">
		<fieldset>
			<legend><?php if(isset($role_info)): ?>修改角色权限<?php else: ?>添加新角色<?php endif; ?></legend>
			<input type="hidden" class="role_id" value="<?php echo ($role_info['id']); ?>"/>
			<label>角色名称：</label><input type="text" class="name" name="name" size="10" tabindex="1" value="<?php echo ($role_info['name']); ?>" /><br />
			<label>设置权限：</label>
			<!-- <input type="checkbox" name="app_node" class="node" value="1" checked="true" />管理后台（必须拥有） -->
			<?php if(is_array($node_list)): $i = 0; $__LIST__ = $node_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): ++$i;$mod = ($i % 2 )?><dl id="<?php echo ($item['id']); ?>">
				<dt>
					<input type="checkbox" name="module_node" class="node" value="<?php echo ($item['id']); ?>" <?php if(is_array($role_info['Node'])): $j = 0; $__LIST__ = $role_info['Node'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$role_node): ++$j;$mod = ($j % 2 )?><?php if($role_node['id'] == $item['id']): ?>checked="true"<?php endif; ?><?php endforeach; endif; else: echo "" ;endif; ?>
					/><?php if(empty($item['title'])): ?><?php echo ($item['name']); ?><?php else: ?><?php echo ($item['title']); ?><?php endif; ?>
				</dt>
				<dd id="node_<?php echo ($item['id']); ?>">
					<?php if(is_array($item['subNode'])): $j = 0; $__LIST__ = $item['subNode'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$subnode): ++$j;$mod = ($j % 2 )?><input type="checkbox" name="action_node" class="node" value="<?php echo ($subnode['id']); ?>" 
					<?php if(is_array($role_info['Node'][$item['id']]['subNode'])): $k = 0; $__LIST__ = $role_info['Node'][$item['id']]['subNode'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$role_subnode): ++$k;$mod = ($k % 2 )?><?php if($role_subnode['id'] == $subnode['id']): ?>checked="true"<?php endif; ?><?php endforeach; endif; else: echo "" ;endif; ?>
					/><?php if(empty($subnode['title'])): ?><?php echo ($subnode['name']); ?><?php else: ?><?php echo ($subnode['title']); ?><?php endif; ?>&nbsp;&nbsp;<?php endforeach; endif; else: echo "" ;endif; ?>
				</dd>
			</dl><?php endforeach; endif; else: echo "" ;endif; ?>
			<div class="clear"></div>
			<input type="button" value="提交" class="submit" />
		</fieldset>
	</div>
	<script language="JavaScript" type="text/javascript" src="../Public/Js/role_func.js"></script>