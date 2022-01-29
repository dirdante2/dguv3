
<h1>Logs</h1>

<br><br>
<h2>Private Log</h2>
<div class="pre-scrollable text-nowrap" style="max-height: 75vh">
<?php
foreach($privatelog_files as $logfile){
	arsort($logfile);
	foreach($logfile as $line){
	echo $line;
	echo '<br>';
	}
} ?></div>
<br>
<h2>Error Log</h2>

<div class="pre-scrollable text-nowrap" style="max-height: 75vh">
<?php
foreach($errorlog_files as $logfile){
	arsort($logfile);
	foreach($logfile as $line){
	echo $line;
	echo '<br>';
	}
} ?></div>
<br>
<h2>cron Log</h2>

<div class="pre-scrollable text-nowrap" style="max-height: 75vh">
<?php
foreach($cron_files as $logfile){
	arsort($logfile);
	foreach($logfile as $line){
	echo $line;
	echo '<br>';
	}
} 
$details_cronjob = file_get_contents('application/cron_log/cron_cronjob.php', true);
$details_protokoll_cronjob = file_get_contents('application/cron_log/protokoll_cronjob.php', true);
$details_uebersicht_cronjob = file_get_contents('application/cron_log/uebersicht_cronjob.php', true);
echo 'cron 3 änderungen<br>';
echo $details_cronjob;
echo '<br> cron 1 alle Übersicht<br>';
echo $details_uebersicht_cronjob;
echo '<br>cron 2 alle Protokolle<br>';
echo $details_protokoll_cronjob;

?></div>
<br>
