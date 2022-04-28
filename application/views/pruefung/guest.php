
<table style="width:100%"><tr>
	<td class="text-left"><img src="<?php echo base_url();?>application/bilder/logo.jpg" width="300px" alt="Responsive image" ><br><br>
	Hotline: 04372/8066095<br>
	E-Mail: service@kaelte-heins.com





</td>

	</tr></table>

<br>
<b>Objekt</b><br><br>
<div style="border: 0px solid #000;" class="container-fluid" style="width:100%">

<div class="row" style="border: 1px solid #000;">
<div class="col-lg-3 col-md"style="min-width: 400px; border: 0px solid #000;">
						

						<table  class="table table-sm">
							<tr>
								<td>ID</td>
								<td><?php if($geraet['gid']==NULL) { echo "-"; } else { echo $geraet['gid']; } ?></td>
							</tr>
							<tr>
								<td>Ort</td>
								<td>********</td>
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
<div class="col-lg-3 col-md"style="min-width: 400px; border: 0px solid #000;">
						

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
							<tr>
								<td>Lezte Prüfung</td>
								<td><?php if($pruefung) { echo $pruefung['datum']; } else { echo "unbekannt"; } ?></td>
							</tr>
							<tr>
								<td>Bestanden</td>
								<td><?php if($pruefung) { if($pruefung['bestanden']=='0') { echo "Nein"; } else { echo "Ja"; } } else { echo "--"; } ?></td>
							</tr>
						</table>
</div>
<div class="col-lg-5 col-md text-center" >
<br>
<?php if ($product_typ_pic['pic_exist']) { ?>
	<img  class="mx-auto img-fluid" src="<?php echo $product_typ_pic['url_orginal'] ?>" style="max-width:650px; max-height:300px"  alt="Responsive image">
<?php } else {
	echo 'error';?>
	<?php echo $product_typ_pic['url_orginal']?>
	<?php } ?>
</div>
</div>
<br><br>
<div class="col-md d-flex justify-content-center" >

<h2>Sollten Sie dieses Gerät gefunden haben melden Sie sich bitte bei uns! Danke!</h2>

</div>


</div>