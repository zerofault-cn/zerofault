<?php /* Smarty version 1.5.2, created on 2003-09-24 13:31:57
         compiled from default/advanced-editor.htm */ ?>
<!-- 
available only for IE5+ users
-->
<?php $this->_config_load($this->_tpl_vars['umLanguageFile'], "AdvancedEditor", 'local'); ?>

<?php echo '
<style type="text/css">
SELECT
{
    BACKGROUND:        #eeeeee;
    FONT: 9pt "ËÎÌו",arial,sans-serif
}
.Gen
{
    POSITION: relative
}
TABLE
{
    POSITION: relative
}
.heading
{
    BACKGROUND:        #eeeeee;
    Color: #000000
}
.Composition
{
    BACKGROUND-COLOR: menu;
    POSITION: relative
}
.yToolbar
{
    BACKGROUND-COLOR: menu;
    BORDER-BOTTOM: buttonshadow        1px solid;
    BORDER-LEFT: buttonhighlight 1px solid;
    BORDER-RIGHT: buttonshadow 1px solid;
    BORDER-TOP:        buttonhighlight        1px solid;
    HEIGHT: 27px;
    LEFT: 0px;
    POSITION: relative;
    TOP: 0px
}

.Btn
{
    BACKGROUND-COLOR: menu;
    BORDER-BOTTOM: buttonface 1px solid;
    BORDER-LEFT: buttonface 1px        solid;
    BORDER-RIGHT: buttonface 1px solid;
    BORDER-TOP:        buttonface 1px solid;
    HEIGHT: 23px;
    POSITION: absolute;
    TOP: 1px;
    WIDTH: 23px
}
.Ico
{
    HEIGHT: 22px;
    LEFT: -1px;
    POSITION: absolute;
    TOP: -1px;
    WIDTH: 22px
}
.TBSep
{
    BORDER-LEFT: buttonshadow 1px solid;
    BORDER-RIGHT: buttonhighlight 1px solid;
    FONT-SIZE: 0px;
    HEIGHT: 22px;
    POSITION: absolute;
    TOP: 1px;
    WIDTH: 1px
}
.TBGen
{
    FONT: 9pt "ËÎÌו",arial,sans-serif;
    HEIGHT: 22px;
    POSITION: absolute;
    TOP: 2px
}
.TBHandle
{
    BACKGROUND-COLOR: menu;
    BORDER-LEFT: buttonhighlight 1px solid;
    BORDER-RIGHT: buttonshadow 1px solid;
    BORDER-TOP:        buttonhighlight        1px solid;
    FONT-SIZE: 1px;
    HEIGHT: 22px;
    POSITION: absolute;
    TOP: 1px;
    WIDTH: 3px
}
.BtnMouseOverUp
{
    BACKGROUND-COLOR: buttonface;
    BORDER-BOTTOM: buttonshadow        1px solid;
    BORDER-LEFT: buttonhighlight 1px solid;
    BORDER-RIGHT: buttonshadow 1px solid;
    BORDER-TOP:        buttonhighlight        1px solid;
    HEIGHT: 23px;
    POSITION: absolute;
    TOP: 1px;
    WIDTH: 24px
}
.BtnMouseOverDown
{
    BACKGROUND-COLOR: buttonface;
    BORDER-BOTTOM: buttonhighlight 1px solid;
    BORDER-LEFT: buttonshadow 1px solid;
    BORDER-RIGHT: buttonhighlight 1px solid;
    BORDER-TOP:        buttonshadow 1px solid;
    HEIGHT: 23px;
    POSITION: absolute;
    TOP: 1px;
    WIDTH: 24px
}
.BtnDown
{
    BACKGROUND-COLOR: gainsboro;
    BORDER-BOTTOM: buttonhighlight 1px solid;
    BORDER-LEFT: buttonshadow 1px solid;
    BORDER-RIGHT: buttonhighlight 1px solid;
    BORDER-TOP:        buttonshadow 1px solid;
    HEIGHT: 23px;
    POSITION: absolute;
    TOP: 1px;
    WIDTH: 24px
}
.IcoDown
{
    HEIGHT: 23px;
    LEFT: 0px;
    POSITION: absolute;
    TOP: 0px;
    WIDTH: 24px
}
.IcoDownPressed
{
    LEFT: 1px;
    POSITION: absolute;
    TOP: 1px
}
</STYLE>
'; ?>


   				<table width="100%" border="0" cellspacing="0" cellpadding="3">
   					<tr>
   						<td bgcolor=menu>
   							<div class="yToolbar" id="ParaToolbar">
   								<div class="TBHandle">
   								</div>
   								<div class="Btn" language="javascript" onClick="formatC('cut')"><img class="Ico" src="images/cut.gif"></div>
   								<div class="Btn" language="javascript" onClick="formatC('copy')"><img class="Ico" src="images/copy.gif"></div>
   								<div class="Btn" language="javascript" onClick="formatC('paste')"><img class="Ico" src="images/paste.gif"></div>
   								<div class="Btn" language="javascript" onClick="formatC('undo')"><img class="Ico" src="images/undo.gif"></div>
   								<div class="Btn" language="javascript" onClick="formatC('redo');"><img class="Ico" src="images/redo.gif"></div>
   								<div class="TBSep">
   								</div>
   								<div class="Btn" language="javascript" onClick="formatC('bold');"><img class="Ico" src="images/bold.gif"></div>
   								<div class="Btn" language="javascript" onClick="formatC('italic')"><img class="Ico" src="images/italic.gif"></div>
   								<div class="Btn" language="javascript" onClick="formatC('underline')"><img class="Ico" src="images/under.gif"></div>
   								<div class="TBSep">
   								</div>
   								<div class="Btn" language="javascript" onClick="UserDialog('createLink')"><img class="Ico" src="images/wlink.gif"></div>
   								<div class="Btn" language="javascript" onClick="insertImage()"><img class="Ico" src="images/img.gif"></div>
   								<div class="Btn" language="javascript" onClick="insertTable()"><img class="Ico" src="images/table.gif"></div>
   								<div class="Btn" language="javascript" onClick="formatC('InsertHorizontalRule')"><img class="Ico" src="images/hline.gif"></div>
   								<div class="Btn" language="javascript" onClick="foreColor()"><img class="Ico" src="images/fgcolor.gif"></div>
   								<div class="Btn" language="javascript" onClick="backColor()"><img class="Ico" src="images/gbcolor.gif"></div>
   								<div class="TBSep">
   								</div>
   								<div id="EditMode" class="TBGen">
   								   <input type="checkbox" name="switchMode" LANGUAGE="javascript" onClick="setMode(switchMode.checked)">
								   <a href="javascript:void(0)" onClick="document.composeForm.switchMode.click()"><font color="#000000" face="Arial"><?php echo $this->_config[0]['vars']['view_source']; ?>
</font></a> 
<!--
								   <a href="javascript:void(0)" onClick="formatC('formatBlock','removeFormat')"><font color="#000000" face="Arial" size=2><?php echo $this->_config[0]['vars']['clear_format']; ?>
</font></a>
-->
   								</div>
   							</div>
   							
   							<div class="yToolbar" id="ParaToolbar">
   								<div class="TBHandle">
   								</div>
   								<select id="ParagraphStyle" class="TBGen" language="javascript" onChange="formatC('formatBlock',this[this.selectedIndex].value);this.selectedIndex=0">
   									<option class="heading" selected><?php echo $this->_config[0]['vars']['format_paragraph']; ?>
</option>
   									<option value="&lt;H1&gt;"><?php echo $this->_config[0]['vars']['format_h1']; ?>
</option>
   									<option value="&lt;H2&gt;"><?php echo $this->_config[0]['vars']['format_h2']; ?>
</option>
   									<option value="&lt;H3&gt;"><?php echo $this->_config[0]['vars']['format_h3']; ?>
</option>
   									<option value="&lt;H4&gt;"><?php echo $this->_config[0]['vars']['format_h4']; ?>
</option>
   									<option value="&lt;H5&gt;"><?php echo $this->_config[0]['vars']['format_h5']; ?>
</option>
   									<option value="&lt;H6&gt;"><?php echo $this->_config[0]['vars']['format_h6']; ?>
</option>
   									<option value="&lt;PRE&gt;"><?php echo $this->_config[0]['vars']['format_pre']; ?>
</option>
   									<option value="removeFormat"><?php echo $this->_config[0]['vars']['format_clear_all']; ?>
</option>
   								</select>
   								<select id="FontName" class="TBGen" language="javascript" onChange="formatC('fontname',this[this.selectedIndex].value);this.selectedIndex=0">
   									<option class="heading" selected><?php echo $this->_config[0]['vars']['format_font']; ?>
</option>
   									<option value="Arial">Arial</option>
   									<option value="Arial Black">Arial Black</option>
   									<option value="Arial Narrow">Arial Narrow</option>
   									<option value="Comic Sans MS">Comic Sans MS</option>
   									<option value="Courier New">Courier New</option>
   									<option value="System">System</option>
   									<option value="Times New Roman">Times New Roman</option>
   									<option value="Verdana">Verdana</option>
   									<option value="Wingdings">Wingdings</option>
   									<?php echo $this->_config[0]['vars']['extra_font_list']; ?>

   								</select>
   								<select id="FontSize" class="TBGen" language="javascript" onChange="formatC('fontsize',this[this.selectedIndex].value);this.selectedIndex=0">
   									<option class="heading" selected><?php echo $this->_config[0]['vars']['format_size']; ?>
</option>
   									<option value="1">1</option>
   									<option value="2">2</option>
   									<option value="3">3</option>
   									<option value="4">4</option>
   									<option value="5">5</option>
   									<option value="6">6</option>
   									<option value="7">7</option>
   								</select>
   								<div class="TBSep">
   								</div>
   								<div class="Btn" name="Justify" language="javascript" onClick="formatC('justifyleft')"><img class="Ico" src="images/aleft.gif"></div>
   								<div class="Btn" name="Justify" language="javascript" onClick="formatC('justifycenter')"><img class="Ico" src="images/center.gif"></div>
   								<div class="Btn" name="Justify" language="javascript" onClick="formatC('justifyright')"><img class="Ico" src="images/aright.gif"></div>
   								<div class="TBSep">
   								</div>
   								<div class="Btn" language="javascript" onClick="formatC('insertorderedlist')"><img class="Ico" src="images/nlist.gif"></div>
   								<div class="Btn" language="javascript" onClick="formatC('insertunorderedlist')"><img class="Ico" src="images/blist.gif"></div>
   								<div class="Btn" language="javascript" onClick="formatC('outdent')"><img class="Ico" src="images/ileft.gif"></div>
   								<div class="Btn" language="javascript" onClick="formatC('indent')"><img class="Ico" src="images/iright.gif"></div>
   							</div>
   	   					</td>
   					</tr>
   							
   					<tr>
   						<td>
						<iframe name="Composition" id="Composition" width="100%" height="190" frameborder="0" class="Composition" style="border: 1px dotted;"></iframe>
   						</td>
   					</tr>
   				</table>


<?php echo '
<script language="JavaScript">
<!--
SEP_PADDING = 5
HANDLE_PADDING = 7

bLoad = false
pureText = true

bodyTag = "<HEAD><STYLE type=\\"text/css\\">body {font-size: 10.8pt}</STYLE>";
'; ?>

bodyTag += "<META http-equiv=\"Content-Type\" content=\"text/html; charset=<?php echo $this->_config[0]['vars']['default_char_set']; ?>
\"></HEAD>"
<?php echo '

if( document.composeForm.bgcolor && document.composeForm.bgcolor.value != \'-1\' )
   bodyTag += "<BODY bgcolor=" + document.composeForm.bgcolor.value + " MONOSPACE></BODY>"
else
   bodyTag += "<BODY bgcolor=\\"#FFFFFF\\" MONOSPACE></BODY>"


bTextMode = false
public_description = new Editor

/*****************************
 Power Editor class
 member function:
 SetHtml
 GetHtml
 SetText
 GetText
 GetCompFocus()
 *****************************/
function Editor() {
	this.put_HtmlMode = setMode;
	this.put_value = SetValue;
	this.get_value = GetValue;
//	this.put_html = SetHtml;
//	this.get_html = GetHtml;
//	this.put_text = SetText;
//	this.get_text = GetText;
	this.CompFocus = GetCompFocus;
}

function GetCompFocus() {
	Composition.focus();
}

function GetText() {
	return Composition.document.body.innerText;
}

function SetText(text) {
	Composition.document.body.innerHTML = text;
}

function GetHtml() {
	if (bTextMode) 
		return Composition.document.body.innerText;
	else {
		cleanHtml();
		cleanHtml();
		return Composition.document.body.innerHTML;
	}
}

function SetHtml(sVal) {
	if (bTextMode) 
		Composition.document.body.innerText = sVal;
	else 
		Composition.document.body.innerHTML = sVal;
}

function GetValue() {
	if (bTextMode) 
		return Composition.document.body.innerText;
	else {
		cleanHtml();
		cleanHtml();
		return Composition.document.body.innerHTML;
	}
}

function SetValue(sVal) {
	if (bTextMode) 
		Composition.document.body.innerText = sVal;
	else 
		Composition.document.body.innerHTML = sVal;
}
//End  of Editor Class

/***********************************************
 Initialize everything when the document is ready
 ***********************************************/
var YInitialized = false;

function document.onreadystatechange(){
	if (YInitialized) return;
	
	YInitialized = true;
	var i, s, curr;
	// Find all the toolbars and initialize them.
	for (i = 0; i < document.body.all.length; i++) {
		curr=document.body.all[i];
	    if (curr.className == "yToolbar")
	    {
	      InitTB(curr);
	    }
	}
	Composition.document.open("text/html","replace")
	Composition.document.write(bodyTag);
	Composition.document.close()
	Composition.document.designMode = "On"
//	Composition.document.onkeydown = _handleKeyDown;
	SetHtml(hiddencomposeForm.hiddencomposeFormTextArea.value);

}

function _handleKeyDown () {
	var ev = this.parentWindow.event
	if(ev.keyCode == 13) {
		Composition.focus();
		
		var sel=Composition.document.selection.createRange();
		sel.pasteHTML("<P>");
		sel.select();
		ev.returnValue=false;
		ev.cancelBubble=true;
	}
}

/***********************************************
 Initialize a button ontop of toolbar
 ***********************************************/
function InitBtn(btn) {
	btn.onmouseover = BtnMouseOver;
	btn.onmouseout = BtnMouseOut;
	btn.onmousedown = BtnMouseDown;
	btn.onmouseup = BtnMouseUp;
	btn.ondragstart = YCancelEvent;
	btn.onselectstart = YCancelEvent;
	btn.onselect = YCancelEvent;
	btn.YUSERONCLICK = btn.onclick;
	btn.onclick = YCancelEvent;
	btn.YINITIALIZED = true;
	return true;
}

function InitTB(y)
{
	y.TBWidth = 0;

  	if (!PopulateTB(y)) 
  		return false;

  	y.style.posWidth = y.TBWidth;

  	return true;
}

function PopulateTB(y)
{
	var i, elements, element;

	elements = y.children;
	for (i = 0; i < elements.length; i++) {
    	element = elements[i];
    	if (element.tagName == "SCRIPT" || element.tagName == "!") 
    		continue;

    	switch (element.className) {
    	case "Btn":
      		if (element.YINITIALIZED == null)        {
                if (! InitBtn(element))
                        return false;
      		}

      		element.style.posLeft = y.TBWidth;
      		y.TBWidth        += element.offsetWidth + 1;
      		break;

    	case "TBGen":
      		element.style.posLeft = y.TBWidth;
      		y.TBWidth        += element.offsetWidth + 1;
      		break;

    	case "TBSep":
      		element.style.posLeft = y.TBWidth        + 2;
      		y.TBWidth        += SEP_PADDING;
      		break;

    	case "TBHandle":
      		element.style.posLeft = 2;
      		y.TBWidth        += element.offsetWidth + HANDLE_PADDING;
      		break;

    	default:
      		return false;
    	}
  	}

  	y.TBWidth += 1;
  	return true;
}

// Hander that simply cancels an event
function YCancelEvent() {
	event.returnValue = false;
	event.cancelBubble = true;
	return false;
}

// Toolbar button onmouseover handler
function BtnMouseOver() {
	if (event.srcElement.tagName != "IMG") 
		return false;
	var image = event.srcElement;
	var element = image.parentElement;
	// Change button look based on current state of image.- we don\'t actually have chaned image
	// could be commented but don\'t remove for future extension
	if (image.className == "Ico") 
		element.className = "BtnMouseOverUp";
	else if (image.className == "IcoDown") 
		element.className = "BtnMouseOverDown";
	event.cancelBubble = true;
}

// Toolbar button onmouseout handler
function BtnMouseOut() {
	if (event.srcElement.tagName != "IMG") {
		event.cancelBubble = true;
		return false;
	}
	var image = event.srcElement;
	var element = image.parentElement;
	yRaisedElement = null;
	element.className = "Btn";
	image.className = "Ico";
	event.cancelBubble = true;
}

// Toolbar button onmousedown handler
function BtnMouseDown() {
	if (event.srcElement.tagName != "IMG") {
    	event.cancelBubble = true;
    	event.returnValue=false;
    	return false;
  	}
  	var image = event.srcElement;
  	var element = image.parentElement;

  	element.className = "BtnMouseOverDown";
  	image.className = "IcoDown";

  	event.cancelBubble = true;
  	event.returnValue = false;
  	return false;
}

// Toolbar button onmouseup handler
function BtnMouseUp() {
  	if (event.srcElement.tagName != "IMG") {
    	event.cancelBubble = true;
    	return false;
  	}

  	var image = event.srcElement;
  	var element = image.parentElement;

  	if (element.YUSERONCLICK) eval(element.YUSERONCLICK + "anonymous()");

  	element.className = "BtnMouseOverUp";
  	image.className = "Ico";

  	event.cancelBubble = true;
  	return false;
}

// Check if toolbar is being used when in text mode
function validateMode() {
  	if (! bTextMode) 
  		return true;
'; ?>

  		alert('<?php echo $this->_config[0]['vars']['adv_warning_text_mode1']; ?>
 "<?php echo $this->_config[0]['vars']['view_source']; ?>
" <?php echo $this->_config[0]['vars']['adv_warning_text_mode2']; ?>
');
<?php echo '
  	Composition.focus();
  	return false;
}

function sendHtml(){
	if(bTextMode){
		document.composeForm.body.value = public_description.get_text();
		return true;
	}
	else{
		document.composeForm.body.value = public_description.get_html();
		return true;
	}
}

//Formats text in composition.
function formatC(what,opt) {
  	if (!validateMode()) 
  		return;
  	if (opt == "removeFormat") {
    	what=opt;
    	opt=null;
  	}
  
  	Composition.focus();
  
  	if (opt == null) 
  		Composition.document.execCommand(what);
  	else 
  		Composition.document.execCommand(what, "", opt);
  		
  	pureText = false;
  	
  	Composition.focus();
}

//Switches between text and html mode.
function setMode(newMode) {
  	bTextMode = newMode;
  	var cont;
  	if (bTextMode) {
    	cleanHtml();
    	cleanHtml();
    	
    	cont=Composition.document.body.innerHTML;
    	Composition.document.body.innerText = cont;
  	} 
  	else {
    	cont=Composition.document.body.innerText;
    	Composition.document.body.innerHTML = cont;
  	}
  
  	Composition.focus();
}

//Finds and returns an element.
function getEl(sTag,start) {
  	while ((start!=null) && (start.tagName != sTag)) 
  		start = start.parentElement;
  	return start;
}

function UserDialog(what)
{
  	if (!validateMode()) 
  		return;

  	Composition.focus();
  	Composition.document.execCommand(what, true);

  	pureText = false;
  	Composition.focus();
}

function createLink() {
  	if (!validateMode()) 
  		return;
  
  	var isA = getEl("A", Composition.document.selection.createRange().parentElement());

'; ?>


  	var str = prompt("<?php echo $this->_config[0]['vars']['adv_type_urlpath']; ?>
", isA ? isA.href : "http:\/\/");

<?php echo '

  	if ((str != null) && (str != "http://")) {
		Composition.focus();
	
    	if (Composition.document.selection.type == "None") {
      		var sel = Composition.document.selection.createRange();
      		sel.pasteHTML("<A HREF=\\"" + str + "\\">" + str + "</A> ");
      		sel.select();
    	}
    	else 
    		formatC("CreateLink",str);
  	}
  	else 
  		Composition.focus();
}

function insertImage() {
  if (!validateMode()) return;
  
'; ?>


    var str = showModalDialog("<?php echo $this->_tpl_vars['umInsPictureUrl']; ?>
", "", "dialogWidth:30em; dialogHeight:14em; status:0");

<?php echo '

  if (str != null) {
      Composition.focus();
      
      var sel = Composition.document.selection.createRange();
      sel.pasteHTML(str);
      sel.select();
  }
  else 
  	Composition.focus();
}


function insertTable() {
  if (!validateMode()) return;
  
'; ?>


    var str = showModalDialog("<?php echo $this->_tpl_vars['umInsTableUrl']; ?>
", "", "dialogWidth:24em; dialogHeight:12em; status:0");

<?php echo '

  if (str != null) {
      Composition.focus();
      
      var sel = Composition.document.selection.createRange();
      sel.pasteHTML(str);
      sel.select();
  }
  else 
  	Composition.focus();
}

//Sets the text color.
function foreColor() {
  	if (! validateMode()) 
  		return;
'; ?>

  	var arr = showModalDialog("<?php echo $this->_tpl_vars['umSelColorUrl']; ?>
", "", "dialogWidth:18.5em; dialogHeight:17.5em; status:0");
<?php echo '
  	if (arr != null) 
  		formatC(\'forecolor\', arr);
  	else 
  		Composition.focus();
}

//Sets the background color.
function backColor() {
  	if (!validateMode()) return;
'; ?>

  	var arr = showModalDialog("<?php echo $this->_tpl_vars['umSelColorUrl']; ?>
", "", "dialogWidth:18.5em; dialogHeight:17.5em; status:0");
<?php echo '
/*
  	if (arr != null) formatC(\'backcolor\', arr);
*/  
  	if (arr != null){
	   	if( Composition.document.selection.type == "None" ){
	   		Composition.document.bgColor = arr;
	   		document.composeForm.bgcolor.value = arr;
	   	}
	   	else{
	  		formatC(\'backcolor\', arr);
	   	}
  	}
  	else 
  		Composition.focus()
}


function cleanHtml() {
  	var fonts = Composition.document.body.all.tags("FONT");
  	var curr;
  	
  	for (var i = fonts.length - 1; i >= 0; i--) {
    	curr = fonts[i];
    	if (curr.style.backgroundColor == "#ffffff") 
    		curr.outerHTML = curr.innerHTML;
  	}
}

function getPureHtml() {
  	var str = "";
  	var paras = Composition.document.body.all.tags("P");
  	if (paras.length > 0) {
    	for (var i = paras.length-1; i >= 0; i--) 
    		str = paras[i].innerHTML + "\\n" + str;
  	} 
  	else {
    	str = Composition.document.body.innerHTML;
  	}
  	return str;
}

Composition.document.open();
Composition.document.write(bodyTag);
Composition.document.close();
Composition.document.designMode="On";
						
bLoad = true;
// -->
</script>

'; ?>
