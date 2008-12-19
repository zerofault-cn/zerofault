<?php
function LogUL($POST_ARR) {
	$cr = curl_init();
	curl_setopt($cr, CURLOPT_URL, "http://".$_SERVER['HTTP_HOST']."/MRsync/?Mod=LogUL");
	curl_setopt($cr, CURLOPT_POST, 1);
	curl_setopt($cr, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($cr, CURLOPT_POSTFIELDS, $POST_ARR);
	$retCurl = curl_exec($cr);
	curl_close($cr);
	return $retCurl;
}
?>
