

<?php
	if($ort) {
?>
<h1>Geräte für <?php echo $ort['name']; ?></h1>
<h3><?php echo $ort['beschreibung']; ?></h3>
<a class="btn btn-primary" href="<?php echo site_url('geraete'); ?>">Alle Geräte auflisten</a>
<?php
	} else {
?>
<h1>Geräte</h1>
<?php
	}
?>

<a href="<?php echo site_url('geraete/edit'); ?>" class="btn btn-primary">Neues Gerät hinzufügen</a>
<br>
<br>
<!-- table-hover table-bordered table-sm table-striped -->

<table class="table-hover table-bordered table-sm table-striped" id="table" style="width:100%">
<thead>
<tr>
	<th>ID</th>
	<?php	if(!$ort) {?>	<th>Ort</th><?php	}?>
	<th>Name</th>
	<th>Hersteller</th>
	<th>Typ</th>
	<th>Seriennummer</th>
	<th>aktiv</th>
	<th>Beschreibung</th>
	<!--<th>hinzugefügt am</th>-->
	<th>U</th>
	<th>I</th>
	<th>P</th>
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
		geräte inaktiv= rot  table-danger
		letzte prüfung älter als 1 jahr = gelb table-warning
		-->
		<tr class="<?php if($geraet['aktiv']=='0') { echo "table-danger"; } ?>">
			
			<td><?php echo $geraet['gid']; ?></td>
				<?php
	if(!$ort) {
?>
			
			<td><?php echo $geraet['ortsname']; ?></td>
			
			<?php
	}
?>
			<td><?php echo $geraet['name']; ?><?php if($geraet['verlaengerungskabel']=='1') { ?> | <?php echo $geraet['kabellaenge']; ?>m</td><?php	} ?>	
				</td>
			<td><?php echo $geraet['hersteller']; ?></td>
			<td><?php echo $geraet['typ']; ?></td>
			<td><?php echo $geraet['seriennummer']; ?></td>
			<td><?php if($geraet['aktiv']=='0') { echo "nein"; } else { echo "ja"; } ?></td>
			<td><?php echo $geraet['beschreibung']; ?></td>
			<!--<td><?php $blubb = new DateTime($geraet['hinzugefuegt']); echo $blubb->format('d.m.Y');  ?></td>-->
			<td><?php if($geraet['nennspannung']=='') { echo "-"; } else { echo $geraet['nennspannung'].'V'; } ?></td>
			<td><?php if($geraet['nennstrom']=='') { echo "-"; } else { echo $geraet['nennstrom'].'A'; } ?></td>
			<td><?php if($geraet['leistung']=='') { echo "-"; } else { echo $geraet['leistung'].'W'; } ?></td>
			<td><?php echo $geraet['schutzklasse']; ?></td>
			<!--<td><?php if($geraet['verlaengerungskabel']=='0') { ?>  <?php } else { ?><?php echo $geraet['kabellaenge']; ?>m</td><?php	} ?>-->
			<td>letzte (anzahl)</td>
			<td>
				<div class="btn-group btn-group-sm" role="group" aria-label="options">
					<a href="#"><button type="button" class="btn btn-success btn-sm">Prüfungen</button></a>
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

