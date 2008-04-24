<html>
<head>
<title>BF2 Name Hack Buster</title>

<link href="style.css" rel="stylesheet" type="text/css" />

<script language="JavaScript" src="js/soundmanager2.js"></script>
<script language="JavaScript">
<!--

function updateStatus(text) {
    statusArea = document.getElementById('statusArea');

    statusArea.innerHTML = text;
}

var pleasePlay = 0;
var volume = <?php echo ((isset($_REQUEST['volume']))?$_REQUEST['volume']:"70"); ?>;
soundManager.url = 'soundmanager2.swf'; // override default SWF url
soundManager.debugMode = false;
soundManager.consoleOnly = false;

soundManager.onload = function() {
    soundManager.createSound({
        id: 'siren',
        url: 'sounds/siren.mp3',
        duration: 2000});
    soundManager.createSound({
        id: 'air_alert',
        url: 'sounds/air_alert.mp3',
        duration: 2000});
    if (pleasePlay == 1) {
        playsound();
    }
}

function playsound() {
    soundManager.play('siren', {volume:volume});
    soundManager.play('air_alert', {volume:volume});
}

function setVol(vol) {
    volume = vol;
}

-->
</script>
</head>
<body>
<!-- div for sound manager -->
<div id="container"></div>
<?php include_once("custom_banner.php"); ?>


<table border="0" width="100%">
<tr>
<td><a href="index.php">Generate Report</a></td>
<td><a href="saved.php">Saved Reports</a></td>
<td><a href="shame.php">Wall of Shame</a></td>
<td><a href="about.php">About</a></td>
</tr>
</table>
