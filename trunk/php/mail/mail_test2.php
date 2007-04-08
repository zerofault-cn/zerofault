<?
/*
        
    $mail = array('webmaster@jieyang.cc');

    $from = 'webmaster@gd-yulong.com';

    $header = array(
        'From: "Richard Heyes" <8888zqw@163.com>',    // Headers
        'To: webmaster@gd-yulong.com',
        'Subject: Test email',
        );

    $body = '123';

    */
    function mailto (&$mail, &$from, &$header, &$body, $auth = false)
    {
        $params['host'] = 'mail.gd-yulong.com';
        $params['port'] = '25';
        $params['helo'] = 'obj';
        if ($auth != true) {
            $params['auth'] = false;    
        } else {
            $params['auth'] = true;    
        }
        $params['user'] = 'webmaster@gd-yulong.com';
        $params['pass'] = '';    

        $send['recipients']    =& $mail;
        $send['headers'] =& $header;
        $send['from'] =& $from;
        $send['body'] =& $body;

        if (file_exists($this->obj['rootDir'].'class/smtp.inc.php')) {
            include_once($this->obj['rootDir'].'class/smtp.inc.php');
        } else {
            die('none');
        }
        
        if(is_object($_STATIC_CLASS_MAIL = smtp::connect($params)) && $_STATIC_CLASS_MAIL->send($send)){
            return true;
        } else {
            return false;
        }
    }
	?>