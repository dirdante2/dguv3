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
								<td><?php echo $geraet['gid']; ?></td>
							</tr>
							<tr>
								<td>Ort</td>
								<td><?php echo $geraet['ortsname']; ?></td>
							</tr>
							<tr>
								<td>Name</td>
								<td><?php echo $geraet['name']; ?></td>
							</tr>
							<tr>
								<td>Hersteller</td>
								<td><?php echo $geraet['hersteller']; ?></td>
							</tr>
							<tr>
								<td>Typ</td>
								<td><?php echo $geraet['typ']; ?></td>
							</tr>
							<tr>
								<td>Seriennummer</td>
								<td><?php echo $geraet['seriennummer']; ?></td>
							</tr>
							<tr>
								<td>Beschreibung</td>
								<td><?php echo $geraet['beschreibung']; ?></td>
							</tr>
						</table>
</div>
<div class="col-3">
						<b> </b><br><br>
<table  class="table table-sm">
							<tr>
								<td>Nennspannung</td>
								<td><?php if($geraet['nennspannung']=='0') { echo "-"; } else { echo $geraet['nennspannung'].'V'; } ?></td>
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
								<td><?php echo $geraet['schutzklasse']; ?></td>
							</tr>
							<tr>
								<td>Verlaengerungskabel</td>
								<td><?php if($geraet['verlaengerungskabel']=='0') { ?>  <?php } else { ?><?php echo $geraet['kabellaenge']; ?>m</td><?php	} ?></td>
							</tr>
							<tr>
								<td>Aktiv</td>
								<td><?php if($geraet['aktiv']=='0') { echo "nein"; } else { echo "ja"; } ?></td>
							</tr>
						
						</table>
</div>
</div>


<?php
	}
?>
<div class="btn-group pull-right">
<a class="<?php if(!$geraet) { echo "d-none"; } ?> btn btn-primary" href="<?php echo site_url('pruefung'); ?>">Alle Prüfung auflisten</a>

<a href="<?php if($geraet) { echo site_url('pruefung/new/'.$geraet['gid']); } ?>" class="<?php if(!$geraet) { echo "d-none"; } ?> btn btn-success"><span class="iconify icon:typcn:document-add icon-width:20 icon-height:20"></span> Neue Prüfung hinzufügen</a>
<a class="<?php if(!$geraet) { echo "d-none"; } ?> btn btn-secondary" href="<?php echo site_url('geraete/edit/'.$geraet['gid']); ?>"><span class="iconify icon:typcn:edit icon-width:20 icon-height:20"></span> Gerät bearbeiten</a>
<a class="<?php if(!$geraet) { echo "d-none"; } ?> btn btn-primary" href="<?php echo site_url('geraete/index/'.$geraet['oid']); ?>"><span class="iconify" data-icon="ic:baseline-room" data-width="20" data-height="20"></span> Ort anzeigen</a>
</div>



<br>

<div class="btn-group pull-right">
<button id="suche_abgelaufen" class="btn btn-warning filter">Prüfung Abgelaufen</button>
<button id="suche_baldabgelaufen" class="btn btn-info filter">Prüfung bald Abgelaufen</button>
<button id="suche_failed" class="btn btn-danger filter">Prüfung durchgefallen</button>
<button id="suche_alle" class="btn btn-Secondary filter">Alle</button>
</div>
<br>
<br>

<?php /*<a href="<?php echo site_url('pruefung/edit'); ?>" class="btn btn-primary">Neues Prüfung hinzufügen</a> */?>

<!-- table-hover table-bordered table-sm table-striped -->
<table class="table-hover table-bordered table-sm table-striped" id="table" style="width:100%">
<thead>
<tr>
<th class="d-none">id</th>
<th class="d-none">status</th>
	<th>GID</th>
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
		
				$today = date("Y-m");
				$day     = $pr['datum'];
				$nextyear = strtotime("+12 month", strtotime($day));
				$nextyearfast = strtotime("+10 month", strtotime($day));
				$nextyear = date("Y-m", $nextyear);
				$nextyearfast = date("Y-m", $nextyearfast);
				

		?>
		
					

		
		
		
		
		
		<!--
		prüfung durchgefallen = 2 rot  table-danger
		prüfung abgelaufen = gelb 2  table-warning
		letzte prüfung älter als 3 jahr = blue table-info
		
		
		-->
		<tr class="<?php if($pr['bestanden']=='0') { echo "table-danger"; } elseif ($nextyear < $today)  { echo "table-warning"; } elseif ($nextyearfast < $today) { echo "table-info"; } ?>">
		<td><?php echo $pr['pruefungid']; ?></td>
		
		<td class="d-none"><?php if($pr['bestanden']=='0') { echo "4"; } elseif ($nextyear < $today)  { echo "2"; } elseif ($nextyearfast < $today) { echo "3"; } ?></td>
			<td><?php echo $pr['gid']; ?></td>
			<td><?php $blubb = new DateTime($pr['datum']); echo $pr['datum']?$blubb->format('d.m.Y'):'';  ?>
									

				
				
				</td>
			<td><?php echo $pr['pruefername']; ?><br>(<?php echo $pr['messgeraetname']; ?>)</td>	
                   
                        <td><?php if($pr['sichtpruefung']=='1') { echo "ja"; } else { echo "nein"; } ?></td>
                        <td><?php if($pr['schutzleiter']===NULL) { echo "-"; } else { echo $pr['schutzleiter'].'Ohm'; } ?></td>
                        <td><?php if($pr['isowiderstand']===NULL) { echo "-"; } else { echo $pr['isowiderstand'].'MOhm'; } ?></td>
			<td><?php if($pr['schutzleiterstrom']===NULL) { echo "-"; } else { echo $pr['schutzleiterstrom'].'mA'; } ?></td>
			<td><?php if($pr['beruehrstrom']===NULL) { echo "-"; } else { echo $pr['beruehrstrom'].'mA'; } ?></td>
			<td><?php if($pr['funktion']=='1') { echo "ja"; } else { echo "nein"; } ?></td>
                        <td><?php if($pr['bestanden']=='1') { echo "ok"; } else { echo "nein"; } ?></td>
                        <td><?php echo $pr['bemerkung']; ?></td>
			<td>
				<div class="btn-group btn-group-sm" role="group" aria-label="options">
					<a href="<?php echo site_url('geraete/index/'.$pr['oid']); ?>" class="btn btn-primary"><span class="iconify" data-icon="jam:plug" data-width="20" data-height="20"></span> Ort</a>
					<a href="<?php echo site_url('pruefung/index/'.$pr['gid']); ?>"><button type="button" class="btn btn-success btn-sm"><span class="iconify icon:typcn:clipboard icon-width:20 icon-height:20"></span> Prüfung</button></a>
					<a href="<?php echo site_url('pruefung/edit/'.$pr['pruefungid']); ?>"><button type="button" class="btn btn-secondary btn-sm"><span class="iconify icon:typcn:edit icon-width:20 icon-height:20"></span> edit</button></a>
				<a href="<?php echo site_url('pruefung/delete/'.$pr['pruefungid']); ?>"><button type="button" class="btn btn-danger btn-sm"><span class="iconify icon:typcn:delete icon-width:20 icon-height:20"></span> delete</button></a>
				</div>
			</td>
		</tr>
		<?php
	}
}
?>

</tbody>
</table>
