<?php
function checkvar($input)
{
	echo "<pre>\n";
	print_r($input);
	echo "\n</pre>\n<hr>\n";
}

function get_browser_version()
{
	$reslut="Unknow";
	$browser_version = array("MSIE","Firefox","Opera","Safari","Netscape");
	$i = 0;
	while($i < count($browser_version))
	{
		if(strstr($_SERVER["HTTP_USER_AGENT"],$browser_version[$i])) {
			$reslut=$browser_version[$i];
			break;
		}
		$i++;
	}
	return $reslut;
}

/* substr string for mbs char. */
function mbs_substr_string($substr_str, $max_str_len) {
	$codepage=mb_detect_encoding($substr_str);
	if($codepage=="UTF-8") { $max_str_len=(int)($max_str_len/2); }
	if(mb_strlen($substr_str, $codepage)>$max_str_len) { $substr_str=mb_substr($substr_str, 0, $max_str_len-3, $codepage)."..."; }
	
	return $substr_str;
}

function read_file($filename)
{
	$handle = fopen($filename, "rb");
	$contents = fread($handle, filesize($filename));
	fclose($handle);

	return $contents;
}
function filelog($filename,$content) {
	$fp=fopen($filename,'a');
	$content.="\n===============================================================\n";
	fwrite($fp,$content);
}
function filter($val) {
	return('.'!=substr($val,0,1));
}
?>