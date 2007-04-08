<?php
include 'UploadProgressMeter.class.php';

$fileWidget = new UploadProgressMeter();

if ($fileWidget->uploadComplete()) {
    // output javascript to the iframe to send a final status to the main window
    // this will catch error conditions
    echo $fileWidget->finalStatus();

    // move the file(s) where they need to go

    exit;
}
?>
<html>
<head>
<title>PHP AJAX Upload Progress Meter Demo</title>
<script type='text/javascript' src='demoserver.php?client=main,request,httpclient,dispatcher,json,util'></script>
<script type='text/javascript' src='demoserver.php?stub=UploadProgressMeterStatus'></script>
    <?php echo $fileWidget->renderIncludeJs(); ?>

    <style>
    .progressBar {
        position: relative;
        padding: 2px;
        width: 300px;
        height: 40px;
        font-size: 14px;
    }
    .progressBar .background {
        border: solid 1px black;
        width: 270px;
        height: 20px;
    }
    .progressBar .bar {
        position: relative;
        background-color: blue;
        width: 0px;
        height: 20px;
    }
    </style>
</head>
<body>
<form action="demo.php" enctype="multipart/form-data" method="post" <?php echo $fileWidget->renderFormExtra(); ?>>
<?php echo $fileWidget->renderHidden(); ?>

<label>Select File: </label>
<div>
<?php echo $fileWidget->render(); ?>
<?php echo $fileWidget->renderProgressBar(); ?>
</div>

<input type="submit" value="Upload File">
</form>

<p>For most connections 250K files should be good demo, files > 8meg will fail without an error message due to my PHP config, larger files work if you have PHP setup to work with larger files.</p>
<p>This code has been tested on Firefox 1.5, but should work on any modern browser if you find any bugs post them on the blog or the wiki</p>
<p><a href="http://bluga.net/projects/uploadProgressMeter/">Project Home Page</a></p>
<p><a href="http://wiki.bluga.net/HTML_AJAX/ProgressMeter">Wiki</a></p>
<p><a href="http://blog.joshuaeichorn.com/archives/2005/05/01/ajax-file-upload-progress/">Read the blog posting about it (This relates to the older version but has comments about the new as well)</a></p>

<pre id="debug"></pre>
</body>
</html>