<?
define('IN_PHPBB', 1);
$phpbb_root_path = './';
include($phpbb_root_path . 'extension.inc');
include($phpbb_root_path . 'config.'.$phpEx);

if (!defined("PHPBB_INSTALLED"))
{
	die("你没有安装任何PHPBB程序！");
}

if ($dbms != "mysql" && $dbms != "mysql4")
{
	die("本程序仅支持使用MySQL的系统升级！");
}

$conn = @mysql_connect($dbhost,$dbuser,$dbpasswd) or die("数据库服务器或登录密码无效，无法连接数据库，请重新设定config.php");
mysql_select_db($dbname) or die("数据库不存在，请重新设定config.php");

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
<title>cnphpbb升级程序</title>
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
				    <th>cnphpbb升级程序说明</th>
				  </tr>
				  <tr>
				    <td height="24" class="row1"><table width="90%"  border="0" align="center" cellpadding="0" cellspacing="0">
				      <tr>
				        <td>&nbsp;</td>
				      </tr>
				      <tr>
				        <td><span class="gen">本程序目前支持CNphpBB2.0.4MOD、CNphpBB2.0.6娱乐版、CNphpBB2.0.1*MOD、phpBB最新标准版到CNphpBB最新mod版的升级。如果您使用的版本是低于phpBB最新标准版,请先使用官方的升级程序update_to_latest.php升级到最新版之后再使用本程序升级
				                <p>在使用本升级程序前请首先确定您已经成功安装了PHPBB。</p>
				            <p><font color="#FF0000">注意：</font>2.0.1*MOD标准版并不具备2.0.4MOD或2.0.6娱乐版的全部功能，升级之后原论坛的的样式、友情链接和各版面发帖或回复所得积分都将被替换为2.0.1*MOD的默认设置，请用户自行进入管理员控制面板修改。总之，请用户慎重选择，视情况决定是否升级，如果确定要升级请先做好文件和数据库的备份以防止升级失败！</p>
				        </span></td>
				      </tr>
				      <tr>
				        <td>&nbsp;</td>
				      </tr>
				    </table></td>
				  </tr>
				  <tr>
				    <td align="center" class="catBottom">
					  <input class="mainoption" type="submit" name="bt0" value="确定要升级" onClick="location='update_to_2019mod.php?step=1';">	</td>
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
				      <th colspan="2">数据库升级设置</th>
				    </tr>
				    <tr>
				      <td height="24" colspan="2" class="row1"><span class="gen">注意：请检查下面显示的MySQL连接是否正确，如果错误请自行修改config.php</span>。</td>
				    </tr>
				    <tr>
				      <td height="24" align="right" class="row1"><span class="gen">数据服务器：</span></td>
				      <td class="row2"><span class="gen"><?=$dbhost?></span></td>
				    </tr>
				    <tr>
				      <td height="24" align="right" class="row1"><span class="gen">数据库名称：</span></td>
				      <td class="row2"><span class="gen"><?=$dbname?></span></td>
				    </tr>
				    <tr>
				      <td height="24" align="right" class="row1"><span class="gen">数据库登录用户：</span></td>
				      <td class="row2"><span class="gen"><?=$dbuser?></span></td>
				    </tr>
				    <tr>
				      <td height="24" align="right" class="row1"><span class="gen">数据库登录密码：</span></td>
				      <td class="row2"><span class="gen"><?=$dbpasswd?></span></td>
				    </tr>
				    <tr>
				      <td height="24" align="right" class="row1"><span class="gen">数据表前缀：</span></td>
				      <td class="row2"><span class="gen"><?=$table_prefix?></span></td>
				    </tr>
				    <tr>
				      <td height="24" align="right" class="row1"><span class="gen">安装选项：</span></td>
				      <td class="row2">
					  	<select name="setuptype">
						  <option value="0"><span class="gen">由CNphpBB2.0.4mod升级</span></option>
						  <option value="1"><span class="gen">由CNphpBB2.0.6娱乐版升级</span></option>
						  <option value="2"><span class="gen">由CNphpBB2.0.11mod升级</span></option>
						  <option value="3"><span class="gen">由CNphpBB2.0.12mod升级</span></option>
						  <option value="3"><span class="gen">由CNphpBB2.0.13mod升级</span></option>
						  <option value="3"><span class="gen">由CNphpBB2.0.14mod升级</span></option>
						  <option value="4"><span class="gen">由CNphpBB2.0.15mod升级</span></option>
						  <option value="5"><span class="gen">由CNphpBB2.0.16mod升级</span></option>
						  <option value="6"><span class="gen">由CNphpBB2.0.17mod升级</span></option>
						  <option value="7"><span class="gen">由CNphpBB2.0.18mod升级</span></option>
						  <option value="8"><span class="gen">由phpBB2.0.19标准版升级</span></option>
						</select></td>
				    </tr>
				    <tr>
				      <td colspan="2" align="center" class="catBottom"><input class="mainoption" type="submit" name="bt0" value="执行升级程序">
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
				    <th>数据库升级结束</th>
				  </tr>
				  <tr>
				    <td height="24" class="row1"><table width="90%"  border="0" align="center" cellpadding="0" cellspacing="0">
				        <tr>
				          <td>&nbsp;</td>
				        </tr>
				        <tr>
				          <td><span class="gen">
			              <p>数据库升级完毕！请用户自行进行下面的步骤：</p>
				            <p>删除论坛文件夹下的文件。<font color="#FF0000">注意：</font>保留config.php，保留附件文件夹(默认是files文件夹)、头像文件夹及其内部的文件！</p>
				            <p>上传2.0.19mod标准版。<font color="#FF0000">注意：</font>不要上传install和contrib这两个文件夹及其内部的文件，不要上传config.php!</p>
				            <p>打开论坛检查数据库升级是否完成，使用管理员控制面板修改论坛设置</p>
				            <p>最后，不要忘了删除update_to_2019mod.php和20*_to_2019mod.sql</p>
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
