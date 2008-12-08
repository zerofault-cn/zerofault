<html>
  <head>
  	<title> 选择栏目 </title>
  </head>
  <body>
  	<br>
	<font size="2">请选择您希望转入的栏目：</font><br><br>
 	<FORM name=powersearch action=/sc/search_result.php method=post target=_blank>
<SCRIPT language=javascript>
	

function InsertItem(ObjID, Location)
{
	len=document.powersearch.elements[ObjID].length;
	for (counter=len; counter>Location; counter--)
	{
		Value = document.powersearch.elements[ObjID].options[counter-1].value;
		Text2Insert  = document.powersearch.elements[ObjID].options[counter-1].text;
		document.powersearch.elements[ObjID].options[counter] = new Option(trimPrefixIndent(Text2Insert), Value);
	}
}


function GetObjID(ObjName)
{
  for (var ObjID=0; ObjID < document.powersearch.elements.length; ObjID++)
    if ( document.powersearch.elements[ObjID].name == ObjName )
    {  return(ObjID);
       break;
    }
  return(-1);
}

function AddItem(ObjName, DesName, CatName)
{
  //GET OBJECT ID AND DESTINATION OBJECT
  ObjID    = GetObjID(ObjName);
  DesObjID = GetObjID(DesName);
  k=0;
  i = document.powersearch.elements[ObjID].options.length;
  if (i==0)
    return;
  maxselected=0
  for (h=0; h<i; h++)
     if (document.powersearch.elements[ObjID].options[h].selected ) {
         k=k+1;
         maxselected=h+1;
         }
  if (maxselected>=i)
     maxselected=0;


  if (CatName != "")
    CatObjID = GetObjID(CatName);
  else
    CatObjID = 0;
  if ( ObjID != -1 && DesObjID != -1 && CatObjID != -1 )
  { jj = document.powersearch.elements[CatObjID].selectedIndex;
    if ( CatName != "")
    { CatValue = document.powersearch.elements[CatObjID].options[jj].text;
      CatCode  = document.powersearch.elements[CatObjID].options[jj].value;
    }
    else
      CatValue = "";
    i = document.powersearch.elements[ObjID].options.length;
    j = document.powersearch.elements[DesObjID].options.length;
    for (h=0; h<i; h++)
    { if (document.powersearch.elements[ObjID].options[h].selected )
      {  Code = document.powersearch.elements[ObjID].options[h].value;
         Text = document.powersearch.elements[ObjID].options[h].text;
         j = document.powersearch.elements[DesObjID].options.length;
        
         HasSelected = false;
         for (k=0; k<j; k++ ) {
           if (document.powersearch.elements[DesObjID].options[k].value == Code)
           {  HasSelected = true;
              break;
           }
         }
		if ( HasSelected == false)
		{ 
			Text = trimPrefixIndent(Text);
			if (CatValue !="")
			{ 
				Location = GetLocation(DesObjID, CatValue);
				if ( Location == -1 )
				{ 
					document.powersearch.elements[DesObjID].options[j] =  new Option("---"+CatValue+"---",CatCode);
					document.powersearch.elements[DesObjID].options[j+1] = new Option(Text, Code);
				}//if
				else
				{ 
					InsertItem(DesObjID, Location+1);
					document.powersearch.elements[DesObjID].options[Location+1] = new Option(Text, Code);
				}//else
			}
			else
			{
				document.powersearch.elements[DesObjID].options[j] = new Option(Text, Code);
				var tmp_subject_string = document.powersearch.tmp_subject_string.value;
				if( "" != tmp_subject_string )
				{
					document.powersearch.tmp_subject_string.value = tmp_subject_string + "||"+ Code;
				}
				else
				{
					document.powersearch.tmp_subject_string.value = Code;
				}
			}
		}//if
		document.powersearch.elements[ObjID].options[h].selected =false;
       }//if
    }//for
    document.powersearch.elements[ObjID].options[maxselected].selected =true;
  }//if
}//end of function

function DeleteItem(ObjName)
{
  ObjID = GetObjID(ObjName);
  minselected=0;
  if ( ObjID != -1 )
  {
    for (i=document.powersearch.elements[ObjID].length-1; i>=0; i--)
    {  if (document.powersearch.elements[ObjID].options[i].selected)
       { // window.alert(i);
          if (minselected==0 || i<minselected)
            minselected=i;
          var delete_subject_value = document.powersearch.elements[ObjID].options[i].value;
          var tmp_subject_string = document.powersearch.tmp_subject_string.value;
          var tmp_res = "";
          if( -1 != tmp_subject_string.indexOf( delete_subject_value ) )
          {
          	tmp_subject_array = tmp_subject_string.split("||");
          	for(var ii=0;ii<tmp_subject_array.length;ii++)
          	{
          		if( tmp_subject_array[ii] == delete_subject_value )
          		{
          			continue;
          		}
          		else
          		{
          			tmp_res += tmp_subject_array[ii] + "||";
          		}
          	}
          }
          document.powersearch.tmp_subject_string.value = tmp_res.substring(0,tmp_res.length-2);
          document.powersearch.elements[ObjID].options[i] = null;
       }
    }
    i=document.powersearch.elements[ObjID].length;

    if (i>0)  {
        if (minselected>=i)
           minselected=i-1;
        document.powersearch.elements[ObjID].options[minselected].selected=true;
        }
  }
}

function trimPrefix(str,prefix)
{
	var tmpstr = str;
	var len = prefix.length;
	if(tmpstr.substring(0,len) == prefix)
	{
	tmpstr = tmpstr.substr(len);
	}
	return tmpstr;
}

function trimPrefixIndent(str)
{
	var prefixIndent = String.fromCharCode(160,160)+"--";
	return trimPrefix(str,prefixIndent);
}
	</SCRIPT>
	<TABLE cellSpacing=3 cellPadding=0 width="100%">
              <TBODY>
              <TR>
                <TD width="40%">
                  	<SELECT style="WIDTH: 200px" multiple size=25 name=Areaca> 
                 		<?php
echo $_obj['subjects'];
?>

                  		
                 	</SELECT> 
                 </TD>
                <TD align=middle width="25%"><INPUT onclick="JavaScript:AddItem('Areaca','jobarea[]', '')" type=button value="添加>>" name=""> 
                  <BR><BR><INPUT onclick="JavaScript:DeleteItem('jobarea[]')" type=button value="<<删除" name=""> 
                </TD>
                <TD width="35%"><SELECT style="WIDTH: 200px" multiple size=25
                  name=jobarea[]></SELECT> </TD></TR>
                  <input type="hidden" name="tmp_subject_string" value="">
                  </TBODY></TABLE>
                  <br>
                  <center><input type="button" value="确认提交" onClick="javascript:window.opener.document.article_form.subject_string.value=self.document.powersearch.tmp_subject_string.value;self.close();"> </center>
	</FORM>
	</body>
</html>