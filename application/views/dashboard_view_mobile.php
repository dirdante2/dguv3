<h1>Willkommen!</h1>
Letzter login: <?php echo $this->session->userdata('lastseen');?>

<div class="row">


  <div class="card-header" id="collaps_header_statistik" style="width: 100%;">

	  <button class="btn" data-toggle="collapse" data-target="#collaps_statistik" aria-expanded="true" aria-controls="collaps_statistik">
	  <span class="iconify" data-icon="whh:statistics" data-width="50" data-height="50"></span> <b>Statistiken \o/</b>
	  </button>

  </div>
  <div class="collapse" id="collaps_statistik" style="width: 100%;">
	<div class="card card-body" >


	<div id="accordion" >
	<div class="card">
    <div class="card-header" id="haedinggeraete">
        <button class="btn" data-toggle="collapse" data-target="#collapsegeraete" aria-expanded="true" aria-controls="collapsegeraete">
		<span class="iconify" data-icon="jam:plug" data-width="50" data-height="50"></span> <b>Geräte</b>
        </button>

    </div>

    <div id="collapsegeraete" class="collapse show" aria-labelledby="haedinggeraete" data-parent="#accordion">
      <div class="card-body" >

	  <table class="table">

            <tbody>
                <tr>
                    <td>Gesamt</td>
                    <td>
                        <?php echo $geraete_count; ?>
                    </td>
                </tr>
                <tr>
                    <td style="text-indent:20px;">inaktiv</td>
                    <td>
                        <?php echo $geraete_aktiv_0; ?>
                    </td>
                </tr>
                <tr>
                    <td style="text-indent:20px;">aktiv</td>
                    <td>
                        <?php echo $geraete_aktiv_1; ?>
                    </td>
                </tr>


                <tr>
                    <td style="text-indent:30px;">ungeprüft</td>
                    <td>
                        <?php echo $geraete_count_geprueft_null; ?>
                    </td>
                </tr>

                <tr>
                    <td style="text-indent:30px;">geprüft</td>
                    <td>
                        <?php echo $geraete_count_geprueft; ?>
                    </td>
                </tr>
                <tr>
                    <td style="text-indent:40px;">durchgefallen</td>
                    <td>
                        <?php echo $geraete_count_geprueft_0; ?>
                    </td>
                </tr>
                <tr>
                    <td style="text-indent:40px;">bestanden</td>
                    <td>
                        <?php echo $geraete_count_geprueft_1; ?>
                    </td>
                </tr>
                <tr>
                    <td style="text-indent:50px;">abgelaufen</td>
                    <td>
                        <?php echo $geraete_count_geprueft_abgelaufen; ?>
                    </td>
                </tr>
                <tr>
                    <td style="text-indent:50px;">bald abgelaufen</td>
                    <td>
                        <?php echo $geraete_count_geprueft_baldabgelaufen; ?>
                    </td>
                </tr>



            </tbody>
        </table>

      </div>
    </div>
  </div>


  <div class="card">
    <div class="card-header" id="haedingpruefung">
        <button class="btn" data-toggle="collapse" data-target="#collapsepruefung" aria-expanded="true" aria-controls="collapsepruefung">
		<span class="iconify" data-icon="typcn:clipboard" data-width="50" data-height="50"></span> <b>Prüfung</b>
        </button>

    </div>

    <div id="collapsepruefung" class="collapse" aria-labelledby="haedingpruefung" data-parent="#accordion">
      <div class="card-body" >
	  <table class="table">
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
    </div>
  </div>

  <div class="card">
    <div class="card-header" id="haedingrest">
        <button class="btn" data-toggle="collapse" data-target="#collapserest" aria-expanded="true" aria-controls="collapserest">
		<span class="iconify" data-icon="vaadin:ellipsis-dots-h" data-width="50" data-height="50"></span>  <b>Rest</b>
        </button>

    </div>

    <div id="collapserest" class="collapse" aria-labelledby="haedingrest" data-parent="#accordion">
      <div class="card-body" >

	  <table class="table">
            <tbody>
                <tr>
                    <td><span class="iconify" data-icon="ic:baseline-account-circle" data-width="50" data-height="50"></span> Prüfer</td>
                    <td>
                        <?php echo $pruefer_count; ?>
                    </td>
                </tr>
                <tr>
                    <td><span class="iconify" data-icon="ic:outline-computer" data-width="50" data-height="50"></span> Messgeräte</td>
                    <td>
                        <?php echo $messgeraete_count; ?>
                    </td>
                </tr>
                <tr>
                    <td><span class="iconify" data-icon="ic:baseline-room" data-width="50" data-height="50"></span> Orte</td>
                    <td>
                        <?php echo $orte_count; ?>
                    </td>
                </tr>
                <tr>
                    <td><span class="iconify" data-icon="fa-solid:users" data-width="50" data-height="50"></span> Users</td>
                    <td>
                        <?php echo $users_count; ?>
                    </td>
                </tr>
                <tr>
                    <td><span class="iconify" data-icon="bx:bxs-business" data-width="50" data-height="50"></span> Firmen</td>
                    <td>
                        <?php echo $firmen_count; ?>
                    </td>
                </tr>
            </tbody>
        </table>

      </div>
    </div>
  </div>


  </div>

</div></div>



    <div class="col-auto" style="width: 100%;">
    <br>
        <b>Anschrift</b><br>
        <?php if ($this->session->userdata('firmaid')) { ?>
            <?php echo $firma['firma_name']; ?><br>
            <?php echo $firma['firma_strasse']; ?><br>
            <?php echo $firma['firma_plz']; ?> <?php echo $firma['firma_ort']; ?>
        <?php } else {?>
            keine Firma
        <?php } ?>
    </div>

	<div class="col" style="width: 100%;">
	<br><b>PDF Server</b><br>
		<div class="btn-group-vertical" role="group" style="width: 50%;">
		<?php
		$i=0;
		foreach($pdfserver as $serverurl) {
			$i++;?>

			<?php
			if($socket =@ fsockopen($serverurl[0], $serverurl[1], $errno, $errstr, 30)) { ?>
				 <a  href="http://<?php echo $serverurl[0].':'.$serverurl[1]; ?>" target="_blank" role="button" class="btn btn-sm btn-success">Server <?php echo $i; ?> OK</a>
				<?php fclose($socket);
				} else { ?>
				<!-- <button type="button" class="btn btn-sm btn-danger">Server <?php echo $i; ?> Error</button> -->
				<a  href="http://<?php echo $serverurl[0].':'.$serverurl[1]; ?>" target="_blank" role="button" class="btn btn-sm btn-danger">Server <?php echo $i; ?> Error</a>
				<?php } }?>

				</div>

    </div>

    <div class="col-auto" style="width: 100%; border: 0px solid #000;">
    <br>
        <b>Archiv</b>
		<?php if($cronjobs) { ?><br>

Fehlende Aufgaben: <span class="badge badge-danger"><?php echo $cronjobs; ?></span>
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
				<div class="row" style="width: 100%; border: 0px solid #000;">



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
					<span class="iconify" data-icon="whh:archive" data-width="50" data-height="50"></span>
					<!-- ordner und archiv existieren -->
					<a class="btn-lg btn-secondary" href="<?php echo site_url('dguv3/download_file/3/'.$file); ?>"><?php echo $file; ?> (<?php echo $fileSizeMB; ?>MB)</a>
					<!-- $file+1 wenn in vergangenheit neuerstellen -->
					<?php if($file >= $year) { ?>
					<a href="<?php echo site_url('dguv3/create_archiv/'.$file); ?>" class="btn-lg btn-warning">neu</a>
					<?php } ?>
					<?php echo $filetime; ?>
					<br><?php echo $details; ?>
					</div>
					<?php } else {?>
						<div class="col">
						<span class="iconify" data-icon="whh:archive" data-width="50" data-height="50"></span>
					<!--  ordner existiert aber kein zip archiv -->
					<a class="btn-lg btn-light" ><?php echo $file; ?></a> <a href="<?php echo site_url('dguv3/create_archiv/'.$file); ?>" class="btn-lg btn-success">neu</a>
				</div>


					<?php } ?>
				<br></div>
				<?php } ?>

				<?php  } ?>

				<?php } ?>

    </div>

</div>


