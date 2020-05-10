
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
