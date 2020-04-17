
<h1>Firmen</h1>

<a href="<?php echo site_url('firmen/edit'); ?>" class="btn btn-primary"><span class="iconify icon:typcn:document-add icon-width:20 icon-height:20"></span> Messgerät hinzufügen</a>
<br>
<br>

<table class="table" id="table">
<thead>
	<tr>
		<th>ID</th>
		<th>Name</th>
		<th>Beschreiung</th>
		<th>Aktion</th>
	</tr>
</thead>
<tbody>
<?php

if(count($firmen)==0) {

?>

<td colspan="4">Es sind noch keine Messgeräte definiert.</td>

<?php

} else {
	foreach($firmen as $firma) {

		?>
		<tr>
			<td><?php echo $firma['firma_id']; ?></td>
			<td><?php echo $firma['firma_name']; ?></td>
			<td><?php echo $firma['firma_beschreibung']; ?></td>
			<td>
				<a href="<?php echo site_url('firmen/edit/'.$firma['firma_id']); ?>" class="btn btn-secondary"><span class="iconify icon:typcn:edit icon-width:20 icon-height:20"></span></a>
				<a href="<?php echo site_url('firmen/delete/'.$firma['firma_id']); ?>" class="btn btn-danger"><span class="iconify icon:typcn:delete icon-width:20 icon-height:20"></span></a>
			</td>
		</tr>
		<?php
	}
}
?>

</tbody>
</table>
