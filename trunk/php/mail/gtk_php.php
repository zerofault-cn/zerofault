<?
set_time_limit(0);
if(strtoupper(substr(PHP_OS, 0, 3)) == 'WIN')
dl('php_gtk.dll');
else
dl('php_gtk.so');


function destroy()
{
Gtk::main_quit();
}


function delete_event()
{
return false;
}


function sendmail()
{

//定义相关变量
global $run,$newlabel;
set_time_limit ( 120 ) ;
$host="smtp.163.com";
$username=base64_encode("username");
$pwd=base64_encode("password");
$from="ahzxzl@163.com";
$to="rcymonkey@tom.com";
$subject="Test";
$headers="Hello";
$message="测试成功!";

//连接服务器
$connection = fsockopen ($host, 25, &$errno, &$errstr, 1);
$res=fgets($connection,256);

fputs($connection, "EHLO \n");
$res=fgets($connection,256);

fputs($connection, "AUTH LOGIN \n");
$res=fgets($connection,334);

fputs($connection, "$username\n");
$res=fgets($connection,334);

fputs($connection, "$pwd\n");
$res=fgets($connection,235);

//发信
fputs($connection, "MAIL FROM: $from\n");
$res=fgets($connection,250);

fputs($connection, "RCPT TO: $to\n");
$res=fgets($connection,250);

fputs($connection, "DATA\n");
$res=fgets($connection,354);

fputs($connection, "To: $to\nFrom: $from\nSubject: $subject\n$headers\n\n$message\n.\n");
$sign=fgets($connection,256);

//关闭服务器
fputs($connection,"QUIT\n");
fgets($connection,250);

//事件过程
if(substr($sign, 0, 3) == '250'){ //邮件发送成功的处理
global $windows;
if (!isset($windows['buttons'])) {
$window = &new GtkWindow;
$windows['buttons'] = $window;
$window->connect('delete-event', 'delete_event');
$window->set_title('GtkButton');
$window->set_position(GTK_WIN_POS_CENTER);
$window->set_usize(180,100);
/*标签*/
$box1 = &new GtkVBox();
$window->add($box1);
$box1->show();

$label = &new GtkLabel("OK,Send Mail Successfully!");
$box1->pack_start($label,false);
$label->show();

/*直线*/
$box3 = &new GtkVBox(false, 10);
$box3->set_border_width(10);
$box1->pack_start($box3, false);
$box3->show();


$separator = &new GtkHSeparator();
$box3->pack_start($separator, false);
$separator->show();

/* 关闭键*/
$box2 = &new GtkVBox(false, 10);
$box2->set_border_width(10);
$box1->pack_start($box2, false);
$box2->show();

$button = &new GtkButton('close');
$button->connect('clicked', 'destroy');
$box2->pack_start($button);
$button->show();


}
$windows['buttons']->show();
} else { //发送失败的处理,注解同上
global $windows;
if (!isset($windows['buttons'])) {
$window = &new GtkWindow;
$windows['buttons'] = $window;
$window->connect('delete-event', 'delete_event');
$window->set_title('GtkButton');
$window->set_position(GTK_WIN_POS_CENTER);
$window->set_usize(200,100);

$box1 = &new GtkVBox();
$window->add($box1);
$box1->show();

$label = &new GtkLabel("Error,Can not Send a Mail!");
$box1->pack_start($label,false);
$label->show();

$box3 = &new GtkVBox(false, 10);
$box3->set_border_width(10);
$box1->pack_start($box3, false);
$box3->show();


$separator = &new GtkHSeparator();
$box3->pack_start($separator, false);
$separator->show();

$box2 = &new GtkVBox(false, 10);
$box2->set_border_width(10);
$box1->pack_start($box2, false);
$box2->show();

$button = &new GtkButton('close');
$button->connect('clicked', 'destroy');
$box2->pack_start($button);
$button->show();


}
$windows['buttons']->show();
}
}

function cancel()
{
global $entry;
$entry['to']->set_text('');
$entry['subject']->set_text('');
$entry['news']->backward_delete($entry['news']->get_length());
}

$window = &new GtkWindow();
$window->connect('destroy','destroy');
$window->set_border_width(10);
$window->set_usize(600, 400);


//第一层
$box = &new GtkVBox();
$window->add($box);
$box->show();

$fields = array(
to => 'To: ',
subject => 'Subject: ');

while(list($f,$l) = each($fields))
{
$vbox = &new GtkVBox();
$box->pack_start($vbox,false,false);
$vbox->set_border_width(5);
$vbox->show();


$hbox = &new GtkHBox();
$box->pack_start($hbox,false,false);
$vbox->set_border_width(5);
$hbox->show();

$label = &new GtkLabel("$l");
$label->set_usize(150,10);
$hbox->pack_start($label,false);
$label->show();

$entry[$f] = &new GtkEntry();
$hbox->pack_start($entry[$f],false);
$entry[$f]->show();
}


//第二层
$vbox = &new GtkVBox();
$box->pack_start($vbox,false,false);
$vbox->show();
$vbox->set_border_width(3);

$label = &new GtkLabel('Contents:');
$vbox->pack_start($label);
$label->show();

$entry['news'] = &new GtkText();
$entry['news']->set_editable(TRUE);
$vbox->pack_start($entry['news']);
$entry['news']->show();


//第三层
$buttons = array(
SendMail=> 'sendmail',
Cancel=> 'cancel',
Quit => 'destroy');

$hbox = &new GtkHBox();
$hbox->set_border_width(3);
$vbox->pack_start($hbox,false,false);
$hbox->show();

while(list($l,$f) = each($buttons))
{
$button = &new GtkButton($l);
$button->connect('clicked',$f);
$hbox->pack_start($button);
$button->show();
}

//第四层
$vbox = &new GtkVBox();
$box->pack_start($vbox,false,false);
$vbox->show();
$vbox->set_border_width(30);
$newlabel = &new GtkLabel("Do you want to send a mail to your friends?");
$vbox->pack_start($newlabel);
$newlabel->show();

//显示所有的窗口
$window->show_all();
Gtk::main();
?>

