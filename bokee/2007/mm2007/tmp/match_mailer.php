<?php
include_once("includes/class.phpmailer.php");
if (strpos($_SERVER["SCRIPT_NAME"],basename(__FILE__)) !== false) {
  header("location: 'http://www.bokee.com'");
  exit;
}

$MY_SENDER      = 'weekly@bokee.com';
$MY_FORMNAME    = '亲爱的用户';
$DEFAULT_URL    = 'http://weekly.bokee.com/';
$INCLUDE_DIR    = "";

function mailLink ($addr, $minfo) {
echo $addr;die;
    global $global_vars;
    global $MY_SENDER;
    global $MY_FORMNAME;
    global $DEFAULT_URL;

    global $INCLUDE_DIR;

    $nm = $MY_FORMNAME;
    $md5hash = md5($addr.$nm);

    // the url for the user to unsubscribe
    $deleteUrl = 'http://weekly.bokee.com/confirm.php?emaildelete='
                 .$addr. "&md5hashdelete=".$md5hash;


    $Mail                   = new PHPMailer;
    $Mail->Priority         = 3;
    $Mail->Encoding         = "8bit";
    $Mail->CharSet          = "gb2312";
    $Mail->From             = "$MY_SENDER";
    $Mail->FromName         = "博客网";
    $Mail->Sender           = "$MY_SENDER";


    $currentUrl             = $DEFAULT_URL.$minfo['htmfilename'];
//    $htmlbody               = file_get_contents($minfo['htmfilename']);
    $htmlbody               = $minfo['temp_str'];

    $notice = '<BASE HREF='.$DEFAULT_URL.$minfo['htmfilename']. ' TARGET="_top">';
    // use $insert to replace $tail to add the unsubscribe link
    $tail                   = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";

    $insert                 = '退订链接：&nbsp<a href="'.$deleteUrl.'"><strong>[退订]</strong></a>';

    $htmlbody = str_replace($tail, $insert, $htmlbody);
    $htmlbody = $notice.$htmlbody;
    $Mail->IsHTML(true);

    $Mail->Subject            = $minfo['area_id'].'周刊第'.$minfo['cat_num'].'期|'.$minfo['covertitle'];

    $altbody                = "\n\t\t".$nm."\n\n\n\n"
                              .'欢迎阅读最新一期博客周刊!'
                              ."\n\n".'您的email系统可能未设置为直接浏览HTML网页配置。'
                              ."\n".'请打开附件中的超文本格式阅读全新的博客周刊。'
                              ."\n".'您也可以通过下面的链接来直接访问最新一期的博客'
                              ."\n".'周刊：'
                              .$currentUrl
                              ."\n\n\t\t".'如果您未曾在博客周刊订阅，或者不想'
                              ."\n".'继续收到博客周刊，请您点击下面的链接取消定阅。'
                              ."\n".'您将不会收到未经您许可的博客周刊发送。'
                              ."\n".'感谢您的支持！'
                              ."\n".'退定链接：'
                              ."\n".$deleteUrl;

    $Mail->AltBody          = $altbody;
    $Mail->Body             = $htmlbody;
    $Mail->WordWrap         = 0;
/*    $Mail->Host             = $global_vars["mail_host"]; */
/*    $Mail->Host             = "127.0.0.1" ; */
    $Mail->Port             = 25;
    $Mail->Helo             = "localhost.localdomain";
    $Mail->SMTPAuth         = false;
    $Mail->Username         = "";
    $Mail->Password         = "";
    $Mail->PluginDir        = $INCLUDE_DIR;
    $Mail->AddReplyTo("$MY_SENDER", "博客网");
    $Mail->Sender           = "$MY_SENDER";

    $Mail->ClearAddresses();
    $Mail->AddAddress($addr, $nm);

    if(strlen($Mail->Host) > 0) {
        $Mail->Mailer = "smtp";
    }
    else
    {
        $Mail->Mailer = "mail";
        $Sender = "$MY_SENDER";
    }

        $Mail->Mailer = "mail";
        $Sender = "$MY_SENDER";


    // send the email. should add error check later <<--
    $Mail->Send();

    // empty the mail containers

    $Mail = NULL;
    $ChangeLog = array();
    $NoteLog = array();
    $htmlbody = '';

}

?>
