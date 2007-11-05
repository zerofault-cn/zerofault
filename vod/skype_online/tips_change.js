function changeTips()
{
	var account1=document.form1.user_account1.value;
	var account2='';
	for(var i=0;i<(11-account1.length);i++)
	{
		account2+=(i+1);
	}
	document.getElementById('acc1').innerHTML=account1;
	document.getElementById('acc2').innerHTML=account2;
	document.getElementById('acc3').innerHTML=i;
}
