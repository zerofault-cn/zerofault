<?php
header("content-type: text/xml");
echo read_file(XML_FILE_FOLDER.$_REQUEST['filename']);
exit;
?>