<?
// db debug
$time_start = getmicrotime();
@mysql_connect("localhost","root","");
//@mysql_select_db("cms");
//@mysql("create database testdb");
@mysql_select_db("testdb");

/*
// �������ݣ������е���
CREATE DATABASE testdb;

CREATE TABLE `testtable` (
  `threadid` int(10) unsigned NOT NULL auto_increment,
  `title` varchar(250) NOT NULL default '',
  `lastpost` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`threadid`)
) TYPE=MyISAM AUTO_INCREMENT=5142 ;

#
# �������е����� `testtable`
#

INSERT INTO `testtable` VALUES (1, '�û��ֲ�', 1056675353);
INSERT INTO `testtable` VALUES (2, '��������', 1056208568);
INSERT INTO `testtable` VALUES (3, 'Linux�¹����ʼ�ϵͳ', 1056703118);
INSERT INTO `testtable` VALUES (4, '�����ߴ��漣ѡ��', 1029819163);
INSERT INTO `testtable` VALUES (5, '����Ǻ���Ү��������', 1030512351);
INSERT INTO `testtable` VALUES (7, '[����] PHP���ص��Ի������װ�װ����', 1032175589);
INSERT INTO `testtable` VALUES (8, 'PHP����ϣ��ô��', 1050675680);
INSERT INTO `testtable` VALUES (10, '[����] Oracle�������ݵ�Ȩ�����⣿', 1032772383);
INSERT INTO `testtable` VALUES (17, 'vBulletin 2.2.9�汾������', 1040229341);
INSERT INTO `testtable` VALUES (11, '[����] Web�������������(һ)', 1036405968);
INSERT INTO `testtable` VALUES (12, 'Tomcat�������ˣ�', 1036662305);
INSERT INTO `testtable` VALUES (13, '����Ա���ò����ĺ�����ת��', 1085021674);
INSERT INTO `testtable` VALUES (14, '��վ��FTPվ�㿪ͨ����ӭ���ʹ�ã�', 1084408733);
INSERT INTO `testtable` VALUES (15, '������ε�½��?', 1037956765);
INSERT INTO `testtable` VALUES (16, '[����] ���Ժ�����һ������ô', 1037785003);
INSERT INTO `testtable` VALUES (18, 'FTPĿ¼�ڵ�����...', 1037869139);
INSERT INTO `testtable` VALUES (19, '�ܿ���ftp��?', 1039633468);
INSERT INTO `testtable` VALUES (20, 'FTP�ۺ���̳�ķ�����������', 1037949721);
INSERT INTO `testtable` VALUES (21, '���ʰ����Ǹ�*.gho�ļ���ʲô�����? лл!!!', 1082483109);
INSERT INTO `testtable` VALUES (22, '��û���Ҳ���������أ�', 1039633312);
INSERT INTO `testtable` VALUES (23, '��������̳���й������� ӯ�������', 1039633657);
INSERT INTO `testtable` VALUES (24, '��������ͼƬ��', 1039633215);
INSERT INTO `testtable` VALUES (25, '��̳����', 1060911818);
INSERT INTO `testtable` VALUES (36, '��������Ϊ��ʲô�أ�', 1039764753);
INSERT INTO `testtable` VALUES (35, '���������ҵ�ߵ����ϸ��', 1039748528);
INSERT INTO `testtable` VALUES (28, '�޸���̳��ʾ������Ϣ���޸�', 1039628337);
INSERT INTO `testtable` VALUES (29, 'Oracle��DB2�Ƚ�', 1039633786);
INSERT INTO `testtable` VALUES (31, 'PHP 4.3.0���һ��Ԥ���а汾', 1040815970);
INSERT INTO `testtable` VALUES (40, 'FTPվ�㿪ͨ����Ƶ��', 1040399193);
INSERT INTO `testtable` VALUES (37, 'ƽ��ӵ��21������ IT�û������뷺�ĳ��� [ת��]', 1039772963);
INSERT INTO `testtable` VALUES (38, '��Ҫ�����', 1042300012);
INSERT INTO `testtable` VALUES (39, '������ٶ���Ա��FTP��˵�����Ҷ��ԣ���������', 1039947371);
INSERT INTO `testtable` VALUES (41, '[����] Web�������������(һ)', 1040027122);
INSERT INTO `testtable` VALUES (42, '��λ����ԭ��æ��', 1040229203);
INSERT INTO `testtable` VALUES (43, '�ϴ���� ���������', 1040399120);
INSERT INTO `testtable` VALUES (44, '�ϴ� ��ô����', 1040228529);
INSERT INTO `testtable` VALUES (45, 'Oracle��DELETEʱ����ʾ����ORA-02292', 1040399794);
INSERT INTO `testtable` VALUES (46, '�����ͬemail��ַҲ���ƹ�ȥ?', 1040399557);
INSERT INTO `testtable` VALUES (47, '��ʸڤ��ƪ����Ļ', 1044628632);
INSERT INTO `testtable` VALUES (48, '�޼����������һ����', 1040724634);
INSERT INTO `testtable` VALUES (49, 'Ҫ��������', 1040526751);
INSERT INTO `testtable` VALUES (50, '˫�Ǽ�', 1040646014);
INSERT INTO `testtable` VALUES (51, '���ļ����� ���Ϸ���ȥ', 1040566962);
INSERT INTO `testtable` VALUES (52, '����ط����󲻺���ż��', 1046516491);
INSERT INTO `testtable` VALUES (53, 'PHP4���Ľ̳�', 1040568390);
INSERT INTO `testtable` VALUES (54, 'FTP����������', 1040724674);
INSERT INTO `testtable` VALUES (55, '��֣���ô���������أ�', 1040996101);
INSERT INTO `testtable` VALUES (56, '��û��PHP/GTK����ϸ�̳̰�����', 1040700746);
INSERT INTO `testtable` VALUES (58, '��̳��ε���', 1042116789);
INSERT INTO `testtable` VALUES (57, '�Ķ���PHPCompiler���ذ���', 1040713790);
INSERT INTO `testtable` VALUES (59, 'MySQL����(errno: 140)����Ľ��', 1040983562);
INSERT INTO `testtable` VALUES (60, '���ͣ���ˮ��', 1042198274);
INSERT INTO `testtable` VALUES (61, 'PHP 4.3.0 ��ʽ������', 1041107823);
INSERT INTO `testtable` VALUES (62, '��������� ǿ���Ƽ� ������ƪ������ת��', 1042300019);
INSERT INTO `testtable` VALUES (63, '�ϴ� �к�ĥ��', 1042944938);
INSERT INTO `testtable` VALUES (64, 'haha', 1042300076);
INSERT INTO `testtable` VALUES (65, '�ϴ� ���ڵ�����', 1041672910);
INSERT INTO `testtable` VALUES (66, 'ѧϰPHP', 1042560221);
INSERT INTO `testtable` VALUES (67, 'php+oracle ������ʾ������', 1052969974);
INSERT INTO `testtable` VALUES (68, '�ϴ� ��ô��', 1042301133);
INSERT INTO `testtable` VALUES (69, '�� ��֪�����������', 1042300340);
INSERT INTO `testtable` VALUES (72, 'PHP��վ�����δ�ȥ��', 1045971230);
INSERT INTO `testtable` VALUES (70, '��������� �ϴ�ɾ����', 1042301209);
INSERT INTO `testtable` VALUES (71, '������ӰЭ����ѡ����������ʷ�ϵ���ΰ���100����Ӱ��ת��', 1043059704);
INSERT INTO `testtable` VALUES (73, 'THE TWO TOWERS', 1042715292);
INSERT INTO `testtable` VALUES (75, '[��Ҫ] Ŀ���Ƿ���PHP������', 1043287064);
INSERT INTO `testtable` VALUES (76, '������ ��������� ��ת��', 1042649914);
INSERT INTO `testtable` VALUES (77, '�Ҽ���', 1042945061);
INSERT INTO `testtable` VALUES (78, '��Ӱ�㲥', 1079154880);
INSERT INTO `testtable` VALUES (79, '2001-2002�ձ���������', 1052491517);
INSERT INTO `testtable` VALUES (80, '������̳�İ��֪ͨ', 1048655501);
INSERT INTO `testtable` VALUES (81, '[ת��] �ҵĹ��̾���', 1043226808);
INSERT INTO `testtable` VALUES (82, '&lt;hero&gt;���ϴ����', 1043246593);
INSERT INTO `testtable` VALUES (83, '���µ�Ӱ BLOOD WORK', 1043246292);
INSERT INTO `testtable` VALUES (84, '��лdjzhi', 1043923465);
INSERT INTO `testtable` VALUES (85, 'Blood Work �ϴ���', 1043582674);
INSERT INTO `testtable` VALUES (86, '[����]PHP��װ', 1043685944);
INSERT INTO `testtable` VALUES (87, '[ת��] �ҵ�һ����������̸����ǰ�й��˵����ʽ', 1043678405);
INSERT INTO `testtable` VALUES (88, '���ڷ���������ǳ�������״̬', 1043686177);
INSERT INTO `testtable` VALUES (89, '������ע���û�ע�⣡', 1051885362);
INSERT INTO `testtable` VALUES (91, '���ϴ�����', 1044886700);
INSERT INTO `testtable` VALUES (90, '���ʣ�����$_session[var]ȥ���session�еı�������ʱ������ʱ���У�', 1078180091);
INSERT INTO `testtable` VALUES (92, '[����]', 1051454294);
INSERT INTO `testtable` VALUES (93, 'ף����´����', 1044707042);
INSERT INTO `testtable` VALUES (94, '��������', 1044271917);
INSERT INTO `testtable` VALUES (95, '[ת��] ���Թ������ҡ�Ů���ѡ�Ҫ������', 1043935699);
INSERT INTO `testtable` VALUES (96, '�ٴ�����', 1044334208);
INSERT INTO `testtable` VALUES (97, '�����������!', 1044283078);
INSERT INTO `testtable` VALUES (98, '����������������������������������', 1044464729);
INSERT INTO `testtable` VALUES (99, '��һ��������', 1044462787);
INSERT INTO `testtable` VALUES (100, '�����ģ�黯�ķ�ʽ��Apache�°�װPHP', 1078811867);

*/


include("./PageItem.php");
$pi = new PageItem("select * from testtable");

echo "<html><head>\n";
echo "<head><meta http-equiv='content-type' content='text/html;charset=gb2312'>\n<title>��ʹ��ʾ��--Boban@21php.com</title></head>";
echo "<body>";
echo "<p align=center style='font-size:9pt'>PHP������ϵͳ��".PHP_OS."<br>";
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
printf("<br>{����ִ��ʱ��: %0.3f ��}</p>\n",$time_end - $time_start);
function getmicrotime()
{ 
	list($usec, $sec) = explode(" ",microtime()); 
	return ((float)$usec + (float)$sec); 
} 
?>