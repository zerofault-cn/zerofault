<?PHP
include_once(PATH_Include . '/smarty/'. 'Smarty.class.php');
$smarty = new Smarty;

$smarty->compile_dir = PATH_Compile . $theme;
$smarty->template_dir = PATH_Template . $theme;

$smarty->config_dir = PATH_Config ;
$smarty->left_delimiter = '<!--{';
$smarty->right_delimiter = '}-->';
?>