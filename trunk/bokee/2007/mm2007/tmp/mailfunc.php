<?php
include_once("includes/class.phpmailer.php");

mailLink('mingzhu@bokee-inc.com','hello');
function mailLink ($addr, $minfo)
{

    $Mail			= new PHPMailer;
    $Mail->Priority	= 3;
    $Mail->Encoding	= "8bit";
    $Mail->CharSet	= "gb2312";
    $Mail->From		= "admin_mm@bokee.com";
    $Mail->FromName	= "博客网";
    $Mail->Sender	= "mm.bokee.com";

    $Mail->IsHTML(true);

    $Mail->Subject	= '博客网－第二届美女博客大赛报名通知';

    $Mail->Body		= 'hello world'.date("y-m-d H:i:s");
    $Mail->WordWrap         = 0;
    $Mail->Port             = 25;
    $Mail->Helo             = "localhost.localdomain";
    $Mail->SMTPAuth         = false;
    $Mail->Username         = "";
    $Mail->Password         = "";

    $Mail->ClearAddresses();
    $Mail->AddAddress($addr,'mailer');

    if(strlen($Mail->Host) > 0) {
        $Mail->Mailer = "smtp";
    }
    else
    {
        $Mail->Mailer = "mail";
    }

    // send the email. should add error check later <<--
    $Mail->Send();

    // empty the mail containers

    $Mail = NULL;
    $ChangeLog = array();
    $NoteLog = array();
    $htmlbody = '';

}

?>
