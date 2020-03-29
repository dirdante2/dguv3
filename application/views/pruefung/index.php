<title><?php if($geraet) { echo $geraet['name']; } ?> Prüfung</title> 
<div class="row">
 <div class="col">
 	 
<?php
	if($geraet) {
?>
<h1>Prüfung für <?php echo $geraet['name']; ?></h1>

<table> <tr> 
<td><?php echo $geraet['name']; ?><?php if($geraet['verlaengerungskabel']=='1') { ?> | <?php echo $geraet['kabellaenge']; ?>m<?php	} ?>	
				</td>
		<tr>	<td><?php echo $geraet['hersteller']; ?></td></tr>
		<tr>	<td><?php echo $geraet['typ']; ?></td></tr>
		<tr>	<td><?php echo $geraet['seriennummer']; ?></td></tr>
		<tr>	<td><?php if($geraet['aktiv']=='0') { echo "nein"; } else { echo "ja"; } ?></td></tr>
		<tr>	<td><?php echo $geraet['beschreibung']; ?></td></tr>
			<!--<td><?php $blubb = new DateTime($geraet['hinzugefuegt']); echo $blubb->format('d.m.Y');  ?></td>-->
		<tr>	<td class="d-none"><?php if($geraet['nennspannung']=='0') { echo "-"; } else { echo $geraet['nennspannung'].'V'; } ?></td></tr>
		<tr>	<td class="d-none"><?php if($geraet['nennstrom']=='0.00') { echo "-"; } else { echo $geraet['nennstrom'].'A'; } ?></td></tr>
		<tr>	<td class="d-none"><?php if($geraet['leistung']=='0') { echo "-"; } else { echo $geraet['leistung'].'W'; } ?></td></tr>
		<tr>	<td><?php echo $geraet['schutzklasse']; ?></td></tr>
</table>
<?php
	} else {
?>
<h1>Prüfung</h1>
<?php
	}
?>
<div class="btn-group pull-right">
<a class="<?php if(!$geraet) { echo "d-none"; } ?> btn btn-primary" href="<?php echo site_url('pruefung'); ?>">Alle Prüfung auflisten</a>

<a href="<?php echo site_url('pruefung/edit/'.$geraet['gid']); ?>" class="btn btn-success"><span class="iconify icon:typcn:document-add icon-width:20 icon-height:20"></span> Neue Prüfung hinzufügen</a>
<button id="suche_abgelaufen" class="btn btn-danger filter">Prüfung Abgelaufen</button>
<button id="suche_baldabgelaufen" class="btn btn-warning filter">Prüfung bald Abgelaufen</button>
<button id="suche_inaktiv" class="btn btn-secondary filter">Gerät auser Betrieb</button>
<button id="suche_alle" class="btn btn-info filter">Alle</button>
</div>
</div>

</div>
<br>
<br>





<?php /*<a href="<?php echo site_url('pruefung/edit'); ?>" class="btn btn-primary">Neues Prüfung hinzufügen</a> */?>
<br>
<br>
<!-- table-hover table-bordered table-sm table-striped -->
<table class="table-hover table-bordered table-sm table-striped" id="table" style="width:100%">
<thead>
<tr>
	<th>ID</th>
	<th>Datum</th>
	<th>messgerät</th>
	<th>prüfer</th>
	<th>Sichtpruefung</th>
        <th>Schutzleiter</th>
        <th>Isowiderstand</th>
	<th>Schutzleiterstrom</th>
	<th>Beruehrstrom</th>
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

		?>
		<!--
		geräte inaktiv= rot  table-danger
		letzte prüfung älter als 1 jahr = gelb table-warning
		-->
		<tr class="">
			<td><?php echo $pr['gid']; ?></td>		
			<td><?php $blubb = new DateTime($pr['datum']); echo $pr['datum']?$blubb->format('d.m.Y'):'';  ?></td>
			<td><?php echo $pr['messgeraetname']; ?></td>	
                        <td><?php echo $pr['pruefername']; ?></td>
                        <td><?php if($pr['sichtpruefung']=='1') { echo "ja"; } else { echo "nein"; } ?></td>
                        <td><?php echo $pr['schutzleiter']; ?></td>
                        <td><?php echo $pr['isowiderstand']; ?></td>
			<td><?php echo $pr['schutzleiterstrom']; ?></td>
			<td><?php echo $pr['beruehrstrom']; ?></td>
			<td><?php if($pr['funktion']=='1') { echo "ja"; } else { echo "nein"; } ?></td>
                        <td><?php if($pr['bestanden']=='1') { echo "ok"; } ?></td>
                        <td><?php echo $pr['bemerkung']; ?></td>
			<td>
				<div class="btn-group btn-group-sm" role="group" aria-label="options">
					<a href="<?php echo site_url('pruefung/edit/'.$pr['gid']); ?>"><button type="button" class="btn btn-secondary btn-sm"><span class="iconify icon:typcn:edit icon-width:20 icon-height:20"></span></button></a>
				</div>
			</td>
		</tr>
		<?php
	}
}
?>

</tbody>
</table>

