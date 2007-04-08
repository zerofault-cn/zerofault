<?
echo 'HTTP_CLIENT_IP';
echo getenv("HTTP_CLIENT_IP");

echo '<br>';
echo 'HTTP_X_FORWARDED_FOR';
echo getenv("HTTP_X_FORWARDED_FOR");

echo '<br>';
echo 'REMOTE_ADDR';
echo getenv("REMOTE_ADDR");

echo '<br>';
echo '_SERVER[REMOTE_ADDR]';
echo $_SERVER['REMOTE_ADDR'];
?>
<?
$array = array(
               "REMOTE_ADDR",
               "DOCUMENT_ROOT",
               "GATEWAY_INTERFACE",
               "SERVER_SOFTWARE",
               "SERVER_NAME",
               "SERVER_PROTOCOL",
               "SERVER_PORT",
               "SERVER_ADMIN",
               "SERVER_SIGNATURE",
               "REQUEST_METHOD",
               "REQUEST_URI",
               "PATH_INFO",
               "PATH_TRANSLATED",
               "SCRIPT_NAME",
               "SCRIPT_FILENAME",
               "QUERY_STRING",
               "REMOTE_HOST",
               "REMOTE_ADDR",
               "REMOTE_USER",
               "REMOTE_IDENT",
               "CONTENT_TYPE",
               "CONTENT_LENGTH",
               "HTTP_ACCEPT",
               "HTTP_ACCEPT_CHARSET",
               "HTTP_ACCEPT_LANGUAGE",
               "HTTP_ENCODING",
               "HTTP_USER_AGENT",
               "HTTP_CONNECTION",
               "HTTP_HOST",
               "HTTP_REFERER",
               "AUTH_TYPE"
              );

echo '<center>';
echo '<table border="1" cellspacing="0" cellpadding="0">';
echo '<caption>CGI Environment Variables</caption>';
echo '<tr><th>Name<th>Value</tr>';

$count = count($array);
for($i=0;$i<$count;$i++){
   $value = getenv($array[$i]);
   if($value){
      echo "<tr><td>$array[$i]<td>" . $value . "</tr>";
   }
//��������Ҳ����Ŷ
//   if(isset($$array[$i])){
//      echo "<tr><td>$array[$i]<td>" . $$array[$i] . "</tr>";
//   }
}

echo '</table>';
echo '</center>';
?>