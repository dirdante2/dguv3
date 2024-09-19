<h1>Willkommen!</h1>

<!-- Letzter login: <?php echo $userdata['user_lastlogin']; ?> -->
Letzter login: <?php echo $this->session->userdata('lastlogin'); ?>
<br>
<br>
<h2><span class="iconify" data-icon="whh:statistics" data-width="30" data-height="30"></span> Statistiken \o/</h2>
<br>
<div class="row">
    <div class="col" style="width: 100%; max-width: 300px;">

<!-- Tabelle für Gesamt -->
<table class="table">
    <thead>
        <th><span class="iconify" data-icon="jam:plug" data-width="20" data-height="20"></span> Geräte</th>
        
    </thead>
  
    <tbody>
    <tr>
    <td>

<!-- Tabelle für Aktiv/Inaktiv (Unterpunkt von Gesamt) -->
<table class="table table-sm" >
<thead class="thead-light">
        <th><span class="iconify" data-icon="fluent-mdl2:total" data-width="20" data-height="20"></span> Gesamt</th>
        <th><?php echo $geraete_count; ?></th>
    </thead>
    <tbody>
        <tr>
            <td><span class="iconify" data-icon="mdi:stop-pause-outline" data-width="20" data-height="20"></span> Inaktiv</td>
            <td><?php echo $geraete_aktiv_0; ?></td>
        </tr>
        <tr>
            <td><span class="iconify" data-icon="octicon:play-24" data-width="20" data-height="20"></span> Aktiv</td>
            <td><?php echo $geraete_aktiv_1; ?></td>
        </tr>
    </tbody>
</table>

<!-- Tabelle für Geprüft/Ungeprüft (Unterpunkt von Aktiv) -->
<table class="table table-sm" >
<thead class="thead-light">
        <th><span class="iconify" data-icon="octicon:play-24" data-width="20" data-height="20"></span> Aktiv</th>
        <th><?php echo $geraete_aktiv_1; ?></th>
      
    </thead>
    <tbody>
        <tr>
            <td><span class="iconify" data-icon="fluent:checkbox-unchecked-20-regular" data-width="20" data-height="20"></span> Ungeprüft</td>
            <td><?php echo $geraete_count_geprueft_null; ?></td>
        </tr>
        <tr>
            <td><span class="iconify" data-icon="fluent:checkbox-checked-20-regular" data-width="20" data-height="20"></span> Geprüft</td>
            <td><?php echo $geraete_count_geprueft; ?></td>
        </tr>
    </tbody>
</table>

<!-- Tabelle für Durchgefallen/Bestanden (Unterpunkt von Geprüft) -->
<table class="table table-sm" >
<thead class="thead-light">
        <th><span class="iconify" data-icon="fluent:checkbox-checked-20-regular" data-width="20" data-height="20"></span> Geprüft</th>
        <th><?php echo $geraete_count_geprueft; ?></th>
       
    </thead>
    <tbody>
        <tr>
            <td><span class="iconify" data-icon="mdi:stop-alert-outline" data-width="20" data-height="20"></span> Durchgefallen</td>
            <td><?php echo $geraete_count_geprueft_0; ?></td>
        </tr>
        <tr>
            <td><span class="iconify" data-icon="clarity:success-standard-line" data-width="20" data-height="20"></span> Bestanden</td>
            <td><?php echo $geraete_count_geprueft_1; ?></td>
        </tr>
    </tbody>
</table>

<!-- Tabelle für Abgelaufen/Bald abgelaufen (Unterpunkt von Bestanden) -->
<table class="table table-sm" >
<thead class="thead-light">
        <th><span class="iconify" data-icon="clarity:success-standard-line" data-width="20" data-height="20"></span> Bestanden</th>
        <th><?php echo $geraete_count_geprueft_1; ?></th>
        
    </thead>
    <tbody>
        <tr>
            <td><span class="iconify" data-icon="mdi:stopwatch-remove-outline" data-width="20" data-height="20"></span> Abgelaufen</td>
            <td><?php echo $geraete_count_geprueft_abgelaufen; ?></td>
        </tr>
        <tr>
            <td><span class="iconify" data-icon="pajamas:expire" data-width="20" data-height="20"></span> Bald abgelaufen</td>
            <td><?php echo $geraete_count_geprueft_baldabgelaufen; ?></td>
        </tr>
        <tr>
            <td><span class="iconify" data-icon="fluent-mdl2:waitlist-confirm" data-width="20" data-height="20"></span> aktuell</td>
            <td><?php echo $geraete_count_geprueft_aktuell; ?></td>
        </tr>
    </tbody>
</table>

</td>
        </tr>
</tbody>
</table>





    </div>

    <div class="col" style="width: 100%; max-width: 300px;">

        <table class="table">
            <thead>
                <th><span class="iconify icon:typcn:clipboard icon-width:20 icon-height:20"></span> Prüfungen</th>
                <th></th>
            </thead>
            <tbody>
                <tr>
                    <td>Gesamt</td>
                    <td>
                        <?php echo $pruefung_count; ?>
                    </td>
                </tr>
                <tr>
                    <td style="text-indent:20px;">bestanden</td>
                    <td>
                        <?php echo $pruefung_bestanden_1; ?>
                    </td>
                </tr>
                <tr>
                    <td style="text-indent:20px;">fehlgeschlagen</td>
                    <td>
                        <?php echo $pruefung_bestanden_0; ?>
                    </td>
                </tr>

            </tbody>
        </table>

    </div>

    <div class="col" style="width: 100%; max-width: 300px;">

        <table class="table">
            <thead>
                <th><span class="iconify" data-icon="vaadin:ellipsis-dots-h" data-width="20" data-height="20"></span> Rest</th>
                <th></th>
            </thead>
            <tbody>
                <tr>
                    <td><span class="iconify" data-icon="ic:baseline-account-circle" data-width="20" data-height="20"></span> Prüfer</td>
                    <td>
                        <?php echo $pruefer_count; ?>
                    </td>
                </tr>
                <tr>
                    <td><span class="iconify" data-icon="ic:outline-computer" data-width="20" data-height="20"></span> Messgeräte</td>
                    <td>
                        <?php echo $messgeraete_count; ?>
                    </td>
                </tr>
                <tr>
                    <td><span class="iconify" data-icon="ic:baseline-room" data-width="20" data-height="20"></span> Orte</td>
                    <td>
                        <?php echo $orte_count; ?>
                    </td>
                </tr>
                <tr>
                    <td><span class="iconify" data-icon="fa-solid:users" data-width="20" data-height="20"></span> Users</td>
                    <td>
                        <?php echo $users_count; ?>
                    </td>
                </tr>
                <tr>
                    <td><span class="iconify" data-icon="bx:bxs-business" data-width="20" data-height="20"></span> Firmen</td>
                    <td>
                        <?php echo $firmen_count; ?>
                    </td>
                </tr>
            </tbody>
        </table>

    </div>



    <div class="col" style="width: 100%; max-width: 200px;">
        <h4>Anschrift</h4><br>
        <?php if ($this->session->userdata('firmaid')) { ?>
            <?php echo $firma['firma_name']; ?><br>
            <?php echo $firma['firma_strasse']; ?><br>
            <?php echo $firma['firma_plz']; ?> <?php echo $firma['firma_ort']; ?>
        <?php } else {?>
            keine Firma
        <?php } ?>
    </div>

    <div class="col" style="width: 100%; max-width: 200px;">
        <h4>Fehlerquote</h4><br>
        
        <?php 
        if($fehlerquote['prozent']<='2'){
            $fehlerquotecolor="text-success";
            } elseif($fehlerquote['prozent']<='10') {
                $fehlerquotecolor="text-warning";
            } else {
                    $fehlerquotecolor="text-danger";
                }
                    
                    ?>

       <b class="<?php echo $fehlerquotecolor; ?>">Prozent: <?php echo $fehlerquote['prozent']; ?>%</b><br>

        seit: <?php echo $fehlerquote['zeitraum']; ?><br>
        Geprüft: <?php echo $fehlerquote['geprüft']; ?><br>
        Bestanden: <?php echo $fehlerquote['anzahlbestanden']; ?><br>
        Durchgefallen: <?php echo $fehlerquote['anzahldurchgefallen']; ?><br>
        

    </div>



	<div class="col" style="width: 100%; max-width: 160px;">
        <h4>PDF Server</h4><br>
		<div class="btn-group-vertical" role="group" style="width: 100%;">
		<?php
		$i=0;
		foreach($pdfserver as $serverurl) {
			$i++;?>

			<?php

$ch = curl_init();
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //Set curl to return the data instead of printing it to the browser.
		curl_setopt($ch, CURLOPT_URL, $serverurl.'/pdfgen/ping');
		$data = curl_exec($ch);
        curl_close($ch);
        if(strpos($data, 'pong!')){




			 ?>
				 <a  href="<?php echo $serverurl; ?>" target="_blank" role="button" class="btn btn-sm btn-success">Server <?php echo $i; ?> OK</a>
				<?php
				} else { ?>
				<!-- <button type="button" class="btn btn-sm btn-danger">Server <?php echo $i; ?> Error</button> -->
				<a  href="<?php echo $serverurl; ?>" target="_blank" role="button" class="btn btn-sm btn-danger">Server <?php echo $i; ?> Error</a>
				<?php } }?>

				</div>

                </div>
                </div> 
                <div class="row" style="white-space: nowrap; border: 0px solid #000;">

    <div class="col" style="width: 100px; white-space: nowrap; border: 0px solid #000;max-width: 500px;">
        <h4>Archiv</h4>
		<?php if($cronjobs) { ?>

			Fehlende Aufgaben: <span class="badge badge-danger"><?php echo $cronjobs; ?></span><br>
            <a href="<?php echo site_url('cron/create_pdf_3/'); ?>" class="btn-sm btn-warning">PDF erstellen</a><br>
		<?php } ?>
		<br>
		<?php

         $root = 'pdf/'.$this->session->userdata('firmaid').'/';
        if (!$this->session->userdata('firmaid')) { ?>
            keine Firma

        <?php } elseif (!file_exists($root)) { ?>
           keine pdf erstellt
        <?php } else {
			//print_r($archiv_ordner);
			$year=date('Y');
			?>






            <?php foreach($archiv_ordner as $file) {

                if (is_dir('pdf/'.$firma['firmen_firmaid'].'/'.$file)) {

                ?>
				<div class="row" style="width: 270px; white-space: nowrap; border: 0px solid #000;">



                    <?php if (file_exists('pdf/'.$firma['firmen_firmaid'].'/'.$file.'.zip')) {
						$details = file_get_contents('pdf/'.$firma['firmen_firmaid'].'/'.$file.'.txt', true);

                    $filetime= date("d.m.y|H:i:s", filemtime('pdf/'.$firma['firmen_firmaid'].'/'.$file.'.zip'));
					//Get the file size in bytes.
					$fileSizeBytes = filesize('pdf/'.$firma['firmen_firmaid'].'/'.$file.'.zip');

					//Convert the bytes into MB.
					$fileSizeMB = ($fileSizeBytes / 1024 / 1024);

					//269,708 bytes is 0.2572135925293 MB

					//Format it so that only 2 decimal points are displayed.
					$fileSizeMB = number_format($fileSizeMB, 2);



                    ?>
					<div class="col">
					<span class="iconify" data-icon="whh:archive" data-width="20" data-height="20"></span>
                    <!-- ordner und archiv existieren -->
                    <a class="btn-sm btn-secondary" href="<?php echo site_url('dguv3/download_file/'.$file.'/3'); ?>"><?php echo $file; ?> (<?php echo $fileSizeMB; ?>MB)</a>
					<!-- $file+1 wenn in vergangenheit neuerstellen -->
					<?php if($file >= $year) { ?>
					<a href="<?php echo site_url('dguv3/create_archiv/'.$file); ?>" class="btn-sm btn-warning">neu</a>
					<?php } ?>
					<?php echo $filetime; ?>
                    <br><?php echo $details; ?>
					</div>
					<?php } else {?>
						<div class="col">
						<span class="iconify" data-icon="whh:archive" data-width="20" data-height="20"></span>
                    <!--  ordner existiert aber kein zip archiv -->
                    <a class="btn-sm btn-light" ><?php echo $file; ?></a> <a href="<?php echo site_url('dguv3/create_archiv/'.$file); ?>" class="btn-sm btn-success">neu</a>
</div>


                    <?php } ?>
                <br></div><br>
                <?php } ?>

<?php  } ?>

        <?php } ?>

    </div>
    <div class="col" style="width: 100%; max-width: 570px;border: 0px solid #000;">
        <h4>Letzte Aufgaben</h4><br>
        <?php  
        $details_cronjob = file_get_contents('application/cron_log/cron_cronjob.php', true);
        
echo $details_cronjob;
        
        ?>
            
    </div>

</div>


