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
	foreach($pruefung as $pr) {

		?>
		<!--
		geräte inaktiv= rot  table-danger
		letzte prüfung älter als 1 jahr = gelb table-warning
		-->
		<tr class="">
			<td><?php echo $pr['gid']; ?></td>		
			<td><?php $blubb = new DateTime($pr['datum']); echo $pr['datum']?$blubb->format('d.m.Y'):'';  ?></td>
			<td><?php echo $pr['mid']; ?></td>	
                        <td><?php echo $pr['pid']; ?></td>
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

