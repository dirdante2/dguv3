<br><br>


<?php echo validation_errors(); ?>
<?php if (isset($message)) { ?>
    
<?php echo $message; ?>
<?php } ?>
<br>
<h1>Wirklich löschen </h1>
<br>
<b>Objekt</b><br><br>
<div class="row" style="border: 1px solid #000; max-width: 900px;">
<div class="col" style="width: 500px;border: 0px solid #000;white-space: nowrap;">
						

						<table  class="table table-sm">
							<tr>
								<td>ID</td>
								<td><?php if($geraet['gid']==NULL) { echo "-"; } else { echo $geraet['gid']; } ?></td>
							</tr>
							<tr>
								<td>Ort</td>
								<td><?php if($geraet['ortsname']==NULL) { echo "-"; } else { echo $geraet['ortsname'].' '.$geraet['orte_beschreibung']; } ?></td>
							</tr>
							<tr>
								<td>Name</td>
								<td><?php if($geraet['name']==NULL) { echo "-"; } else { echo $geraet['name']; } ?></td>
							</tr>
							<tr>
								<td>Hersteller</td>
								<td><?php if($geraet['hersteller']==NULL) { echo "-"; } else { echo $geraet['hersteller']; } ?></td>
							</tr>
							<tr>
								<td>Typ</td>
								<td><?php if($geraet['typ']==NULL) { echo "-"; } else { echo $geraet['typ']; } ?></td>
							</tr>
							<tr>
								<td>Seriennummer</td>
								<td><?php if($geraet['seriennummer']==NULL) { echo "-"; } else { echo $geraet['seriennummer']; } ?></td>
							</tr>
							<tr>
								<td>Beschreibung</td>
								<td><?php if($geraet['beschreibung']==NULL) { echo "-"; } else { echo $geraet['beschreibung']; } ?></td>
							</tr>
						</table>
</div>
<div class="col" style="border: 0px solid #000;white-space: nowrap;">


						

						<table  class="table table-sm">
						
							<tr>
								<td>Nennspannung</td>
								<td><?php if($geraet['nennspannung']=='0' || $geraet['schutzklasse']=='4') { echo "-"; } else { echo $geraet['nennspannung'].'V'; } ?></td>
							</tr>
							<tr>
								<td>Nennstrom</td>
								<td><?php if($geraet['nennstrom']=='0.00') { echo "-"; } else { echo $geraet['nennstrom'].'A'; } ?></td>
							</tr>
							<tr>
								<td>Leistung</td>
								<td><?php if($geraet['leistung']=='0') { echo "-"; } else { echo $geraet['leistung'].'W'; } ?></td>
							</tr>
							<tr>
								<td>Schutzklasse</td>
								<td><?php if($geraet['schutzklasse']=='4') { echo "Leiter"; } else { echo $geraet['schutzklasse']; } ?></td>
							</tr>
							<tr>
								<td>Verlängerungskabel</td>
								<td><?php if($geraet['verlaengerungskabel']=='0') { echo "-"; } else { echo $geraet['kabellaenge'].'m';} ?></td>
							</tr>
							<tr>
								<td>Aktiv</td>
								<td><?php if($geraet['aktiv']=='0') { echo "Nein"; } else { echo "Ja"; } ?></td>
							</tr>
						</table>
</div>
</div>