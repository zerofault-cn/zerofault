<?php
include_once("includes/class.phpmailer.php");
if (strpos($_SERVER["SCRIPT_NAME"],basename(__FILE__)) !== false) {
  header("location: 'http://www.bokee.com'");
  exit;
}

$MY_SENDER      = 'weekly@bokee.com';
$MY_FORMNAME    = '�װ����û�';
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
    $Mail->FromName         = "������";
    $Mail->Sender           = "$MY_SENDER";


    $currentUrl             = $DEFAULT_URL.$minfo['htmfilename'];
//    $htmlbody               = file_get_contents($minfo['htmfilename']);
    $htmlbody               = $minfo['temp_str'];

    $notice = '<BASE HREF='.$DEFAULT_URL.$minfo['htmfilename']. ' TARGET="_top">';
    // use $insert to replace $tail to add the unsubscribe link
    $tail                   = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";

    $insert                 = '�˶����ӣ�&nbsp<a href="'.$deleteUrl.'"><strong>[�˶�]</strong></a>';

    $htmlbody = str_replace($tail, $insert, $htmlbody);
    $htmlbody = $notice.$htmlbody;
    $Mail->IsHTML(true);

    $Mail->Subject            = $minfo['area_id'].'�ܿ���'.$minfo['cat_num'].'��|'.$minfo['covertitle'];

    $altbody                = "\n\t\t".$nm."\n\n\n\n"
                              .'��ӭ�Ķ�����һ�ڲ����ܿ�!'
                              ."\n\n".'����emailϵͳ����δ����Ϊֱ�����HTML��ҳ���á�'
                              ."\n".'��򿪸����еĳ��ı���ʽ�Ķ�ȫ�µĲ����ܿ���'
                              ."\n".'��Ҳ����ͨ�������������ֱ�ӷ�������һ�ڵĲ���'
                              ."\n".'�ܿ���'
                              .$currentUrl
                              ."\n\n\t\t".'�����δ���ڲ����ܿ����ģ����߲���'
                              ."\n".'�����յ������ܿ�������������������ȡ�����ġ�'
                              ."\n".'���������յ�δ������ɵĲ����ܿ����͡�'
                              ."\n".'��л����֧�֣�'
                              ."\n".'�˶����ӣ�'
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
    $Mail->AddReplyTo("$MY_SENDER", "������");
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
