<html>
	<head>
		<title>添加组文/组图</title>
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
		添加组文/组图
		<br><br>
		<form action="main.php?do=article_group_do_add" method="post" onSubmit="return validator(this)">
		  <br>
		  <table width="500">
		  <tr>
		    <td align="left" height="80">名称：</td>
		    <td><input type="text" name="group_name" size="40"></td>
		  </tr>
		  <tr>
			<td align="left" height="80">URL: </td>
			<td><input type="text" name="url" size="40"> (可不用填写)</td>
		  </tr>
		  <tr>
		  <td align="left" height="80">类别: </td>
		  <td><select name="category" size="1">
		    
				<option value="photo">图片</option>
				<option value="article">文章</option>
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
		</form>
	</body>
</html>