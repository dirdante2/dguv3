
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
<h2>andere links</h2>
<?php $year=date('Y'); ?>
<a href="<?php echo site_url('dguv3/create_archiv/'.$year); ?>" class="btn btn-primary">zip archiv <?php $year=date('Y'); echo $year; ?> neu</a><br>
<a href="<?php echo site_url('cron/create_pdf_3/'); ?>" class="btn btn-primary">cronjob PDF erstellen</a><br>
<a href="<?php echo site_url('cron/create_pdf_1/'); ?>" class="btn btn-primary">alle Übersicht PDF erstellen</a><br>
<a href="<?php echo site_url('cron/create_pdf_2/'); ?>" class="btn btn-primary">alle protokolle PDF erstellen</a><br>