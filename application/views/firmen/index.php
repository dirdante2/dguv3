
<h1>Firmen</h1>

<a href="<?php echo site_url('firmen/edit'); ?>" class="btn btn-primary"><span class="iconify icon:typcn:document-add icon-width:20 icon-height:20"></span> Firma hinzufügen</a>
<br>
<br>

<table class="table" id="table">
<thead>
	<tr>
		<th>ID</th>
		<th>Name</th>
		<th>Anschfrift</th>
		<th>Beschreiung</th>
		<th>Aktion</th>
	</tr>
</thead>
<tbody>
<?php

if(count($firmen)==0) {

?>

<td colspan="4">Es sind noch keine Firmen definiert.</td>

<?php

} else {
	foreach($firmen as $firma) {

		?>
		<tr>
			<td><?php echo $firma['firmen_firmaid']; ?></td>
			<td><?php echo $firma['firma_name']; ?></td>
			<td><?php echo $firma['firma_strasse']; ?><br>
			<?php echo $firma['firma_plz']; ?><br>
			<?php echo $firma['firma_ort']; ?></td>
			<td><?php echo $firma['firma_beschreibung']; ?></td>
			<td>
				<a href="<?php echo site_url('firmen/edit/'.$firma['firmen_firmaid']); ?>" class="btn btn-secondary"><span class="iconify icon:typcn:edit icon-width:20 icon-height:20"></span></a>
				<a href="<?php echo site_url('firmen/delete/'.$firma['firmen_firmaid']); ?>" class="btn btn-danger<?php if($this->session->userdata('level')!='1') { echo " disabled"; }?>"><span class="iconify icon:typcn:delete icon-width:20 icon-height:20"></span></a>
			</td>
		</tr>
		<?php
	}
}
?>

</tbody>
</table>

				
				