
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
			<td><?php echo $ort['geraeteanzahl']; ?></td>
			<td>
				<div class="btn-group btn-group-sm" role="group" aria-label="options">
				<a href="<?php echo site_url('geraete/index/'.$ort['oid']); ?>" class="btn btn-primary"><span class="iconify" data-icon="jam:plug" data-width="20" data-height="20"></span> Geräte</a>
				<a href="<?php echo site_url('geraete/geraete/'.$ort['oid']); ?>" class="btn btn-primary"><span class="iconify" data-icon="si-glyph:document-pdf" data-width="20" data-height="20"></span> Übersicht</a>
				<a href="<?php echo site_url('orte/edit/'.$ort['oid']); ?>" class="btn btn-secondary"><span class="iconify icon:typcn:edit icon-width:20 icon-height:20"></span> edit</a>
				<a href="<?php echo site_url('orte/delete/'.$ort['oid']); ?>" class="btn btn-danger"><span class="iconify icon:typcn:delete icon-width:20 icon-height:20"></span> delete</a>
				</div>
			</td>
		</tr>
		<?php
	}
}
?>

</tbody>
</table>
