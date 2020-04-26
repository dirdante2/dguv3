<title><?php if($geraet) { echo $geraet['name']; } ?> Prüfung</title>
<div class="row">
 <div class="col">


<h1>Prüfungen</h1>
<?php
	if($geraet) {
?>
<div class="row">
<div class="col-3">
						<b>Objekt</b><br><br>

						<table  class="table table-sm">
							<tr>
								<td>ID</td>
								<td><?php if($geraet['gid']==NULL) { echo "-"; } else { echo $geraet['gid']; } ?></td>
							</tr>
							<tr>
								<td>Ort</td>
								<td><?php if($geraet['ortsname']==NULL) { echo "-"; } else { echo $geraet['ortsname']; } ?></td>
							</tr>
							<tr>
								<td>Name</td>
								<td><?php if($geraet['name']==NULL) { echo "-"; } else { echo $geraet['name']; } ?></td>
							</tr>
							<tr>
								<td>Hersteller</td>
								<td><?php if($geraet['hersteller']==NULL) { echo "-"; } else { echo $geraet['hersteller']; } ?></td>
							</tr>
							<tr>
								<td>Typ</td>
								<td><?php if($geraet['typ']==NULL) { echo "-"; } else { echo $geraet['typ']; } ?></td>
							</tr>
							<tr>
								<td>Seriennummer</td>
								<td><?php if($geraet['seriennummer']==NULL) { echo "-"; } else { echo $geraet['seriennummer']; } ?></td>
							</tr>
							<tr>
								<td>Beschreibung</td>
								<td><?php if($geraet['beschreibung']==NULL) { echo "-"; } else { echo $geraet['beschreibung']; } ?></td>
							</tr>
						</table>
</div>
<div class="col-3">
						<b> </b><br><br><?php echo $geraet['schutzklasse']; ?>

						<table  class="table table-sm">
							<tr>
								<td>Nennspannung</td>
								<td><?php if($geraet['nennspannung']=='0' || $geraet['schutzklasse']=='4') { echo "-"; } else { echo $geraet['nennspannung'].'V'; } ?></td>
							</tr>
							<tr>
								<td>Nennstrom</td>
								<td><?php if($geraet['nennstrom']=='0.00') { echo "-"; } else { echo $geraet['nennstrom'].'A'; } ?></td>
							</tr>
							<tr>
								<td>Leistung</td>
								<td><?php if($geraet['leistung']=='0') { echo "-"; } else { echo $geraet['leistung'].'W'; } ?></td>
							</tr>
							<tr>
								<td>Schutzklasse</td>
								<td><?php if($geraet['schutzklasse']=='4') { echo "-"; } else { echo $geraet['schutzklasse']; } ?></td>
							</tr>
							<tr>
								<td>Verlängerungskabel</td>
								<td><?php if($geraet['verlaengerungskabel']=='0') { echo "-"; } else { echo $geraet['kabellaenge'].'m';} ?></td>
							</tr>
							<tr>
								<td>Aktiv</td>
								<td><?php if($geraet['aktiv']=='0') { echo "Nein"; } else { echo "Ja"; } ?></td>
							</tr>
						</table>
</div>
</div>



<div class="btn-group pull-right">
<a class="btn btn-primary" href="<?php echo site_url('pruefung'); ?>">Alle Prüfung auflisten</a>

<a href="<?php echo site_url('pruefung/new/'.$geraet['gid']); ?>" class="<?php if($this->session->userdata('level')>='3') { echo " disabled"; }?> btn btn-success"><span class="iconify icon:typcn:document-add icon-width:20 icon-height:20"></span> Neue Prüfung hinzufügen</a>
<a href="<?php echo site_url('geraete/edit/'.$geraet['gid']); ?>" class="<?php if($this->session->userdata('level')=='3') { echo " disabled"; }?>btn btn-secondary" ><span class="iconify icon:typcn:edit icon-width:20 icon-height:20"></span> Gerät bearbeiten</a>
<a href="<?php echo site_url('geraete/index/'.$geraet['oid']); ?>" class="btn btn-primary"><span class="iconify" data-icon="ic:baseline-room" data-width="20" data-height="20"></span> Ort anzeigen</a>
</div>
<?php
	}
?>
<br>


<br>

<div class="btn-group pull-right">
<button id="suche_abgelaufen" class="btn btn-warning filter">Prüfung Abgelaufen</button>
<button id="suche_baldabgelaufen" class="btn btn-info filter">Prüfung bald Abgelaufen</button>
<button id="suche_failed" class="btn btn-danger filter">Prüfung durchgefallen</button>
<button id="suche_alle" class="btn btn-info filter">Alle</button>
</div>
<br>
<br>

<?php /*<a href="<?php echo site_url('pruefung/edit'); ?>" class="btn btn-primary">Neues Prüfung hinzufügen</a> */?>

<!-- table-hover table-bordered table-sm table-striped -->
<table class="table-hover table-bordered table-sm table-striped" id="tabledesc" style="width:100%">
<thead>
<tr>

<th class="d-none">id</th>
<th class="d-none">status</th>
	<th class="<?php if($geraet) { echo "d-none"; } ?>">Gerät</th>
	<th>Datum</th>
	<th>Information</th>

	<th>Sichtpruefung</th>
        <th>Schutzleiter<br><0,3 Ohm</th>
        <th>Isowiderstand<br>>2,0 MOhm</th>
	<th>Schutzleiterstrom<br><0,5 mA</th>
	<th>Beruehrstrom<br><0,25 mA</th>
	<th>Funktion</th>
        <th>Bestanden</th>
	<th>Bemerkung</th>
	<th>Aktion</th>
</tr>
</thead>
<tbody>
<?php

if(count($pruefung)==0) {

?>

<td colspan="13">Es gibt noch keine Prüfungen.</td>

<?php

} else {
	foreach($pruefung as $pr) {

				$today = date("Y-m-d");
				$day     = $pr['datum'];
				$nextyear = strtotime('+'.$pruefungabgelaufen, strtotime($day));
				$nextyearfast = strtotime('+'.$pruefungbaldabgelaufen, strtotime($day));
				$nextyear = date("Y-m-d", $nextyear);
				$nextyearfast = date("Y-m-d", $nextyearfast);


		?>








		<!--
		prüfung durchgefallen = 2 rot  table-danger
		prüfung abgelaufen = gelb 2  table-warning
		letzte prüfung älter als 3 jahr = blue table-info


		-->
		<tr class="<?php if($pr['bestanden']=='0') { echo "table-danger"; } elseif ($nextyear < $today)  { echo "table-warning"; } elseif ($nextyearfast < $today) { echo "table-info"; } ?>">
		<td class="d-none"><?php echo $pr['pruefungid']; ?></td>

		<td class="d-none"><?php if($pr['bestanden']=='0') { echo "4"; } elseif ($nextyear < $today)  { echo "2"; } elseif ($nextyearfast < $today) { echo "3"; } ?></td>
			<td class="<?php if($geraet) { echo "d-none"; } ?>"><?php echo $pr['geraetename']; ?>(<?php echo $pr['schutzklasse']; ?>)</td>
			<td><?php $blubb = new DateTime($pr['datum']); echo $pr['datum']?$blubb->format('d.m.Y'):'';  ?></td>
			<td><?php echo $pr['pruefername']; ?><br>(<?php echo $pr['messgeraetname']; ?>)</td>

                        <td><?php if($pr['sichtpruefung']=='1') { echo "ja"; } else { echo "nein"; } ?> <?php if($pr['sichtpruefung']=='1') {?> <span class="iconify" data-icon="el:ok" style="color: green;" data-width="15" data-height="15"></span><?php	} else {?> <span class="iconify" data-icon="oi:circle-x" style="color: red;" data-width="15" data-height="15"></span><?php } ?></td>

                        <td><?php if($pr['schutzleiter']===NULL) { echo "-"; } else { echo $pr['schutzleiter']; } ?> <?php $y = $pr['RPEmax']; if($pr['schutzleiter']===NULL) { echo ""; } elseif($pr['schutzleiter'] <= $y)  {?> <span class="iconify" data-icon="el:ok" style="color: green;" data-width="15" data-height="15"></span><?php	} else {?> <span class="iconify" data-icon="oi:circle-x" style="color: red;" data-width="15" data-height="15"></span><?php } ?><?php if($pr['RPEmax']===NULL) { echo ""; } else { echo '('.$pr['RPEmax'].')'; } ?></td>

                        <td><?php if($pr['isowiderstand']===NULL) { echo "-"; } else { echo $pr['isowiderstand']; } ?> <?php $y = 2.0; if($pr['isowiderstand']===NULL) { echo ""; } elseif($pr['isowiderstand'] >= $y) {?> <span class="iconify" data-icon="el:ok" style="color: green;" data-width="15" data-height="15"></span><?php	} else {?> <span class="iconify" data-icon="oi:circle-x" style="color: red;" data-width="15" data-height="15"></span><?php } ?></td>
												<td><?php if($pr['schutzleiterstrom']===NULL) { echo "-"; } else { echo $pr['schutzleiterstrom']; } ?> <?php $y = 0.5; if($pr['schutzleiterstrom']===NULL) { echo ""; } elseif($pr['schutzleiterstrom'] <= $y) {?> <span class="iconify" data-icon="el:ok" style="color: green;" data-width="15" data-height="15"></span><?php	} else {?> <span class="iconify" data-icon="oi:circle-x" style="color: red;" data-width="15" data-height="15"></span><?php } ?></td>
												<td><?php if($pr['beruehrstrom']===NULL) { echo "-"; } else { echo $pr['beruehrstrom']; } ?> <?php $y = 0.25; if($pr['beruehrstrom']===NULL) { echo ""; } elseif($pr['beruehrstrom'] <= $y) {?> <span class="iconify" data-icon="el:ok" style="color: green;" data-width="15" data-height="15"></span><?php	} else {?> <span class="iconify" data-icon="oi:circle-x" style="color: red;" data-width="15" data-height="15"></span><?php } ?></td>

												<td><?php if($pr['funktion']=='1') { echo "ja"; } else { echo "nein"; } ?> <?php if($pr['funktion']=='1') {?> <span class="iconify" data-icon="el:ok" style="color: green;" data-width="15" data-height="15"></span><?php	} else {?> <span class="iconify" data-icon="oi:circle-x" style="color: red;" data-width="15" data-height="15"></span><?php } ?></td>
                        <td><?php if($pr['bestanden']=='1') { echo "ja"; } else { echo "nein"; } ?> <?php if($pr['bestanden']=='1') {?> <span class="iconify" data-icon="el:ok" style="color: green;" data-width="15" data-height="15"></span><?php	} else {?> <span class="iconify" data-icon="oi:circle-x" style="color: red;" data-width="15" data-height="15"></span><?php } ?></td>
                        <td><?php echo $pr['bemerkung']; ?></td>


			<td>
				<div class="btn-group btn-group-sm" role="group" aria-label="options">
					<!--<a href="<?php echo site_url('pruefung/protokoll/'.$pr['pruefungid']); ?>" class="btn btn-primary btn-sm"><span class="iconify" data-icon="si-glyph:document-pdf" data-width="20" data-height="20"></span> PDF</a>
					-->
					<?php
						$timestamp = strtotime($pr['datum']);
						$year = date("Y", $timestamp);
						$prdatum = date("Y-m-d", $timestamp);
						?>





						<a href="<?php echo base_url('pdf/'.$year.'/'.$pr['ortsname'].'/GID'.$pr['gid'].'_'.$pr['geraetename'].'_PID'.$pr['pruefungid'].'_'.$prdatum.'.pdf');?>" target="_blank" class="btn btn-primary<?php if (!file_exists('pdf/'.$year.'/'.$pr['ortsname'].'/GID'.$pr['gid'].'_'.$pr['geraetename'].'_PID'.$pr['pruefungid'].'_'.$prdatum.'.pdf')) { echo " disabled"; } ?>"><span class="iconify" data-icon="si-glyph:document-pdf" data-width="20" data-height="20"></span> Übersicht</a>



					<a href="<?php echo site_url('geraete/index/'.$pr['oid']); ?>" class="<?php if($geraet) { echo "d-none"; } ?> btn btn-primary btn-sm"><span class="iconify" data-icon="ic:baseline-room" data-width="20" data-height="20"></span> Ort</a>
					<a href="<?php echo site_url('pruefung/index/'.$pr['gid']); ?>" class="<?php if($geraet) { echo "d-none"; } ?> btn btn-primary btn-sm"><span class="iconify icon:jam:plug icon-width:20 icon-height:20"></span> Gerät</a>
					<a href="<?php echo site_url('pruefung/edit/'.$pr['pruefungid']); ?>" class="<?php if($this->session->userdata('level')>='3') { echo " disabled"; }?> btn btn-secondary btn-sm"><span class="iconify icon:typcn:edit icon-width:20 icon-height:20"></span> edit</a>
				<a href="<?php echo site_url('pruefung/delete/'.$pr['pruefungid']); ?>" class="<?php if($this->session->userdata('level')>='3') { echo " disabled"; }?> btn btn-danger btn-sm"><span class="iconify icon:typcn:delete icon-width:20 icon-height:20"></span> delete</a>
				</div>
			</td>
		</tr>
		<?php
	}
}
?>

</tbody>
</table>
<div class="row">
	<div class="col">

						<br><br>
<table  class="table" style="width:700px">
	<thead>
		<th>Messung</th>
		<th>Grenzwerte</th>
	</thead>
		<tbody>
							<tr>
								<td>Schutzleiterwiderstand</td>
								<td>Max 0.3 Ohm (Pro Meter Kabel +0.1 Ohm aber Max 1.0 Ohm)</td>
							</tr>
							<tr>
								<td>Isolationsprüfung 500V</td>
								<td>Min 2,00 MOhm</td>
							</tr>
							<tr>
								<td>Schutzleiterstrom</td>
								<td>Max 0,50 mA</td>
							</tr>
							<tr>
								<td>Berührungstrom</td>
								<td>Max 0,25 mA</td>
							</tr>
						</tbody>
						</table>

</div>
</div>
