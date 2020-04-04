

<h1>Willkommen!</h1>
<br><br>
<h2>Statistiken \o/</h2>
<br>
<div class="row">
	<div class="col" style="width: 100%; max-width: 300px;">

					
<table  class="table">
	<thead>
		<th><span class="iconify" data-icon="jam:plug" data-width="20" data-height="20"></span> Geräte</th>
		<th></th>
	</thead>
		<tbody>
							<tr>
								<td>Gesamt</td>
								<td><?php echo $geraete_count; ?></td>
							</tr>
							<tr>
								<td>aktiv</td>
								<td><?php echo $geraete_aktiv_1; ?></td>
							</tr>
							<tr>
								<td>inaktiv</td>
								<td><?php echo $geraete_aktiv_0; ?></td>
							</tr>
							<tr>
								<td>durchgefallen</td>
								<td><?php echo $geraete_count_fail; ?></td>
							</tr>
						</tbody>
						</table>

</div>

	<div class="col" style="width: 100%; max-width: 300px;">

						
<table  class="table">
	<thead>
		<th><span class="iconify icon:typcn:clipboard icon-width:20 icon-height:20"></span> Prüfungen</th>
		<th></th>
	</thead>
		<tbody>
							<tr>
								<td>Gesamt</td>
								<td><?php echo $pruefung_count; ?></td>
							</tr>
							<tr>
								<td>bestanden</td>
								<td><?php echo $pruefung_bestanden_1; ?></td>
							</tr>
							<tr>
								<td>fehlgeschlagen</td>
								<td><?php echo $pruefung_bestanden_0; ?></td>
							</tr>
							
						</tbody>
						</table>

</div>

	<div class="col" style="width: 100%; max-width: 300px;">

						
<table  class="table">
	<thead>
		<th>Rest</th>
		<th></th>
	</thead>
		<tbody>
							<tr>
								<td><span class="iconify" data-icon="ic:baseline-account-circle" data-width="20" data-height="20"></span> Prüfer</td>
								<td><?php echo $pruefer_count; ?></td>
							</tr>
							<tr>
								<td><span class="iconify" data-icon="ic:outline-computer" data-width="20" data-height="20"></span> Messgeräte</td>
								<td><?php echo $messgeraete_count; ?></td>
							</tr>
							<tr>
								<td><span class="iconify" data-icon="ic:baseline-room" data-width="20" data-height="20"></span> Orte</td>
								<td><?php echo $orte_count; ?></td>
							</tr>
						</tbody>
						</table>

</div>


</div>