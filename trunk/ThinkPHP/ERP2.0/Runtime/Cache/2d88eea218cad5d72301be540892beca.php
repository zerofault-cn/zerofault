<?php if (!defined('THINK_PATH')) exit();?>	<table id="table" border="1" cellpadding="5" cellspacing="0" width="100%" bordercolor="#999999" style="border-collapse:collapse;">
	<tr bgcolor="#ededed">
		<th width="15%">模块</th>
		<th >方法</th>
	</tr>
	
	<?php if(is_array($modules)): $n1 = 0; $__LIST__ = $modules;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$module): ++$n1;$mod = ($n1 % 2 )?><tr>
		<td>
			<span class="c<?php echo ($module['id']); ?>" id="<?php echo ($module['id']); ?>" name="<?php echo ($module['name']); ?>" title="<?php echo ($module['title']); ?>" descr="<?php echo ($module['descr']); ?>" level="2"><?php if(empty($module['title'])): ?><?php echo ($module['name']); ?><?php else: ?><?php echo ($module['title']); ?><?php endif; ?></span>
			<?php if($module['id'] != 0): ?><img class="edit" src="../Public/Images/form_edit.gif" alt="编辑" align="absmiddle"/>
			<?php else: ?>
			<img class="edit" src="../Public/Images/form_add.gif" alt="编辑并登记" align="absmiddle"/><?php endif; ?>
		</td>
		<td>
			<table border="0" width="100%" cellpadding="3" cellspacing="0" frame="void" style="border-collapse: collapse;border-color:#888888;">
			<?php if(is_array($module["action"])): $n2 = 0; $__LIST__ = $module["action"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$action): ++$n2;$mod = ($n2 % 4 )?><?php if(($mod)  ==  "1"): ?><tr><?php endif; ?>
				<td width="25%" class="a_left">
					<span class="c<?php echo ($action['id']); ?>" id="<?php echo ($action['id']); ?>" pid="<?php echo ($module['id']); ?>" name="<?php echo ($action['name']); ?>" title="<?php echo ($action['title']); ?>" descr="<?php echo ($action['descr']); ?>" level="3"><?php if(empty($action['title'])): ?><?php echo ($action['name']); ?><?php else: ?><?php echo ($action['title']); ?><?php endif; ?></span>
					<?php if($action['id'] != 0): ?><img class="edit" src="../Public/Images/form_edit.gif" alt="编辑" align="absmiddle"/>
					<?php else: ?>
					<img class="edit" src="../Public/Images/form_add.gif" alt="编辑并登记" align="absmiddle"/><?php endif; ?>
				</td>
			<?php if(($mod)  ==  "0"): ?></tr><?php endif; ?><?php endforeach; endif; else: echo "" ;endif; ?>
			</table>
		</td>
	</tr><?php endforeach; endif; else: echo "" ;endif; ?>
	<tr>
		<td colspan="3" class="a_left">
			注意：红色标识代表尚未在系统中登记，将无法对它们设置权限！
		</td>
	</tr>
	</table>
	<script language="JavaScript" type="text/javascript" src="../Public/Js/node_func.js"></script>