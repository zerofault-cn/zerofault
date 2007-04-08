<?php
/**
* UploadProgressMeter.class.php - Upload progress Meter widget
*
* Copyright (C) 2005  Joshua Eichorn  This program is free software; you can 
* redistribute it and/or modify it under the terms of the GNU General Public 
* License as published by the Free Software Foundation; either version 2 of 
* the License, or (at your option) any later version.  This program is 
* distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; 
* without even the implied warranty of MERCHANTABILITY or FITNESS FOR A 
* PARTICULAR PURPOSE.  See the GNU General Public License for more details.  
* You should have received a copy of the GNU General Public License along 
* with this program; if not, write to the Free Software Foundation, Inc., 
* 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
* 
*
* @author       Joshua Eichorn <josh@bluga.net>
* @copyright    Joshua Eichorn (c)2005
* @link         http://bluga.net/projects/upload_progress_meter
* @version      0.1
* @filesource
*/

/**
* Render out a file input box with javascript tied to it for a status bar
*
*/
class UploadProgressMeter {
    var $name = 'upload';
    var $targetIframeName = false;
    var $progressId = false;
    var $submitName = false;
    var $uploadId = false;
    var $maxFileSize = 8388608;



    var $formExtra = 'onsubmit="UploadProgressMeter_Start(this); return true;" target="[frame_name]"';

    var $formIframe = "<iframe id='[frame_name]' name='[frame_name]' src='' style='width:1px;height:1px;border:0'></iframe>";

    var $progressBarDiv = '<div id="[id]" style="display: none" class="progressBar"><div class="background"><div class="bar">&nbsp;</div></div><div class="message"></div></div></div><script type="text/javascript">UploadProgressMeter_Register(\'[id]\',\'[upload_id]\')</script>';

    var $includeJs = '<script src="UploadProgressMeter.js" type="text/javascript"></script>';

    var $input = '<input id="[name]" name="[submit_name]" size="30" type="file">';

    var $hidden = '<input type=hidden name=UPLOAD_IDENTIFIER value="[id]">';

    function UploadProgressMeter() {
        $this->hidden .= '<input type="hidden" name="MAX_FILE_SIZE" value="'.$this->maxFileSize.'" />';
    }
    
    /**
     * Checks if a file has been submited, useful if your uploading to the same page that is generating output
     */
    function uploadComplete() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            return true;
        }
        return false;
    }

    /**
     * Output html to the hidden iframe that will update the final status of the widget
     *
     * Checks for errors, if there is one outputs an error message
     */
    function finalStatus() {
        $error = false;
        if (count($_FILES) == 0) {
            $error = "Upload Failed, Unknown Error<br>";
        }
        foreach($_FILES as $file) {
            switch($file['error']) {
                case 0: // OK
                    break;
                case 1: // exceded max post size
                case 2: // exceded max file size
                    $error = "Upload Failed, file to big";
                    break;
                case 3: // partial file
                    $error = "Upload Failed";
                    break;
                case 4: // no file
                    $error = "Upload Failed, no file was uploaded";
                    break;
                case 6: // no tmp dir
                case 7: // can't write to tmp
                    $error = "Upload Failed, internal error";
                    break;
            }
        }
        if ($this->progressId == false) {
            $this->progressId = "progress_$this->name";
        }
        if ($error === false) {
            $error = "Upload Complete";
        }
        
        return "<html><head><script type='text/javascript'>function update() { window.parent.uploadComplete('$this->progressId','".
            addslashes($error). "'); }</script></head><body onload='update()'></body></html>";
    }


    function render() {

        if ($this->submitName == false) {
            $this->submitName = $this->name;
        }
        if ($this->progressId == false) {
            $this->progressId = "progress_$this->name";
        }
    
        $ret = str_replace(array('[name]','[submit_name]'),array($this->name,$this->submitName),$this->input);
        return $ret;

    }

    function renderIncludeJs() {
        return $this->includeJs;
    }

    function renderFormExtra() {
        if ($this->targetIframeName == false) {
            $this->targetIframeName = "target_$this->name";
        }
        return str_replace(array('[name]','[frame_name]'),array($this->name,$this->targetIframeName),$this->formExtra);
    }

    function renderIframe() {
        return str_replace(array('[frame_name]'),array($this->targetIframeName),$this->formIframe);
    }

    function renderProgressBar() {
        return str_replace(array('[id]','[upload_id]'),array($this->progressId,$this->getUploadId()),$this->progressBarDiv);
    }

    function renderHidden() {
        $ret = $this->renderIframe();
        $ret .= $this->renderHiddenFields();
        return $ret;
    }

    function renderHiddenFields() {
        return str_replace('[id]',$this->getUploadId(),$this->hidden);
    }
    

    function getUploadId() {
        if ($this->uploadId == false) {
            $this->uploadId = rand() . '.' . time();
        }
        return $this->uploadId;
    }
}
?>