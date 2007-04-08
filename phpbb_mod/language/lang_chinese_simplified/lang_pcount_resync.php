<?php
/***************************************************************************
 *                            lang_pcount_resync.php [English]
 *                              -------------------
 *     begin                : Fri Sep 06 2002
 *     copyright            : (C) 2002 Adam Alkins
 *     email                : phpbb@rasadam.com
 *	  $Id: lang_pcount_resync.php,v 1.5 2003/07/12 15:48:42 rasadam Exp $: 
 *    
 *
 ****************************************************************************/

/***************************************************************************
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation; either version 2 of the License, or
 *   (at your option) any later version.
 *
 ***************************************************************************/

$lang['Resync_page_title'] = '同步用户发贴数';
$lang['Resync_page_desc_simple'] = '欢迎使用用户发贴数同步功能。您可以点击同步按键同步用户的总贴数重计数他们实际发表的数目。<br /><br />分批模式允许您分步同步贴数，这通常用于大型论坛的同步。分批模式也规定了在同步时进行的更新，因此如果脚本在结束之前终止（内存超过限制或者超时），您可以在输入批次数的位置输入相应的数值重新开始（在最初开始的时候将这个位置留空）。每批同步数定义了在同步每一批时需要操作的数量。如果每批同步数定义为空，则会默认每批数为50。';
$lang['Resync_page_desc_adv'] = '欢迎使用用户发贴数同步功能。您可以同步全部或者一个会员的总发贴数为在选定的版面中的发贴数。 您可以基于您的标准使用同步按键同步用户的总贴数重计数他们实际发表的数目。<br /><br />分批模式允许您分步同步贴数，这通常用于大型论坛的同步。分批模式也规定了在同步时进行的更新，因此如果脚本在结束之前终止（内存超过限制或者超时），您可以在输入批次数的位置输入相应的数值重新开始（在最初开始的时候将这个位置留空）。每批同步数定义了在同步每一批时需要操作的数量。如果每批同步数定义为空，则会默认每批数为50。';

$lang['Resync_batch_mode'] = '分批模式';
$lang['Resync_batch_number'] = '批次数';
$lang['Resync_batch_amount'] = '每批同步数';
$lang['Resync_finished'] = '完成';

$lang['Resync_completed'] = '同步完成成功';

$lang['Resync_question'] = '同步？';

$lang['Resync_check_all'] = '选择同步所有用户：';

$lang['Resync_do'] = '进行同步';

$lang['Resync_redirect'] = '<br /><br />返回 <a href="%s">用户发贴数同步工具</a><br /><br />返回 <a href="%s">管理员控制面板首页</a>.';
$lang['Resync_invalid'] = '错误的设置 - 没有同步任何用户';

?>
