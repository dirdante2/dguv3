
<title><?php if($ort) { echo $ort['name']; } ?> Geräte</title> 
<div class="row">
 <div class="col">
 	 
<?php
	if($ort) {
?>
<h1>Geräte für <?php echo $ort['name']; ?></h1>
<h3><?php echo $ort['beschreibung']; ?></h3>


<?php
	} else {
?>
<h1>Geräte</h1>
<?php
	}
?>
<div class="btn-group pull-right">
<a class="<?php if(!$ort) { echo "d-none"; } ?> btn btn-primary" href="<?php echo site_url('geraete'); ?>">Alle Geräte auflisten</a>

<a href="<?php echo site_url('geraete/edit'); ?>" class="btn btn-success">Neues Gerät hinzufügen</a>
<button id="suche_abgelaufen" class="btn btn-danger filter">Prüfung Abgelaufen</button>
<button id="suche_baldabgelaufen" class="btn btn-warning filter">Prüfung bald Abgelaufen</button>
<button id="suche_inaktiv" class="btn btn-secondary filter">Gerät auser Betrieb</button>
<button id="suche_alle" class="btn btn-info filter">Alle</button>
</div>
</div>

</div>
<br>
<br>



<!-- table-hover table-bordered table-sm table-striped -->

<table class="table-hover table-bordered table-sm table-striped" id="table" style="width:100%">
<thead>
<tr>
	<th>ID</th>
	<th class="">status</th>
	
	<th class="<?php if($ort) { echo "d-none"; } ?>">Ort</th>
	<th>Name</th>
	<th>Hersteller</th>
	<th>Typ</th>
	<th>Seriennummer</th>
	<th>aktiv</th>
	<th>Beschreibung</th>
	<!--<th>hinzugefügt am</th>-->
	<th class="d-none">U</th>
	<th class="d-none">I</th>
	<th class="d-none">P</th>
	<th>Schutzklasse</th>
	<!--<th>Verlängerungskabel</th>-->
	<th>Prüfungen</th>
	<th>Aktion</th>
</tr>
</thead>
<tbody>
<?php

if(count($geraete)==0) {

?>

<td colspan="15">Es sind noch keine Geräte vorhanden.</td>

<?php

} else {
	foreach($geraete as $geraet) {

		?>
			<!--
						<td class="d-none">
						
						sorting col
						status
							inaktiv=1 gray (aktiv==0)
							geprüft nein=2 red
							geprüft abgelaufen=3 red
							geprüft bald abgelaufen=4 yellow
							ok=5

						-->
						
		<tr class="<?php if($geraet['aktiv']=='0') { echo "table-secondary"; } elseif($geraet['verlaengerungskabel']=='1')  { echo "table-danger"; } else { echo "4"; }?>">
			<td><?php echo $geraet['gid']; ?></td>
			
			<td class=""><?php if($geraet['aktiv']=='0') { echo "1"; } elseif($geraet['verlaengerungskabel']=='1')  { echo "3"; } else { echo "4"; }?></td>
			
			
				<td class="<?php if($ort) { echo "d-none"; } ?>"><?php echo $geraet['ortsname']; ?></td>
				
			<td><?php echo $geraet['name']; ?><?php if($geraet['verlaengerungskabel']=='1') { ?> | <?php echo $geraet['kabellaenge']; ?>m</td><?php	} ?>	
				</td>
			<td><?php echo $geraet['hersteller']; ?></td>
			<td><?php echo $geraet['typ']; ?></td>
			<td><?php echo $geraet['seriennummer']; ?></td>
			<td><?php if($geraet['aktiv']=='0') { echo "nein"; } else { echo "ja"; } ?></td>
			<td><?php echo $geraet['beschreibung']; ?></td>
			<!--<td><?php $blubb = new DateTime($geraet['hinzugefuegt']); echo $blubb->format('d.m.Y');  ?></td>-->
			<td class="d-none"><?php if($geraet['nennspannung']=='0') { echo "-"; } else { echo $geraet['nennspannung'].'V'; } ?></td>
			<td class="d-none"><?php if($geraet['nennstrom']=='0.00') { echo "-"; } else { echo $geraet['nennstrom'].'A'; } ?></td>
			<td class="d-none"><?php if($geraet['leistung']=='0') { echo "-"; } else { echo $geraet['leistung'].'W'; } ?></td>
			<td><?php echo $geraet['schutzklasse']; ?></td>
			<!--<td><?php if($geraet['verlaengerungskabel']=='0') { ?>  <?php } else { ?><?php echo $geraet['kabellaenge']; ?>m</td><?php	} ?>-->
			<td>letzte (anzahl)</td>
			<td>
				<div class="btn-group btn-group-sm" role="group" aria-label="options">
					<a href="#"><button type="button" class="btn btn-success btn-sm">Prüfungen</button></a>
					<a href="<?php echo site_url('geraete/pruefung/') ?>"><button type="button" class="btn btn-info btn-sm">Protokoll</button></a>
					<a href="<?php echo site_url('geraete/edit/'.$geraet['gid']); ?>"><button type="button" class="btn btn-secondary btn-sm">bearbeiten</button></a>
					<a href="<?php echo site_url('geraete/delete/'.$geraet['gid']); ?>"><button type="button" class="btn btn-danger btn-sm">löschen</button></a>
				</div>
			<!--<a href="<?php echo site_url('geraete/edit/'.$geraet['gid']); ?>">bearbeiten</a> | <a href="<?php echo site_url('geraete/delete/'.$geraet['gid']); ?>">löschen</a>-->
		
			</td>
		</tr>
		<?php
	}
}
?>

</tbody>
</table>

