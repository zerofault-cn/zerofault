<?
//��������õ�

    set_time_limit("0");
    function result() {
        global $socket;
        $result = fgets($socket);
        echo $result,"<BR>";
    }
    $socket = fsockopen("smtp.163.com","25");
    set_socket_blocking($socket,true);
    fputs($socket,"HELO try \r\n");
    fputs($socket,"AUTH LOGIN \r\n");
    fputs($socket,base64_encode("zerofault")."\r\n");
    fputs($socket,base64_encode("548512")."\r\n");
    fputs($socket,"MAIL FROM: zerofault@163.com \r\n");
    fputs($socket,"RCPT TO: zerofault@163.com\r\n");
    fputs($socket,"DATA\r\n");
    $send = "From: zerofault@163.com\r\n"."To: zerofault@163.com"."Subject:test\r\n\r\nThis is test mail.2003-11-27\r\n.\r\n";
    fputs($socket,$send);
    result();
    fclose($socket);
	/*
	$send = "From: langjia@tom.com\r\n"."To: langjia@tom.com"."Subject:test\r\n\r\nThis is test mail\r\n.\r\n";
Subject: test���Ǳ��Ⱑ�������ǲ���������ˣ�



����Ӧ��Ҳ��һ�а�



$send = "From: langjia@tom.com\r\n"."To: langjia@tom.com"."Subject:test\r\n\r\nThis is test mail\r\n.\r\n";
�԰����ڱ���ǰӦ�ü�\r\n



\r\nSubject:test\r\n

/*
?>

