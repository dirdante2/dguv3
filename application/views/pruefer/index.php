
<h1>Prüfer</h1>

<a href="<?php echo site_url('pruefer/edit'); ?>" class="btn btn-primary"><span class="iconify icon:typcn:document-add icon-width:20 icon-height:20"></span> Prüfer hinzufügen</a>
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

if(count($pruefer)==0) {

?>

<td colspan="4">Es sind noch keine Prüfer definiert.</td>

<?php

} else {
	foreach($pruefer as $p) {

		?>
		<tr>
			<td><?php echo $p['pid']; ?></td>
			<td><?php echo $p['name']; ?></td>
			<td><?php echo $p['beschreibung']; ?></td>
			<td>
				<a href="<?php echo site_url('pruefer/edit/'.$p['pid']); ?>" class="btn btn-secondary"><span class="iconify icon:typcn:edit icon-width:20 icon-height:20"></span></a>
				<a href="<?php echo site_url('pruefer/delete/'.$p['pid']); ?>" class="btn btn-danger"><span class="iconify icon:typcn:delete icon-width:20 icon-height:20"></span></a>
			</td>
		</tr>
		<?php
	}
}
?>

</tbody>
</table>
