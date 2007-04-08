<?php
$header="From:admin@bokee.com\r\nReply-To:admin@bokee.com\r\nX-Mailer: PHP/".phpversion()."\r\nContent-Type:text/html"; 
$result=mail("zerofault@gmail.com","hello".date("y-m-d h:i:s"),'body'); 
if($result) 
{
	echo "success"; 
}
else
{
	echo 'error';
}
?>