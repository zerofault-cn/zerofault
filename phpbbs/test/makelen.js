function makelen(sstr,slen)
{
	var makestr='';
	var parity=0;
	var tmpstr='';
	var mslen=sstr.length;
	if(mslen>slen)
	{
		for(var mn=0;mn<slen;mn++) //��Ҫ��ĳ�����
		{
			ss=sstr.substring(mn,1);
			if(ss.charCodeAt()<127) //#ΪӢ��
			{
				parity++;
			}
		}
		if(parity%2==1) //#��Ӣ�ĳ���Ϊ����
		{
			if(slen%2==1) //#�����Ҫ��ĳ���ҲΪ����
			{
				tmpstr=sstr.substring(0,slen);
			}
			else //#��Ҫ��ĳ���Ϊż��
			{
				tmpstr=sstr.substring(0,slen-1);
			}
		}
		else //#��Ӣ�ĳ���Ϊż������Ϊ0��0ҲΪż��
		{
			if(slen%2==1) //#�����Ҫ��ĳ���Ϊ����
			{
				tmpstr=sstr.substring(0,slen-1);
			}
			else //#��Ҫ��ĳ���Ϊż��
			{
				tmpstr=sstr.substring(0,slen);
			}
		}
		makestr=tmpstr;
	}
	else
	{
		makestr=sstr;
	}
	return makestr;
}

