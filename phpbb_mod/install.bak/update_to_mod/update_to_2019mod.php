<?
define('IN_PHPBB', 1);
$phpbb_root_path = './';
include($phpbb_root_path . 'extension.inc');
include($phpbb_root_path . 'config.'.$phpEx);

if (!defined("PHPBB_INSTALLED"))
{
	die("��û�а�װ�κ�PHPBB����");
}

if ($dbms != "mysql" && $dbms != "mysql4")
{
	die("�������֧��ʹ��MySQL��ϵͳ������");
}

$conn = @mysql_connect($dbhost,$dbuser,$dbpasswd) or die("���ݿ���������¼������Ч���޷��������ݿ⣬�������趨config.php");
mysql_select_db($dbname) or die("���ݿⲻ���ڣ��������趨config.php");

if(empty($step)) $step=0;
if (!empty($_GET)) foreach($_GET AS $key => $value){$$key = $value;}
if (!empty($_POST)) foreach($_POST AS $key => $value){$$key = $value;}

if($step==2)
{
	$sqlfiles[0]="204mod_to_2019mod.sql";
	$sqlfiles[1]="206mod_to_2019mod.sql";
	$sqlfiles[2]="2011mod_to_2019mod.sql";
	$sqlfiles[3]="2012-14mod_to_2019mod.sql";
	$sqlfiles[4]="2015mod_to_2019mod.sql";
	$sqlfiles[5]="2016mod_to_2019mod.sql";
	$sqlfiles[6]="2017mod_to_2019mod.sql";
	$sqlfiles[7]="2018mod_to_2019mod.sql";
	$sqlfiles[8]="2019_to_2019mod.sql";
	$sqlfile = $sqlfiles[$setuptype];
	$fp = fopen($sqlfile,"r");
	$query = "";
	while($line = fgets($fp,1024))
	{
		$line = trim($line);
		if(ereg(";$",$line))
		{
			$query.=$line;
			$query = preg_replace('/phpbb_/', $table_prefix, $query);
			mysql_query($query,$conn);
			$query="";
		}
		else if(!ereg("^//",$line))
		{
			$query.=$line;
			$query = preg_replace('/phpbb_/', $table_prefix, $query);
		}
	}
	fclose($fp);
	mysql_close($conn);
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>cnphpbb��������</title>
<link rel="stylesheet" href="templates/subSilver/subSilver.css" type="text/css">
<style type="text/css">
<!--
th			{ background-image: url('templates/subSilver/images/cellpic3.gif') }
td.cat		{ background-image: url('templates/subSilver/images/cellpic1.gif') }
td.rowpic	{ background-image: url('templates/subSilver/images/cellpic2.jpg'); background-repeat: repeat-y }
td.catHead,td.catSides,td.catLeft,td.catRight,td.catBottom { background-image: url('templates/subSilver/images/cellpic1.gif') }

/* Import the fancy styles for IE only (NS4.x doesn't use the @import function) */
@import url("templates/subSilver/formIE.css"); 
//-->
</style>
</head>

<body>
<table width="100%" border="0" cellspacing="0" cellpadding="10" align="center"> 
	<tr>
		<td class="bodyline" width="100%"><table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td><table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td><img src="templates/subSilver/images/logo_phpBB.gif" border="0" alt="Forum Home" vspace="1" /></td>
						<td align="center" width="100%" valign="middle"><span class="maintitle">Update to CNphpBB 2.0.19 MOD </span></td>
					</tr>
				</table></td>
			</tr>
			<tr>
				<td><br /><br /></td>
			</tr>
			<tr>
				<td colspan="2">
				<?
				if($step==0)
				{
				?>
				<table width="100%" align="center" cellpadding="2" cellspacing="1" border="0" class="forumline">
				  <tr>
				    <th>cnphpbb��������˵��</th>
				  </tr>
				  <tr>
				    <td height="24" class="row1"><table width="90%"  border="0" align="center" cellpadding="0" cellspacing="0">
				      <tr>
				        <td>&nbsp;</td>
				      </tr>
				      <tr>
				        <td><span class="gen">������Ŀǰ֧��CNphpBB2.0.4MOD��CNphpBB2.0.6���ְ桢CNphpBB2.0.1*MOD��phpBB���±�׼�浽CNphpBB����mod��������������ʹ�õİ汾�ǵ���phpBB���±�׼��,����ʹ�ùٷ�����������update_to_latest.php���������°�֮����ʹ�ñ���������
				                <p>��ʹ�ñ���������ǰ������ȷ�����Ѿ��ɹ���װ��PHPBB��</p>
				            <p><font color="#FF0000">ע�⣺</font>2.0.1*MOD��׼�沢���߱�2.0.4MOD��2.0.6���ְ��ȫ�����ܣ�����֮��ԭ��̳�ĵ���ʽ���������Ӻ͸����淢����ظ����û��ֶ������滻Ϊ2.0.1*MOD��Ĭ�����ã����û����н������Ա��������޸ġ���֮�����û�����ѡ������������Ƿ����������ȷ��Ҫ�������������ļ������ݿ�ı����Է�ֹ����ʧ�ܣ�</p>
				        </span></td>
				      </tr>
				      <tr>
				        <td>&nbsp;</td>
				      </tr>
				    </table></td>
				  </tr>
				  <tr>
				    <td align="center" class="catBottom">
					  <input class="mainoption" type="submit" name="bt0" value="ȷ��Ҫ����" onClick="location='update_to_2019mod.php?step=1';">	</td>
				  </tr>
				  </form>
				</table>
				<?
				}
				else if($step==1)
				{
				?>
				<table width="100%" align="center" cellpadding="2" cellspacing="1" border="0" class="forumline">
				  <form action="update_to_2019mod.php" name="form" method="post">
				    <input type="hidden" name="step" value="2">
				    <tr>
				      <th colspan="2">���ݿ���������</th>
				    </tr>
				    <tr>
				      <td height="24" colspan="2" class="row1"><span class="gen">ע�⣺����������ʾ��MySQL�����Ƿ���ȷ����������������޸�config.php</span>��</td>
				    </tr>
				    <tr>
				      <td height="24" align="right" class="row1"><span class="gen">���ݷ�������</span></td>
				      <td class="row2"><span class="gen"><?=$dbhost?></span></td>
				    </tr>
				    <tr>
				      <td height="24" align="right" class="row1"><span class="gen">���ݿ����ƣ�</span></td>
				      <td class="row2"><span class="gen"><?=$dbname?></span></td>
				    </tr>
				    <tr>
				      <td height="24" align="right" class="row1"><span class="gen">���ݿ��¼�û���</span></td>
				      <td class="row2"><span class="gen"><?=$dbuser?></span></td>
				    </tr>
				    <tr>
				      <td height="24" align="right" class="row1"><span class="gen">���ݿ��¼���룺</span></td>
				      <td class="row2"><span class="gen"><?=$dbpasswd?></span></td>
				    </tr>
				    <tr>
				      <td height="24" align="right" class="row1"><span class="gen">���ݱ�ǰ׺��</span></td>
				      <td class="row2"><span class="gen"><?=$table_prefix?></span></td>
				    </tr>
				    <tr>
				      <td height="24" align="right" class="row1"><span class="gen">��װѡ�</span></td>
				      <td class="row2">
					  	<select name="setuptype">
						  <option value="0"><span class="gen">��CNphpBB2.0.4mod����</span></option>
						  <option value="1"><span class="gen">��CNphpBB2.0.6���ְ�����</span></option>
						  <option value="2"><span class="gen">��CNphpBB2.0.11mod����</span></option>
						  <option value="3"><span class="gen">��CNphpBB2.0.12mod����</span></option>
						  <option value="3"><span class="gen">��CNphpBB2.0.13mod����</span></option>
						  <option value="3"><span class="gen">��CNphpBB2.0.14mod����</span></option>
						  <option value="4"><span class="gen">��CNphpBB2.0.15mod����</span></option>
						  <option value="5"><span class="gen">��CNphpBB2.0.16mod����</span></option>
						  <option value="6"><span class="gen">��CNphpBB2.0.17mod����</span></option>
						  <option value="7"><span class="gen">��CNphpBB2.0.18mod����</span></option>
						  <option value="8"><span class="gen">��phpBB2.0.19��׼������</span></option>
						</select></td>
				    </tr>
				    <tr>
				      <td colspan="2" align="center" class="catBottom"><input class="mainoption" type="submit" name="bt0" value="ִ����������">
				      </td>
				    </tr>
				  </form>
				</table>
				<?
				}
				else if($step==2)
				{
				?>
				<table width="100%" align="center" cellpadding="2" cellspacing="1" border="0" class="forumline">
				  <tr>
				    <th>���ݿ���������</th>
				  </tr>
				  <tr>
				    <td height="24" class="row1"><table width="90%"  border="0" align="center" cellpadding="0" cellspacing="0">
				        <tr>
				          <td>&nbsp;</td>
				        </tr>
				        <tr>
				          <td><span class="gen">
			              <p>���ݿ�������ϣ����û����н�������Ĳ��裺</p>
				            <p>ɾ����̳�ļ����µ��ļ���<font color="#FF0000">ע�⣺</font>����config.php�����������ļ���(Ĭ����files�ļ���)��ͷ���ļ��м����ڲ����ļ���</p>
				            <p>�ϴ�2.0.19mod��׼�档<font color="#FF0000">ע�⣺</font>��Ҫ�ϴ�install��contrib�������ļ��м����ڲ����ļ�����Ҫ�ϴ�config.php!</p>
				            <p>����̳������ݿ������Ƿ���ɣ�ʹ�ù���Ա��������޸���̳����</p>
				            <p>��󣬲�Ҫ����ɾ��update_to_2019mod.php��20*_to_2019mod.sql</p>
				          </span></td>
				        </tr>
				        <tr>
				          <td>&nbsp;</td>
				        </tr>
				    </table></td>
				  </tr>
				  <tr>
				    <td align="center" class="catBottom">&nbsp;    </td>
				  </tr>
				</table>
				<?
				}
				?>				
				</td>
			</tr>
			<tr>
				<td><br /><br /></td>
			</tr>
			<tr>
				<td width="100%"><table width="100%" cellpadding="2" cellspacing="1" border="0" class="forumline">
				</table></td>
			</tr>
		</table></td>
	</tr>
</table>

</body>
</html>
