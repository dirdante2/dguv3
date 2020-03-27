
<h1>Orte</h1>

<a href="<?php echo site_url('orte/edit'); ?>" class="btn btn-primary"><span class="iconify icon:typcn:document-add icon-width:20 icon-height:20"></span> Ort hinzufügen</a>
<br>
<br>
<table class="table" id="table" style="width:100%">
<thead>
<tr>
	<th>ID</th>
	<th>Name</th>
	<th>Beschreiung</th>
	<th>Geräte</th>
	<th>Aktion</th>
</tr>
</thead>
<tbody>
<?php

if(count($orte)==0) {

?>

<td colspan="4">Es sind noch keine Orte definiert.</td>

<?php

} else {
	foreach($orte as $ort) {

		?>
		<tr>
			<td><?php echo $ort['oid']; ?></td>
			<td><?php echo $ort['name']; ?></td>
			<td><?php echo $ort['beschreibung']; ?></td>
			<td>xxx?</td>
			<td>
				<a href="<?php echo site_url('geraete/index/'.$ort['oid']); ?>" class="btn btn-primary"><span class="iconify" data-icon="jam:plug" data-width="20" data-height="20"></span></a>
				<a href="<?php echo site_url('geraete/geraete/'.$ort['oid']); ?>" class="btn btn-success"><span class="iconify icon:fa-solid:car-side icon-width:20 icon-height:20"></span></a>
				<a href="<?php echo site_url('orte/edit/'.$ort['oid']); ?>" class="btn btn-secondary"><span class="iconify icon:typcn:edit icon-width:20 icon-height:20"></span></a>
				<a href="<?php echo site_url('orte/delete/'.$ort['oid']); ?>" class="btn btn-danger"><span class="iconify icon:typcn:delete icon-width:20 icon-height:20"></span></a>
			</td>
		</tr>
		<?php
	}
}
?>

</tbody>
</table>
