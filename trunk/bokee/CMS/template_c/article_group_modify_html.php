<html>
	<head>
		<title>修改组文/组图</title>
	<script language="javascript">
		function validator(a)
		{
			if( ""==a.group_name.value )
			{
				alert("名称不能为空!");
				a.group_name.focus();
				return(false);
			}
			return(true);
		}
	</script>
	</head>
	<body>
		<br><br>
		<center>
		修改组文/组图
		<br><br>
		<form action="main.php?do=article_group_do_modify" method="post" onSubmit="return validator(this)">
		  <br>
		  <table width="500">
		  <tr>
		    <td align="left" height="80">名称：</td>
		    <td><input type="text" name="group_name" size="40" value="<?php
echo $_obj['group_name'];
?>
"></td>
		  </tr>
		  <tr>
			<td align="left" height="80">URL: </td>
			<td><input type="text" name="url" size="40" value="<?php
echo $_obj['url'];
?>
"> (可不用填写)</td>
		  </tr>
		  <tr>
		  <td align="left" height="80">类别: </td>
		  <td><select name="category" size="1">
		    
				<option value="photo" <?php
echo $_obj['photo_selected'];
?>
>图片</option>
				<option value="article" <?php
echo $_obj['article_selected'];
?>
>文章</option>
			   </select>
		   </td>
		  </tr>
		  <tr>
		   <td colspan="2" align="center">
			   <input name="submit" type="submit" value="提交">
			</td>
		  </tr>
		  </table>
		  <input name="channel_name" type="hidden" value="<?php
echo $_obj['channel_name'];
?>
">
		  <input name="subject_id" type="hidden" value="<?php
echo $_obj['subject_id'];
?>
">
		  <input name="id" type="hidden" value="<?php
echo $_obj['id'];
?>
">
		</form>
		<table width="100%" cellspacing="2" bgcolor="#CCCCCC">
<tr bgcolor="#FFFFFF">
<td>文章ID</td>
<td>文章标题</td>
<td>发表时间</td>
<td>操作</td>
</tr>
<?php
if (!empty($_obj['articles'])){
if (!is_array($_obj['articles']))
$_obj['articles']=array(array('articles'=>$_obj['articles']));
$_tmp_arr_keys=array_keys($_obj['articles']);
if ($_tmp_arr_keys[0]!='0')
$_obj['articles']=array(0=>$_obj['articles']);
$_stack[$_stack_cnt++]=$_obj;
foreach ($_obj['articles'] as $rowcnt=>$articles) {
$articles['ROWCNT']=$rowcnt;
$articles['ALTROW']=$rowcnt%2;
$articles['ROWBIT']=$rowcnt%2;
$_obj=&$articles;
?>
<tr bgcolor="<?php
echo $_obj['bgcolor'];
?>
">
<td><?php
echo $_obj['id'];
?>
</td>
<td><a href="<?php
echo $_obj['remote_url'];
?>
" target="_blank"><?php
echo $_obj['title'];
?>
</a></td>
<td><?php
echo $_obj['create_time'];
?>
</td>
<td><a href="main.php?do=article_group_remove&id=<?php
echo $_obj['id'];
?>
&channel_name=<?php
echo $_obj['channel_name'];
?>
&subject_id=<?php
echo $_obj['subject_id'];
?>
&group_id=<?php
echo $_obj['group_id'];
?>
" onClick="javascript:return window.confirm('确定从组图中移除？');">从组图中移除</a> <a href="main.php?do=article_delete&id=<?php
echo $_obj['id'];
?>
&channel_name=<?php
echo $_obj['channel_name'];
?>
&subject_id=<?php
echo $_obj['subject_id'];
?>
" onClick="javascript:return window.confirm('确定删除？');">删除</a> <a href="main.php?do=article_modify&id=<?php
echo $_obj['id'];
?>
&channel_name=<?php
echo $_obj['channel_name'];
?>
&subject_id=<?php
echo $_obj['subject_id'];
?>
">修改</a></td>
</tr>
<?php
}
$_obj=$_stack[--$_stack_cnt];}
?>
</table>
	</body>
</html>