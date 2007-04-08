<?
// db debug
$time_start = getmicrotime();
@mysql_connect("localhost","root","");
//@mysql_select_db("cms");
//@mysql("create database testdb");
@mysql_select_db("testdb");

/*
// 测试数据，请自行导入
CREATE DATABASE testdb;

CREATE TABLE `testtable` (
  `threadid` int(10) unsigned NOT NULL auto_increment,
  `title` varchar(250) NOT NULL default '',
  `lastpost` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`threadid`)
) TYPE=MyISAM AUTO_INCREMENT=5142 ;

#
# 导出表中的数据 `testtable`
#

INSERT INTO `testtable` VALUES (1, '用户手册', 1056675353);
INSERT INTO `testtable` VALUES (2, '斑竹守则', 1056208568);
INSERT INTO `testtable` VALUES (3, 'Linux下构架邮件系统', 1056703118);
INSERT INTO `testtable` VALUES (4, '世界七大奇迹选举', 1029819163);
INSERT INTO `testtable` VALUES (5, '真的是寒冬耶～～～～', 1030512351);
INSERT INTO `testtable` VALUES (7, '[文章] PHP本地调试环境简易安装配置', 1032175589);
INSERT INTO `testtable` VALUES (8, 'PHP还有希望么？', 1050675680);
INSERT INTO `testtable` VALUES (10, '[问题] Oracle导入数据的权限问题？', 1032772383);
INSERT INTO `testtable` VALUES (17, 'vBulletin 2.2.9版本发布了', 1040229341);
INSERT INTO `testtable` VALUES (11, '[文章] Web服务器解决方案(一)', 1036405968);
INSERT INTO `testtable` VALUES (12, 'Tomcat启动不了？', 1036662305);
INSERT INTO `testtable` VALUES (13, '程序员不得不看的好帖（转）', 1085021674);
INSERT INTO `testtable` VALUES (14, '本站的FTP站点开通，欢迎大家使用！', 1084408733);
INSERT INTO `testtable` VALUES (15, '现在如何登陆阿?', 1037956765);
INSERT INTO `testtable` VALUES (16, '[分享] 可以和你做一个联接么', 1037785003);
INSERT INTO `testtable` VALUES (18, 'FTP目录在调整中...', 1037869139);
INSERT INTO `testtable` VALUES (19, '能开放ftp吗?', 1039633468);
INSERT INTO `testtable` VALUES (20, 'FTP综合论坛的访问问题解决了', 1037949721);
INSERT INTO `testtable` VALUES (21, '请问斑竹那个*.gho文件用什么程序打开? 谢谢!!!', 1082483109);
INSERT INTO `testtable` VALUES (22, '有没有找不到的软件呢？', 1039633312);
INSERT INTO `testtable` VALUES (23, '互联网论坛：中国互联网 盈利别得意', 1039633657);
INSERT INTO `testtable` VALUES (24, '最厉害的图片！', 1039633215);
INSERT INTO `testtable` VALUES (25, '论坛银行', 1060911818);
INSERT INTO `testtable` VALUES (36, '人生到底为了什么呢？', 1039764753);
INSERT INTO `testtable` VALUES (35, '关于五个创业者的五个细节', 1039748528);
INSERT INTO `testtable` VALUES (28, '修改论坛显示发表信息的修改', 1039628337);
INSERT INTO `testtable` VALUES (29, 'Oracle与DB2比较', 1039633786);
INSERT INTO `testtable` VALUES (31, 'PHP 4.3.0最后一个预发行版本', 1040815970);
INSERT INTO `testtable` VALUES (40, 'FTP站点开通音乐频道', 1040399193);
INSERT INTO `testtable` VALUES (37, '平均拥有21个密码 IT用户的密码泛滥成灾 [转贴]', 1039772963);
INSERT INTO `testtable` VALUES (38, '我要软件啊', 1042300012);
INSERT INTO `testtable` VALUES (39, '这里的速度相对别的FTP来说（对我而言）是最快的了', 1039947371);
INSERT INTO `testtable` VALUES (41, '[文章] Web服务器解决方案(一)', 1040027122);
INSERT INTO `testtable` VALUES (42, '那位大哥哥原帮忙？', 1040229203);
INSERT INTO `testtable` VALUES (43, '老大请进 有问题求教', 1040399120);
INSERT INTO `testtable` VALUES (44, '老大 怎么回事', 1040228529);
INSERT INTO `testtable` VALUES (45, 'Oracle中DELETE时候提示出错：ORA-02292', 1040399794);
INSERT INTO `testtable` VALUES (46, '如何连同email地址也复制过去?', 1040399557);
INSERT INTO `testtable` VALUES (47, '星矢冥王篇和字幕', 1044628632);
INSERT INTO `testtable` VALUES (48, '无间道主题曲和一经典', 1040724634);
INSERT INTO `testtable` VALUES (49, '要霸王别姬吗', 1040526751);
INSERT INTO `testtable` VALUES (50, '双城记', 1040646014);
INSERT INTO `testtable` VALUES (51, '第四集有了 马上放上去', 1040566962);
INSERT INTO `testtable` VALUES (52, '这个地方好象不合适偶来', 1046516491);
INSERT INTO `testtable` VALUES (53, 'PHP4中文教程', 1040568390);
INSERT INTO `testtable` VALUES (54, 'FTP有问题了吗', 1040724674);
INSERT INTO `testtable` VALUES (55, '奇怪，怎么就两个人呢？', 1040996101);
INSERT INTO `testtable` VALUES (56, '有没有PHP/GTK的详细教程啊？？', 1040700746);
INSERT INTO `testtable` VALUES (58, '论坛如何调整', 1042116789);
INSERT INTO `testtable` VALUES (57, '哪儿有PHPCompiler下载啊？', 1040713790);
INSERT INTO `testtable` VALUES (59, 'MySQL错误(errno: 140)错误的解决', 1040983562);
INSERT INTO `testtable` VALUES (60, '加油？灌水？', 1042198274);
INSERT INTO `testtable` VALUES (61, 'PHP 4.3.0 正式发行了', 1041107823);
INSERT INTO `testtable` VALUES (62, '伯恩的身份 强烈推荐 下面这篇介绍是转载', 1042300019);
INSERT INTO `testtable` VALUES (63, '老大 有红磨房', 1042944938);
INSERT INTO `testtable` VALUES (64, 'haha', 1042300076);
INSERT INTO `testtable` VALUES (65, '老大 又在调整吗', 1041672910);
INSERT INTO `testtable` VALUES (66, '学习PHP', 1042560221);
INSERT INTO `testtable` VALUES (67, 'php+oracle 中文显示不正常', 1052969974);
INSERT INTO `testtable` VALUES (68, '老大 怎么了', 1042301133);
INSERT INTO `testtable` VALUES (69, '倒 不知不觉变斑竹拉', 1042300340);
INSERT INTO `testtable` VALUES (72, 'PHP网站该往何处去？', 1045971230);
INSERT INTO `testtable` VALUES (70, '伯恩的身份 老大删了吗', 1042301209);
INSERT INTO `testtable` VALUES (71, '美国电影协会评选出的美国历史上的最伟大的100部电影（转）', 1043059704);
INSERT INTO `testtable` VALUES (73, 'THE TWO TOWERS', 1042715292);
INSERT INTO `testtable` VALUES (75, '[重要] 目的是方便PHP爱好者', 1043287064);
INSERT INTO `testtable` VALUES (76, '好文章 大家来看看 （转）', 1042649914);
INSERT INTO `testtable` VALUES (77, '忠奸人', 1042945061);
INSERT INTO `testtable` VALUES (78, '电影点播', 1079154880);
INSERT INTO `testtable` VALUES (79, '2001-2002日本动漫排名', 1052491517);
INSERT INTO `testtable` VALUES (80, '关于论坛改版得通知', 1048655501);
INSERT INTO `testtable` VALUES (81, '[转贴] 我的购盘经验', 1043226808);
INSERT INTO `testtable` VALUES (82, '&lt;hero&gt;已上传完毕', 1043246593);
INSERT INTO `testtable` VALUES (83, '最新电影 BLOOD WORK', 1043246292);
INSERT INTO `testtable` VALUES (84, '感谢djzhi', 1043923465);
INSERT INTO `testtable` VALUES (85, 'Blood Work 上传完', 1043582674);
INSERT INTO `testtable` VALUES (86, '[求助]PHP安装', 1043685944);
INSERT INTO `testtable` VALUES (87, '[转贴] 我的一个朋友与我谈到当前中国人的生活方式', 1043678405);
INSERT INTO `testtable` VALUES (88, '现在服务器陷入非常缓慢的状态', 1043686177);
INSERT INTO `testtable` VALUES (89, '提请新注册用户注意！', 1051885362);
INSERT INTO `testtable` VALUES (91, '能上传了吗', 1044886700);
INSERT INTO `testtable` VALUES (90, '请问：我用$_session[var]去获得session中的变量，有时可以有时不行？', 1078180091);
INSERT INTO `testtable` VALUES (92, '[求助]', 1051454294);
INSERT INTO `testtable` VALUES (93, '祝大家新春愉快', 1044707042);
INSERT INTO `testtable` VALUES (94, '紧急求助', 1044271917);
INSERT INTO `testtable` VALUES (95, '[转贴] 面试工作比找“女朋友”要烦啊！', 1043935699);
INSERT INTO `testtable` VALUES (96, '再次求助', 1044334208);
INSERT INTO `testtable` VALUES (97, '菜鸟紧急求助!', 1044283078);
INSERT INTO `testtable` VALUES (98, '超级菜鸟求助！！！！！！！！！！！', 1044464729);
INSERT INTO `testtable` VALUES (99, '进一步求助。', 1044462787);
INSERT INTO `testtable` VALUES (100, '如何以模块化的方式在Apache下安装PHP', 1078811867);

*/


include("./PageItem.php");
$pi = new PageItem("select * from testtable");

echo "<html><head>\n";
echo "<head><meta http-equiv='content-type' content='text/html;charset=gb2312'>\n<title>类使用示例--Boban@21php.com</title></head>";
echo "<body>";
echo "<p align=center style='font-size:9pt'>PHP服务器系统：".PHP_OS."<br>";
echo "<br<br>";
$records = $pi->getrecord();
if(is_array($records))
{
	while(list($key,$val)=each($records))
	{
		echo $val['threadid'].":".$val['title']."(".date("Y-m-d",$val['lastpost']).")<br>\n";;
	}
}
echo "<br<br>";
$pi->myPageItem();

//$charset = mysql_client_encoding($auth->bb_db_conn);
//printf ("current character set is %s\n", $charset);

?>

<?
echo "</body></html>";
$time_end = getmicrotime();
printf("<br>{程序执行时间: %0.3f 秒}</p>\n",$time_end - $time_start);
function getmicrotime()
{ 
	list($usec, $sec) = explode(" ",microtime()); 
	return ((float)$usec + (float)$sec); 
} 
?>