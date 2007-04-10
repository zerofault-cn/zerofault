//ȥ��ո�; 
function ltrim(s){ 
 return s.replace( /^\s*/, ""); 
} 
//ȥ�ҿո�; 
function rtrim(s){ 
 return s.replace( /\s*$/, ""); 
} 
//ȥ���ҿո�; 
function trim(s){ 
 return rtrim(ltrim(s)); 
} 
//�Ƿ�Ϊ��ֵ; 
function IsEmpty(_str){ 
 var tmp_str = trim(_str); 
 return tmp_str.length == 0; 
} 
//�Ƿ���Ч��Email; 
function IsMail(_str){ 
 var tmp_str = trim(_str); 
 var pattern = /^[_a-z0-9-]+(.[_a-z0-9-]+)*@[a-z0-9-]+(.[a-z0-9-]+)*$/; 
 return pattern.test(tmp_str);   
} 
//�Ƿ���Ч������; 
function IsNumber(_str){ 
 var tmp_str = trim(_str); 
 var pattern = /^[0-9]/; 
 return pattern.test(tmp_str);   
} 
//�Ƿ���Ч����ɫֵ; 
function IsColor(color){ 
 var temp=color; 
 if (temp=="") return true; 
 if (temp.length!=7) return false; 
 return (temp.search(/\#[a-fA-F0-9]{6}/) != -1); 
} 
//�Ƿ���Ч������; 
function IsURL(url){ 
 var sTemp; 
 var b=true; 
 sTemp=url.substring(0,7); 
 sTemp=sTemp.toUpperCase(); 
 if ((sTemp!="HTTP://")||(url.length<10)){ 
  b=false; 
 } 
 return b; 
} 
//�Ƿ���Ч���ֻ�����; 
function IsMobile(_str){ 
 var tmp_str = trim(_str); 
 var pattern = /13\d{9}/; 
 return pattern.test(tmp_str);   
}