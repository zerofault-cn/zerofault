<html>
<body bgcolor="#FFFFFF" text="#000000">
<form action="main.php?do=photo_do_add" name="photo_form" method="post" enctype='multipart/form-data'>
栏目：<select name="select_subject" id="select_subject">
<?php
echo $_obj['options'];
?>

</select>
(选中栏目文章显示时包含子栏目)<br>
文件：<input type='file' name='file'><br>
名称：<input name="name" type="text" size="50" maxlength="100"><br>
链接：<input name="url" type="text" size="50" maxlength="200">

        <input type="hidden" name="channel_name" value="<?php
echo $_obj['channel_name'];
?>
">
        <input type="hidden" name="subject_id" value="<?php
echo $_obj['subject_id'];
?>
">
        <input name="Submit" type="submit" id="Submit" value="保存">
      </form>
</body>
</html>
