
<h1>Messgeräte</h1>

<a href="<?php echo site_url('messgeraete/edit'); ?>" class="btn btn-primary">Messgerät hinzufügen</a>
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

if(count($messgeraete)==0) {

?>

<td colspan="4">Es sind noch keine Messgeräte definiert.</td>

<?php

} else {
	foreach($messgeraete as $messgeraet) {

		?>
		<tr>
			<td><?php echo $messgeraet['mid']; ?></td>
			<td><?php echo $messgeraet['name']; ?></td>
			<td><?php echo $messgeraet['beschreibung']; ?></td>
			<td>
				<a href="<?php echo site_url('messgeraete/edit/'.$messgeraet['mid']); ?>" class="btn btn-secondary">bearbeiten</a>
				<a href="<?php echo site_url('messgeraete/delete/'.$messgeraet['mid']); ?>" class="btn btn-danger">löschen</a>
			</td>
		</tr>
		<?php
	}
}
?>

</tbody>
</table>
