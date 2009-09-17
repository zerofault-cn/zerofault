<?php if (!defined('THINK_PATH')) exit();?>﻿<table class="quick_menu" cellspacing="0" cellpadding="0" border="0" width="100%">
<tr>
	<td class="quick_menu_left" align="left" style="width: 100%;">
	<?php if(!empty($_SESSION['loginUserName'])): ?><a href="__APP__/Staff/chgpwd"><img src="../Public/Images/user.gif" alt="User" align="absmiddle"/> <?php echo $_SESSION["loginUserName"];?><br />
			<a href="__APP__/Public/logout" target="_iframe">Logout</a><?php endif; ?>
	</td>
	<td class="quick_menu_tabs">
		<table cellspacing="0" cellpadding="0" class="quick_menu_tabs">
		<tr>
			<?php if(is_array($menu)): $i = 0; $__LIST__ = $menu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): ++$i;$mod = ($i % 2 )?><td nowrap="true" align="center" class="quick_menu_tab"><a href="__APP__/<?php echo ($item['name']); ?>?pmenu=<?php echo ($key); ?>"><?php echo ($key); ?></a></td><?php endforeach; endif; else: echo "" ;endif; ?>
		</tr>
		</table>
	</td>
	</tr>
</table>

<?php if(isset($submenu)): ?><table cellspacing="0" cellpadding="0" border="0" width="100%" class="main_menu">
<tr>
	<td class="main_menu">
		<table class="main_menu">
		<tr>
			<?php if(is_array($submenu)): $i = 0; $__LIST__ = $submenu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): ++$i;$mod = ($i % 2 )?><?php if(MODULE_NAME == $item): ?><td class="main_menu_selected"><a href="__APP__/<?php echo ($item); ?>"><?php echo ($key); ?></a></td>
			<?php else: ?>
			<td class="main_menu_unselected"><a href="__APP__/<?php echo ($item); ?>"><?php echo ($key); ?></a></td><?php endif; ?><?php endforeach; endif; else: echo "" ;endif; ?>
		</table>
	</td>
</tr>
</table><?php endif; ?>