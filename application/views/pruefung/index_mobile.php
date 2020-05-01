<title><?php if($geraet) { echo $geraet['name']; } ?> Prüfung</title>
<div class="row">
 <div class="col">


<h1>Prüfungen</h1>
<?php
	if($geraet) {
?>
<div class="row" style="width:100%">
<div class="col-7">
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
<div class="col-5">
						<b> </b><br><br>

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



<div class="btn-group" role="group" aria-label="options" style="width:100%">
<a class="btn btn-primary" href="<?php echo site_url('pruefung'); ?>">Alle Prüfung auflisten</a>

<a href="<?php echo site_url('pruefung/new/'.$geraet['gid']); ?>" class="<?php if($this->session->userdata('level')>='3') { echo " disabled"; }?> btn btn-success"><span class="iconify icon:typcn:document-add icon-width:50 icon-height:50"></span> Neue Prüfung hinzufügen</a>
<a href="<?php echo site_url('geraete/edit/'.$geraet['gid']); ?>" class="<?php if($this->session->userdata('level')=='3') { echo " disabled"; }?>btn btn-secondary" ><span class="iconify icon:typcn:edit icon-width:50 icon-height:50"></span> Gerät bearbeiten</a>
<a href="<?php echo site_url('geraete/index/'.$geraet['oid']); ?>" class="btn btn-primary"><span class="iconify" data-icon="ic:baseline-room" data-width="50" data-height="50"></span> Ort anzeigen</a>
</div>
<?php	} ?>
</div>
</div>


<br>


<div class="btn-group btn-group-sm" role="group" aria-label="options" style="width:100%">
<button class="btn btn-outline-dark" type="button" data-toggle="collapse" data-target="#suche_ok" aria-expanded="false" aria-controls="suche_ok">ok</button>
<button class="btn btn-info" type="button" data-toggle="collapse" data-target="#suche_baldabgelaufen" aria-expanded="false" aria-controls="suche_baldabgelaufen">Bald Abgelaufen</button>
<button class="btn btn-warning" type="button" data-toggle="collapse" data-target="#suche_abgelaufen" aria-expanded="false" aria-controls="suche_abgelaufen">Abgelaufen</button>
<button class="btn btn-danger" type="button" data-toggle="collapse" data-target="#suche_failed" aria-expanded="false" aria-controls="suche_failed">durchgefallen</button>


</div>
<br><br>
<!-- table-hover table-bordered table-sm table-striped -->

<!-- <?php echo $page_total_rows; ?> total rows<br>
<?php echo $page_show_rows; ?> show rows<br>
<?php echo $page_pages; ?> pages<br>
<?php echo $page_pageid; ?> pageid<br>
<?php echo $page_offset; ?> offset<br> -->
<?php
if(!$geraet) {
	$gid=0;
} else {
	$gid=$geraet['gid'];
}

if($page_total_rows<=$page_show_rows) {

	$page_show_rows=$page_total_rows;
}

//wenn pages mehr als 5 dann kürze pagination ein
if($page_pages>=5) {
	if($page_pageid>=3) {
		$page_start=$page_pageid -3;
		$page_end=$page_pageid +4;
	} else {
		$page_start=0;
		$page_end=7;
	}
} else {
	$page_start=0;
	$page_end=$page_pages;
}
//wenn ende pagination erreicht wird
if($page_pages>=5 && $page_pageid+4>= $page_pages) {
$page_end=$page_pages;
$page_start=$page_end -7;
}

?>
<div class="" style="text-align: center;border: 0px solid #343a40;" role="group" aria-label="pagination">


<a class="btn btn-outline-dark <?php if($page_pageid==0) { echo 'disabled';} ?>" type="button" href="<?php echo base_url(); ?>pruefung/pagination/<?php echo $gid; ?>/0">start</a>
<?php
$i = $page_start;
while($i < $page_end) { ?>


<a class="btn <?php if($i==$page_pageid) { echo 'btn-dark disabled active';} else { echo 'btn-outline-dark';} ?>" type="button" href="<?php echo base_url(); ?>pruefung/pagination/<?php echo $gid; ?>/<?php echo $i; ?>" tabindex="0"><?php echo $i +1; ?></a>

<?php

//echo "$i, ";

$i++;
}
?>
<a class="btn btn-outline-dark <?php if($page_pageid+1==$page_pages) { echo 'disabled';} ?>" type="button" href="<?php echo base_url(); ?>pruefung/pagination/<?php echo $gid; ?>/<?php echo $page_pages-1; ?>">ende</a>
<br>zeige <?php echo $page_show_rows; ?> von <?php echo $page_total_rows; ?> auf <?php echo $page_pages; ?> Seiten<br>

</div>

<?php

if(count($pruefung)==0) {

?>

keine geräte vorhanden

<?php

} else { ?>

<div id="accordion" class="scroll" style="width:100%">

<?php	foreach($pruefung as $pr) {

				$today = date("Y-m-d");
				$day     = $pr['datum'];
				$nextyear = strtotime('+'.$pruefungabgelaufen, strtotime($day));
				$nextyearfast = strtotime('+'.$pruefungbaldabgelaufen, strtotime($day));
				$nextyear = date("Y-m-d", $nextyear);
				$nextyearfast = date("Y-m-d", $nextyearfast);
				if(!$geraet) {

					if($pr['schutzklasse']==1) {
						$schutzklasseicon='mdi:roman-numeral-1';

					} elseif($pr['schutzklasse']==2) {
						$schutzklasseicon='mdi:roman-numeral-2';

					} elseif($pr['schutzklasse']==3) {
						$schutzklasseicon='mdi:roman-numeral-3';

					} elseif($pr['schutzklasse']==4) {
						$schutzklasseicon='medical-icon:i-stairs';

					} else {
						$schutzklasseicon='';

					}
				} else {$schutzklasseicon='';}

		?>
		<div class="card collapse multi-collapse show" style="border: 1px solid #343a40;" id='<?php if($pr['bestanden']=='0')  { echo "suche_failed"; } elseif ($nextyear < $today)  { echo "suche_abgelaufen"; } elseif ($nextyearfast < $today) { echo "suche_baldabgelaufen"; } else { echo 'suche_ok';} ?>'>


		<div id="heading<?php echo $pr['pruefungid']; ?>" class="card-header <?php if($pr['aktiv']=='0') { echo "bg-secondary"; } elseif ($pr['bestanden']=='0')  { echo "bg-danger"; } elseif ($nextyear < $today)  { echo "bg-warning"; } elseif ($nextyearfast < $today) { echo "bg-info"; }?>" data-toggle="collapse" data-target="#pruefung<?php echo $pr['pruefungid']; ?>" aria-expanded="true" aria-controls="pruefung<?php echo $pr['pruefungid']; ?>">

			<h4 class="mb-0" >
			<div class="row">
			<div class="col-6 text-left" id="<?php echo $pr['pruefungid']; ?>"><?php  echo $pr['name']; ?> <span class="iconify" data-icon="<?php echo $schutzklasseicon; ?>" data-inline="false" data-width="50" data-height="50"></span></div><div class="col-6 text-right" id="<?php echo $pr['pruefungid']; ?>"><?php if($this->session->userdata('level')=='1'){?><?php echo $pr['firma_name']; ?><?php } ?></div>
			</div>

			</h4>
			</div>

			<div id="pruefung<?php echo $pr['pruefungid']; ?>" class="collapse" aria-labelledby="heading<?php echo $pr['pruefungid']; ?>" data-parent="#accordion">
			<div class="card-body bg-light">
				<div class="row" id="<?php echo $pr['pruefungid']; ?>">



				<div class="col-6">Name:</div><div class="col-4" style="white-space:nowrap;"><?php echo $pr['geraetename']; ?></div>
				<?php if($pr['geraetekabellaenge']!='0') { ?>
				<div class="col-6">Länge:</div><div class="col-4" style="white-space:nowrap;"><?php echo $pr['geraetekabellaenge']; ?></div>
				<?php } ?>
				<div class="col-6">Schutzklasse:</div><div class="col-4" style="white-space:nowrap;"><?php echo $pr['schutzklasse']; ?></span></div>
				<div class="col-6">Datum:</div><div class="col-4" style="white-space:nowrap;"><?php $blubb = new DateTime($pr['datum']); echo $pr['datum']?$blubb->format('d.m.Y'):'';  ?></div>
				<div class="col-6">Prüfer:</div><div class="col-4" style="white-space:nowrap;"><?php echo $pr['pruefername']; ?></div>
				<div class="col-6">Messgerät:</div><div class="col-4" style="white-space:nowrap;"><?php echo $pr['messgeraetname']; ?></div>
				<div class="col-6">Sichtprüfung:</div><div class="col-4" style="white-space:nowrap;">
					<?php if($pr['sichtpruefung']=='1') { echo "ja"; } else { echo "nein"; } ?> <?php if($pr['sichtpruefung']=='1') {?> <span class="iconify" data-icon="el:ok" style="color: green;" data-width="40" data-height="40"></span><?php	} else {?> <span class="iconify" data-icon="oi:circle-x" style="color: red;" data-width="40" data-height="40"></span><?php } ?>
				</div>
				<div class="col-6">Schutzleiter: <?php if($pr['RPEmax']===NULL) { echo ""; } else { echo '(<'.$pr['RPEmax'].'Ohm)'; } ?></div><div class="col-4" style="white-space:nowrap;">
					<?php if($pr['schutzleiter']===NULL) { echo "-"; } else { echo $pr['schutzleiter']; } ?> <?php $y = $pr['RPEmax']; if($pr['schutzleiter']===NULL) { echo ""; } elseif($pr['schutzleiter'] <= $y)  {?> <span class="iconify" data-icon="el:ok" style="color: green;" data-width="40" data-height="40"></span><?php	} else {?> <span class="iconify" data-icon="oi:circle-x" style="color: red;" data-width="40" data-height="40"></span><?php } ?>

				</div>
				<div class="col-6">Isowiderstand: <?php if($pr['isowiderstand']!==NULL) { echo '(>2.0MOhm)'; } ?></div><div class="col-4" style="white-space:nowrap;">
				<?php if($pr['isowiderstand']===NULL) { echo "-"; } else { echo $pr['isowiderstand']; } ?> <?php $y = 2.0; if($pr['isowiderstand']===NULL) { echo ""; } elseif($pr['isowiderstand'] >= $y) {?> <span class="iconify" data-icon="el:ok" style="color: green;" data-width="40" data-height="40"></span><?php	} else {?> <span class="iconify" data-icon="oi:circle-x" style="color: red;" data-width="40" data-height="40"></span><?php } ?>
			</div>
				<div class="col-6">Schutzleiterstrom: <?php if($pr['schutzleiterstrom']!==NULL) { echo '(<0.5mA)'; } ?></div><div class="col-4" style="white-space:nowrap;">
				<?php if($pr['schutzleiterstrom']===NULL) { echo "-"; } else { echo $pr['schutzleiterstrom']; } ?> <?php $y = 0.5; if($pr['schutzleiterstrom']===NULL) { echo ""; } elseif($pr['schutzleiterstrom'] <= $y) {?> <span class="iconify" data-icon="el:ok" style="color: green;" data-width="40" data-height="40"></span><?php	} else {?> <span class="iconify" data-icon="oi:circle-x" style="color: red;" data-width="40" data-height="40"></span><?php } ?>
</div>
				<div class="col-6">Berührstrom: <?php if($pr['beruehrstrom']!==NULL) { echo '(<0.25mA)'; } ?></div><div class="col-4" style="white-space:nowrap;">
				<?php if($pr['beruehrstrom']===NULL) { echo "-"; } else { echo $pr['beruehrstrom']; } ?> <?php $y = 0.25; if($pr['beruehrstrom']===NULL) { echo ""; } elseif($pr['beruehrstrom'] <= $y) {?> <span class="iconify" data-icon="el:ok" style="color: green;" data-width="40" data-height="40"></span><?php	} else {?> <span class="iconify" data-icon="oi:circle-x" style="color: red;" data-width="40" data-height="40"></span><?php } ?>
</div>
				<div class="col-6">Funktion:</div><div class="col-4" style="white-space:nowrap;">
				<?php if($pr['funktion']=='1') { echo "ja"; } else { echo "nein"; } ?> <?php if($pr['funktion']=='1') {?> <span class="iconify" data-icon="el:ok" style="color: green;" data-width="40" data-height="40"></span><?php	} else {?> <span class="iconify" data-icon="oi:circle-x" style="color: red;" data-width="40" data-height="40"></span><?php } ?>
</div>
				<div class="col-6">Bestanden:</div><div class="col-4" style="white-space:nowrap;">
				<?php if($pr['bestanden']=='1') { echo "ja"; } else { echo "nein"; } ?> <?php if($pr['bestanden']=='1') {?> <span class="iconify" data-icon="el:ok" style="color: green;" data-width="40" data-height="40"></span><?php	} else {?> <span class="iconify" data-icon="oi:circle-x" style="color: red;" data-width="40" data-height="40"></span><?php } ?>
</div>
				<div class="col-6">Bemerkung:</div><div class="col-4" style="white-space:nowrap;">
				<?php echo $pr['bemerkung']; ?>
</div>










				</div>

					<div id="1" class="text-right btn-group" role="group" aria-label="options" style="width:100%">

					<?php
						$timestamp = strtotime($pr['datum']);
						$year = date("Y", $timestamp);
						$prdatum = date("Y-m-d", $timestamp);
						?>


					<a href="<?php echo base_url('orte/download_file/2/'.$pr['pruefungid']);?>" target="_blank" class="btn btn-primary <?php if (!file_exists($pdf_data[ $pr['pruefungid']])) { echo "disabled"; } ?>"><span class="iconify" data-icon="si-glyph:document-pdf" data-width="50" data-height="50"></span> Protokoll</a>

					<a href="<?php echo site_url('geraete/index/'.$pr['oid']); ?>" class="<?php if($geraet) { echo "d-none"; } ?> btn btn-primary"><span class="iconify" data-icon="ic:baseline-room" data-width="50" data-height="50"></span> Ort</a>
					<a href="<?php echo site_url('pruefung/index/'.$pr['gid']); ?>" class="<?php if($geraet) { echo "d-none"; } ?> btn btn-primary"><span class="iconify" data-icon="jam:plug" data-inline="false" data-width="50" data-height="50"></span> Gerät</a>
					<a href="<?php echo site_url('pruefung/edit/'.$pr['pruefungid']); ?>" class="<?php if($this->session->userdata('level')>='3') { echo " disabled"; }?> btn btn-secondary"><span class="iconify" data-icon="typcn:edit" data-inline="false" data-width="50" data-height="50" ></span> edit</a>
				<a href="<?php echo site_url('pruefung/delete/'.$pr['pruefungid']); ?>" class="<?php if($this->session->userdata('level')>='3') { echo " disabled"; }?> btn btn-danger"><span class="iconify" data-icon="typcn:delete" data-inline="false" data-width="50" data-height="50">></span> delete</a>
						</div>


						</div>
					</div>
					</div>



		<?php
	} ?>
	</div>
<?php }
?>
</div>
