<html>
  <head>
  	<title>区块名称修改</title>
  	<script language="javascript">
	
	function Validator( a )
	{
		if( "" == a.slash_name.value )
		{
			alert( "名称能为空!" );
			a.slash_name.focus();
			return( false );
		}
		else
			return( true );
	}
	
  	</script>
  </head>
  <body>
  	<br>
  	<center>
  	<form action="main.php?do=slash_name_do_modify" method="post" name="slash_name_do_modify" onSubmit="return Validator(this)">
  		<input name="slash_name" type="text" value="<?php
echo $_obj['slash_name'];
?>
"> <br>
  		<input name="channel_name" type="hidden" value="<?php
echo $_obj['channel_name'];
?>
"> <br>
  		<input name="slash_id" type="hidden" value="<?php
echo $_obj['slash_id'];
?>
"> <br>
		<input name="submit" type="submit" value="修改">
  	</form>
  	</center>
  </body>
</html>
