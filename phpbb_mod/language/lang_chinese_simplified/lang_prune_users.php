<?php 
/************************************************************* 
* MOD Title:   Prune users
* MOD Version: 1.4.2
* Translation: Chinses
* Rev date:    03/08/2005
* 
* Translator:  FlyingHail < flyinghail@sohu.com > http://www.cnphpbb.com
* 
**************************************************************/

// add to prune inactive
$lang['X_Days'] = '%d 天';
$lang['X_Weeks'] = '%d 周';
$lang['X_Months'] = '%d 月';
$lang['X_Years'] = '%d 年';

$lang['Prune_no_users']="没有需要清理的用户";
$lang['Prune_users_number']="以下 %d 个用户被删除:";

$lang['Prune_user_list'] = '符合删除条件的用户';
$lang['Prune_on_click'] = '你大概要删除 %d 个用户。 你确定吗？';
$lang['Prune_Action'] = '点击下面的链接执行';
$lang['Prune_users_explain'] = '在这个页面你可以清理会员。 你可以选择下面三个链接中的一个： 删除从未发贴的老会员 、 删除从未登陆过的老会员 、 删除未激活账号的会员。<p/><b>警告:</b> 该功能完成以后无法再取消。';
$lang['Prune_commands'] = array();

// here you can make more entries if needed
$lang['Prune_commands'][0] = '清理从未发贴的用户';
$lang['Prune_explain'][0] = '未发贴的用户, <b>不包括</b> 过去 %d 天的新用户';
$lang['Prune_commands'][1] = '清理无活动用户';
$lang['Prune_explain'][1] = '未曾登陆过的用户, <b>不包括</b> 过去 %d 天的新用户';
$lang['Prune_commands'][2] = '清理未激活的用户';
$lang['Prune_explain'][2] = '未激活的用户, <b>不包括</b> 过去 %d 天的新用户';
$lang['Prune_commands'][3] = '清理长时间未登陆的用户';
$lang['Prune_explain'][3] = '60 天内没有登陆过的用户, <b>不包括</b> 过去 %d 天的新用户';
$lang['Prune_commands'][4] = '清理发贴不活跃的用户';
$lang['Prune_explain'][4] = '注册以后1平均10天发贴不到1贴的用户, <b>不包括</b> 过去 %d 天的新用户'; 

?>
