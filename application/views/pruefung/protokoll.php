
<title>item prüfung</title> 
<div class="row">
 <div class="col-md-8">
  <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=http://dguv3.qabc.eu/index.php/pruefung/protokoll/<?php echo $pruefung['pruefungid']; ?>" class="img-fluid" alt="Responsive image">
 </div>

 <div class="col-md-4">
 	<img src="<?php echo base_url();?>application/bilder/logo.jpg" class="img-fluid" alt="Responsive image">
 </div>
 </div>


<br>

<div style="border: 2px solid #000;" class="container-fluid" style="width:100%">
	
		<div class="row" style="border: 1px solid #000;">
			<div class="col"><h4>Prüfprotokoll elektrischer Geräte gemäß DIN VDE 0701/0702,<br>BetrSichV, DGUV Vorschrift 3</h4></div>
		</div><br>
		<div class="row">
			
				<div class="col-3">
						<b>Kunde</b><br><br>
						emcot group GmbH<br>
						Vienhovenweg 2a<br>
						44867 Bochum
				</div>
				<div class="col-6">
						<b>Objekt</b><br><br>
						<table  class="table table-sm">
							<tr>
								<td>ID</td>
								<td><?php echo $pruefung['gid']; ?></td>
							</tr>
							<tr>
								<td>Ort</td>
								<td><?php echo $pruefung['ortsname']; ?></td>
							</tr>
							<tr>
								<td>Name</td>
								<td><?php echo $pruefung['geraetename']; ?></td>
							</tr>
							<tr>
								<td>Hersteller</td>
								<td><?php echo $pruefung['hersteller']; ?></td>
							</tr>
							<tr>
								<td>Typ</td>
								<td><?php echo $pruefung['typ']; ?></td>
							</tr>
							<tr>
								<td>Seriennummer</td>
								<td><?php echo $pruefung['seriennummer']; ?></td>
							</tr>
							<tr>
								<td>Beschreibung</td>
								<td><?php echo $pruefung['geraetebeschreibung']; ?></td>
							</tr>
						</table>
						
				</div>	
				<div class="col-3">
						<br><br>
						<table  class="table table-sm">
							<tr>
								<td>Nennspannung</td>
								<td><?php if($pruefung['nennspannung']=='0') { echo "-"; } else { echo $pruefung['nennspannung'].'V'; } ?></td>
							</tr>
							<tr>
								<td>Nennstrom</td>
								<td><?php if($pruefung['nennstrom']=='0.00') { echo "-"; } else { echo $pruefung['nennstrom'].'A'; } ?></td>
							</tr>
							<tr>
								<td>Leistung</td>
								<td><?php if($pruefung['leistung']=='0') { echo "-"; } else { echo $pruefung['leistung'].'W'; } ?></td>
							</tr>
							<tr>
								<td>Schutzklasse</td>
								<td><?php echo $pruefung['schutzklasse']; ?></td>
							</tr>
							
						</table>
						
				</div>	
				
			
		</div><hr>
		<div class="row">
			
				
				<div class="col">
						<b>Angaben zur Prüfung</b><br><br>
						<table  class="table table-sm">
							<tr>
								<td>Prüfnummer</td>
								<td><?php echo $pruefung['pruefungid']; ?></td>
							</tr>
							<tr>
								<td>Prüfdatum</td>
								<td><?php $blubb = new DateTime($pruefung['datum']); echo $blubb->format('d.m.Y');  ?></td>
							</tr>
							<tr>
								<td>Prüfer</td>
								<td><?php echo $pruefung['pruefername']; ?></td>
							</tr>
							<tr>
								<td>Prüfgerät</td>
								<td><?php echo $pruefung['messgeraetname']; ?></td>
							</tr>
							<tr>
								<td>Nächste Prüfung</td>
								<td>
										<?php
										$day     = $pruefung['datum'];
										$nextDay = strtotime("+1 year", strtotime($day));
										echo date("m.Y", $nextDay);
										?>
								</td>
							</tr>
							
						</table>
						
				</div>	
	
		</div><hr>
		<div class="row">
			
				
				<div class="col">
						<b>Prüfung</b><br><br>
						<table  class="table table-sm">
							<thead>
    <tr>
      <th scope="col">Prüfschritt</th>
      <th scope="col">Grenzwert</th>
      <th scope="col">Messwert</th>
      <th scope="col">Bestanden</th>
    </tr>
  </thead>
  <tbody>
							<tr>
								<td>Sichtprüfung</td>
								<td></td>
								<td></td>
								<td><?php if($pruefung['sichtpruefung']=='0') { echo "Nein"; } else { echo "Ja"; }?></td>
							</tr>
							<tr>
								<td>Schutzleiterwiderstand</td>
								<td>Max 0,30 Ohm</td>
								<td><?php if($pruefung['schutzleiter']=='0.00') { echo "-"; } else { echo $pruefung['schutzleiter'].'Ohm'; } ?></td>
								<td><?php 
									$y = 0.30;
									
									if($pruefung['schutzleiter'] > $y) { echo "Nein"; } else { echo "Ja"; }?></td>
							</tr>
							<tr>
								<td>Isolationsprüfung 500V</td>
								<td>Min 2,00 MOhm</td>
								<td><?php if($pruefung['isowiderstand']=='0.00') { echo "-"; } else { echo $pruefung['isowiderstand'].'MOhm'; } ?></td>
								<td><?php 
									$y = 2.0;
									
									if($pruefung['isowiderstand'] < $y) { echo "Nein"; } else { echo "Ja"; }?></td>
							</tr>
							<tr>
								<td>Ersatzleiterableitstrom</td>
								<td>Max 0,50 mA</td>
								<td><?php if($pruefung['schutzleiterstrom']=='0.00') { echo "-"; } else { echo $pruefung['schutzleiterstrom'].'mA'; } ?></td>
								<td><?php 
									$y = 0.5;
									
									if($pruefung['schutzleiterstrom'] > $y) { echo "Nein"; } else { echo "Ja"; }?></td>
							</tr>
							<tr>
								<td>Differenzstrom</td>
								<td>Max 3,5 mA</td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td>Berührungstrom</td>
								<td>Max 0,25 mA</td>
								<td><?php if($pruefung['beruehrstrom']=='0.00') { echo "-"; } else { echo $pruefung['beruehrstrom'].'mA'; } ?></td>
								<td><?php 
									$y = 0.25;
									
									if($pruefung['beruehrstrom'] > $y) { echo "Nein"; } else { echo "Ja"; }?></td>
							</tr>
							<tr>
								<td>Funktionsprüfung</td>
								<td></td>
								<td></td>
								<td><?php if($pruefung['funktion']=='0') { echo "Nein"; } else { echo "Ja"; }?></td>
							</tr>
							<tr>
								<td>&nbsp;</td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td>Die Prüfung wurde bestanden</td>
								<td></td>
								<td></td>
								<td><?php if($pruefung['bestanden']=='0') { echo "Nein"; } else { echo "Ja"; }?></td>
							</tr>
						</tbody>
						</table>
						
				</div>	
				
				
			
		</div><hr>
		<div class="row">
			
				
				<div class="col">
						<b>Bemerkung</b><br>
						<?php echo $pruefung['bemerkung']; ?>
				</div>	
				
		<br>
			
		</div><hr>
		Die Prüfung wurde ordnungsgemäß durchgeführt
				
		<div class="row align-items-end">				
				<div class="col"><?php $blubb = new DateTime($pruefung['datum']); echo $blubb->format('d.m.Y');  ?></div>	
			<!--	<div class="col"><img src="<?php echo base_url();?>/application/bilder/unterschrift.png" style="height:100px;"></div>	-->
			<br><br>
		</div>
		<hr>	
		<div class="row">				
				<div class="col">Datum</div>	
				<div class="col">Unterschrift</div>	
		</div>
		

</div>
<center>Dieses Prüfprotokoll wurde maschinell erstellt und ist auch ohne Unterschrift gültig!</center>
