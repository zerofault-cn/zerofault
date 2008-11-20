<?php

$c = curl_init();
curl_setopt($c, CURLOPT_URL, "http://www.hzbus.com.cn/content/busline/line_search.jsp");
curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($c, CURLOPT_REFERER, "http://www.hzbus.com.cn/");
curl_setopt($c, CURLOPT_POSTFIELDS,"line_name=12");
echo $data = curl_exec($c);
curl_close($c);
?> 

