
<h1>Users</h1>

<a href="<?php echo site_url('users/new'); ?>" class="btn btn-primary"><span class="iconify icon:typcn:document-add icon-width:20 icon-height:20"></span> User hinzufügen</a>
<br>
<br>

<table class="table" id="table">
<thead>
	<tr>
		<th>ID</th>
		<th>Name</th>
		<th>email</th>
		<th>level</th>
		<th>firmaid</th>
		<th>prüfer</th>


		<th>Login</th>
		<th>link1</th>
		<th>Aktion</th>
	</tr>
</thead>
<tbody>
<?php

if(count($users)==0) {

?>

<td colspan="4">Es sind noch keine User definiert.</td>

<?php

} else {
	foreach($users as $user) {

		?>
		<tr>
			<td><?php echo $user['user_id']; ?></td>
			<td><?php echo $user['user_name']; ?></td>
			<td><?php echo $user['user_email']; ?></td>
			<td><?php echo $user['user_level']; ?></td>
			<td><?php echo $user['firma_name']; ?><br>
			<a href="<?php echo site_url('geraete/index/'.$user['user_oid']); ?>"><?php echo $user['ortsname']; ?></a>
			</td>
			<td><?php echo $user['pruefername']; ?><br><?php echo $user['messgeraetname']; ?></td>


			<td><?php echo $user['user_lastlogin']; ?></td>
			<td>
				link1 <?php echo $user['user_showlink1']; ?><br>
				delete <?php echo $user['user_delete']; ?><br>
				new <?php echo $user['user_new']; ?><br>
				edit <?php echo $user['user_edit']; ?><br>
				edituser <?php echo $user['user_edituser']; ?>



			</td>
			<td>
				<a href="<?php echo site_url('users/edit/'.$user['user_id']); ?>" class="btn btn-secondary"><span class="iconify icon:typcn:edit icon-width:20 icon-height:20"></span></a>
				<a href="<?php echo site_url('users/delete/'.$user['user_id']); ?>" class="btn btn-danger"><span class="iconify icon:typcn:delete icon-width:20 icon-height:20"></span></a>
			</td>
		</tr>
		<?php
	}
}
?>

</tbody>
</table>
