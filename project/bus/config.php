<?php
$dbms = 'mysql4';
$dbhost = 'localhost';
//$dbhost = 'www.yesqu.com';
$dbname = 'haozhanwangcom';
$dbuser = 'haozhanwangcom';
$dbpasswd = '52412963';
//$dbpasswd ='';

$line_table='bus_hz_line';
$site_table='bus_hz_site';
$route_table='bus_hz_route';



include_once($root_path. 'includes/smarty/Smarty.class.php');
$smarty = new Smarty;

$smarty->compile_dir = PATH_Compile . $theme;
$smarty->template_dir = PATH_Template . $theme;


$smarty->config_dir = PATH_Config ;
$smarty->left_delimiter = '<!--{';
$smarty->right_delimiter = '}-->';

?>
