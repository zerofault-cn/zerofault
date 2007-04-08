<style>
table,td
{
	BORDER-RIGHT: #eeeeee 1px solid;
    BORDER-TOP: #dddddd 1px solid;
    BORDER-LEFT: #dddddd 1px solid;
    BORDER-BOTTOM: #eeeeee 1px solid;
}
</style>
<?
include_once "../include/mysql_connect.php";
$sql00="select count(*) from singer_info";
$singer_count=mysql_result(mysql_query($sql00),0,0);
if(!isset($type_id) || ''==$type_id)
{
	$type_id=0;
}
$type_name_arr[]='无法分类';
$type_name_arr[]='双人组合';
$type_name_arr[]='女生独唱';
$type_name_arr[]='男生独唱';
$type_name_arr[]='多人组合';

echo "<a href=?type_id=0>无法分类</a> <a href=?type_id=1>双人组合</td> <a href=?type_id=2>女生独唱</a> <a href=?type_id=3>男生独唱</a> <a href=?type_id=4>多人组合</a><br>\r\n"; 
echo "<br>当前列表:";
echo $type_name_arr[$type_id];
echo "<br>";
$sql1="select singer_id,singer_name from singer_info where type_chorus_id=".$type_id." order by singer_name_fc";
$result1=mysql_query($sql1);
echo "<table cellspacing=0 cellpadding=0 border=0>\r\n";
echo "<tr>\r\n\t<td align=center bgcolor=#d9e8f7>歌手名</td>\r\n\t<td align=center bgcolor=#e6f7d9>专辑名</td>\r\n\t<td align=center bgcolor=#ffffd9>歌曲名</td>\r\n</tr>\r\n";
$i=0;
while($r1=mysql_fetch_array($result1))
{
	$i++;
	$singer_id=$r1[0];
	$singer_name=$r1[1];
	$type_name=$r1[2];
	$sql20="select count(*) from song_info where singer_id='".$singer_id."'";
	$singer_song_count=mysql_result(mysql_query($sql20),0,0);
	echo "<tr>\r\n";
	echo "\t<td rowspan=".$singer_song_count." bbgcolor=#d9e8f7 valign=top>".$i.".".$singer_name."</td>\r\n";
	$sql2="select binary album_name from song_info where singer_id='".$singer_id."' group by binary album_name order by id desc";
	$result2=mysql_query($sql2);
	$album_row=0;
	$j=0;
	while($r2=mysql_fetch_array($result2))
	{
		$j++;
		$album_name=$r2[0];
		$sql30="select count(*) from song_info where singer_id='".$singer_id."' and binary album_name='".$album_name."'";
		$album_song_count=mysql_result(mysql_query($sql30),0,0);
		if($album_row>0)
		{
			echo "<tr>\r\n";
		}
		echo "\t<td rowspan=".$album_song_count." bbgcolor=#e6f7d9 valign=top>".$j.".".$album_name."</td>\r\n";
		$album_row++;
		$sql3="select song_name from song_info where singer_id='".$singer_id."' and album_name='".$album_name."' order by id desc";
		$result3=mysql_query($sql3);
		$song_row=0;
		$k=0;
		while($r3=mysql_fetch_array($result3))
		{
			$k++;
			$song_name=$r3['song_name'];
			if($song_row>0)
			{
				echo "<tr>\r\n";
			}
			echo "\t<td bbgcolor=#ffffd9>".$k.".".$song_name."</td>\r\n</tr>\r\n";
			$song_row++;

		}
	}
	if($singer_song_count==0)
	{
		echo "\t<td bgcolor=#eeeeee>无专辑</td>\r\n\t<td bgcolor=#eeeeee>无歌曲</td>\r\n</tr>\r\n";
	}
}
echo "</table>";
?>