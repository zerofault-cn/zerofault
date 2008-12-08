<html>
<style type="text/css">
<!--
table {
font-size: 14px;
}
.wraper {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	width:160px;
	border:1px solid black;
	padding:20px 10px;
}
-->
</style>
<body bgcolor="#FFFFFF" text="#000000">

<?php
/**
 * subject_list.tpl
 * @copyright bokee.com
 * @version  0.1
 * @author yudunde@bokee.com
 */
/*
require_once('smarttemplate/class.smarttemplate.php');
$tpl = new SmartTemplate('subject_list.html');
$tpl->assign($response['action_error']);
$tpl->assign($response['form']);
$tpl->assign($response['data']);
$tpl->assign('subject',$response['subject']);
$tpl->output();*/
/*ShowTreeMenu($response['menu']);

function ShowTreeMenu($arr)
{
	echo $arr[name];
}
*/

  $i = 0;
  $GLOBALS["ID"] =1; //用来跟踪下拉菜单的ID号 
  function readFromArray($a,$b){
    global $i;

    while( list( $key, $node ) = each( $a ) ) {
      $i++;
      // 打印当前节点
      for( $j = 1; $j < $i; $j++ ) 
      echo "--";
      echo $node['name'];
      echo "　　目录名:" . $node['dir_name'] . "　";
      echo "　　<a href='main.php?do=subject_delete&channel_name=$b&id=$node[id]' onClick=\"javascript:return window.confirm('确定删除？');\">删除</a> <a href='main.php?do=subject_modify&channel_name=$b&id=$node[id]'>修改</a>&nbsp</td>";
      if ( array_key_exists( "childs", $node ) ) {
      echo "　　<a href=main.php?do=subject_add&channel_name=$b&id=$node[id]>添加</a>";	}
	  echo "<br>\n";
      // 检测是否有子节点
      if ( array_key_exists( "childs", $node ) ) {
      	readFromArray( $node["childs"],$b );

      }
      $i--;
      
    }
   
  }
  echo "<p><a href=main.php?do=subject_add&channel_name=" . $response['channel_name'] . "&parent_id=0&sort=1 target=_self>添加新栏目</a> ";
  echo "<a href=main.php?do=block_list&channel_name=" . $response['channel_name'] . "&subject_id=0 target=_self>区块列表</a> ";
  echo "<a href=main.php?do=template_list&channel_name=" . $response['channel_name'] . "&subject_id=0 target=_self>模板列表</a></p>";
  readFromArray( $response['menu'],$response['channel_name']);
 
?>

 </body></html>