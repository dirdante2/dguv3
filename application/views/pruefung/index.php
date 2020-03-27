<title>Prüfungen</title> 
<h1>Prüfungen</h1>

<?php /*<a href="<?php echo site_url('pruefung/edit'); ?>" class="btn btn-primary">Neues Prüfung hinzufügen</a> */?>
<br>
<br>
<!-- table-hover table-bordered table-sm table-striped -->
<table class="table-hover table-bordered table-sm table-striped" id="table" style="width:100%">
<thead>
<tr>
	<th>ID</th>
	<th>Datum</th>
	<th>MID</th>
	<th>PID</th>
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
	foreach($pruefung as $geraet) {

		?>
		<!--
		geräte inaktiv= rot  table-danger
		letzte prüfung älter als 1 jahr = gelb table-warning
		-->
		<tr class="">
			<td><?php echo $geraet['gid']; ?></td>		
			<td><?php $blubb = new DateTime($geraet['datum']); echo $geraet['datum']?$blubb->format('d.m.Y'):'';  ?></td>			
			<td><?php echo $geraet['mid']; ?></td>	
                        <td><?php echo $geraet['pid']; ?></td>
                        <td><?php if($geraet['sichtpruefung']=='1') { echo "ja"; } else { echo "nein"; } ?></td>
                        <td><?php echo $geraet['schutzleiter']; ?></td>
                        <td><?php echo $geraet['isowiderstand']; ?></td>
			<td><?php echo $geraet['schutzleiterstrom']; ?></td>
			<td><?php echo $geraet['beruehrstrom']; ?></td>
			<td><?php if($geraet['funktion']=='1') { echo "ja"; } else { echo "nein"; } ?></td>
                        <td><?php if($geraet['bestanden']=='1') { echo "ok"; } ?></td>
                        <td><?php echo $geraet['bemerkung']; ?></td>
			<td>
				<div class="btn-group btn-group-sm" role="group" aria-label="options">
					<a href="<?php echo site_url('pruefung/edit/'.$geraet['gid']); ?>"><button type="button" class="btn btn-secondary btn-sm"><span class="iconify icon:typcn:edit icon-width:20 icon-height:20"></span></button></a>
				</div>		
			</td>
		</tr>
		<?php
	}
}
?>

</tbody>
</table>

