function makelen(sstr,slen)
{
	var makestr='';
	var parity=0;
	var tmpstr='';
	var mslen=sstr.length;
	if(mslen>slen)
	{
		for(var mn=0;mn<slen;mn++) //在要求的长度内
		{
			ss=sstr.substring(mn,1);
			if(ss.charCodeAt()<127) //#为英文
			{
				parity++;
			}
		}
		if(parity%2==1) //#含英文长度为奇数
		{
			if(slen%2==1) //#如果所要求的长度也为奇数
			{
				tmpstr=sstr.substring(0,slen);
			}
			else //#所要求的长度为偶数
			{
				tmpstr=sstr.substring(0,slen-1);
			}
		}
		else //#含英文长度为偶数或者为0，0也为偶数
		{
			if(slen%2==1) //#如果所要求的长度为奇数
			{
				tmpstr=sstr.substring(0,slen-1);
			}
			else //#所要求的长度为偶数
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

