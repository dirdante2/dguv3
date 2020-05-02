



<table style="width:100%"><tr>
	<td class="text-left">QR<br><img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=<?php echo base_url();?>index.php/pruefung/index/<?php echo $pruefung['gid']; ?>" width="80px" alt="Responsive image"></td>
	<td class="text-right"><img src="<?php echo base_url();?>application/bilder/logo.jpg" width="280px" alt="Responsive image" ></td>

	</tr></table>

<br>

<div style="border: 2px solid #000;" class="container-fluid" style="width:100%">

		<div class="row" style="border: 1px solid #000;">
			<div class="col"><h4>Prüfprotokoll elektrischer Geräte gemäß DIN VDE 0701/0702,<br>BetrSichV, DGUV Vorschrift 3</h4></div>
		</div><br>

		<table style="width:100%"><tr>
		<td class="align-baseline">
						<b>Kunde</b><br><br>
						<?php echo $pruefung['firma_name']; ?><br>
						<?php echo $pruefung['firma_strasse']; ?><br>
    					<?php echo $pruefung['firma_plz']; ?> <?php echo $pruefung['firma_ort']; ?>
				</td><td class="align-baseline">
						<b>Objekt</b><br><br>
						<table  class="table table-sm">
							<tr>
								<td>ID</td>
								<td><?php if($pruefung['gid']==NULL) { echo "-"; } else { echo $pruefung['gid']; } ?></td>
							</tr>
							<tr>
								<td>Ort</td>
								<td><?php if($pruefung['ortsname']==NULL) { echo "-"; } else { echo $pruefung['ortsname']; } ?></td>
							</tr>
							<tr>
								<td>Name</td>
								<td><?php if($pruefung['geraetename']==NULL) { echo "-"; } else { echo $pruefung['geraetename']; } ?></td>
							</tr>
							<tr>
								<td>Hersteller</td>
								<td><?php if($pruefung['hersteller']==NULL) { echo "-"; } else { echo $pruefung['hersteller']; } ?></td>
							</tr>
							<tr>
								<td>Typ</td>
								<td><?php if($pruefung['typ']==NULL) { echo "-"; } else { echo $pruefung['typ']; } ?></td>
							</tr>
							<tr>
								<td>Seriennummer</td>
								<td><?php if($pruefung['seriennummer']==NULL) { echo "-"; } else { echo $pruefung['seriennummer']; } ?></td>
							</tr>
							<tr>
								<td>Beschreibung</td>
								<td><?php if($pruefung['geraetebeschreibung']==NULL) { echo "-"; } else { echo $pruefung['geraetebeschreibung']; } ?></td>
							</tr>
						</table>

				</td><td class="align-baseline">
						<br><br>
						<table  class="table table-sm">
							<tr>
								<td>Nennspannung</td>
								<td><?php if($pruefung['nennspannung']=='0' || $pruefung['schutzklasse']='4') { echo "-"; } else { echo $pruefung['nennspannung'].'V'; } ?></td>
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
								<td><?php if($pruefung['schutzklasse']=='4') { echo "-"; } else { echo $pruefung['schutzklasse']; } ?></td>
							</tr>
							<tr>
								<td>Verlängerungskabel</td>
								<td><?php if($pruefung['verlaengerungskabel']=='0') { echo "-"; } else { echo $pruefung['kabellaenge'].'m';} ?></td>
							</tr>
							<tr>
								<td>Aktiv</td>
								<td><?php if($pruefung['aktiv']=='0') { echo "Nein"; } else { echo "Ja"; } ?></td>
							</tr>
						</table>

				</td>
				</tr></table>

		<hr>
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
								<td><?php if($pruefung['schutzklasse']=='4') { echo "-"; } else { echo $pruefung['messgeraetname']; } ?></td>
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
								<td><?php if($pruefung['sichtpruefung']== '0') { echo "Nein"; } else { echo "Ja"; }?></td>
							</tr>
							<tr>
								<td>Schutzleiterwiderstand</td>
								<td>max <?php echo $pruefung['RPEmax']; ?> &#8486;</td>
								<td><?php if($pruefung['schutzleiter']===null || $pruefung['sichtpruefung']== '0') { echo "-"; } else { echo $pruefung['schutzleiter'].' &#8486;'; } ?></td>
								<td><?php
									$y = $pruefung['RPEmax'];
									if($pruefung['schutzleiter']===null || $pruefung['sichtpruefung']== '0') {
									       echo "-";
									} else {
    									if($pruefung['schutzleiter'] >= $y) {
    									      echo "Nein";
    									} else {
    									    echo "Ja";
    								    }
									}?></td>
							</tr>
							<tr>
								<td>Isolationsprüfung 500V</td>
								<td>min 2.00 M&#8486;</td>
								<td><?php if($pruefung['isowiderstand']===null || $pruefung['sichtpruefung']== '0') { echo "-"; } else { echo $pruefung['isowiderstand'].' M&#8486;'; } ?></td>
								<td><?php
									$y = 2.0;
									if($pruefung['isowiderstand']===null || $pruefung['sichtpruefung']== '0') {
									       echo "-";
									} else {
    									if($pruefung['isowiderstand'] < $y) {
    									      echo "Nein";
    									} else {
    									    echo "Ja";
    								    }
									}?></td>
							</tr>
							<tr>
								<td>Schutzleiterstrom</td>
								<td>max 0.50 mA</td>
								<td><?php if($pruefung['schutzleiterstrom']===null || $pruefung['sichtpruefung']== '0') { echo "-"; } else { echo $pruefung['schutzleiterstrom'].' mA'; } ?></td>
								<td><?php
									$y = 0.50;
									if($pruefung['schutzleiterstrom']===null || $pruefung['sichtpruefung']== '0') {
									       echo "-";
									} else {
    									if($pruefung['schutzleiterstrom'] >= $y) {
    									      echo "Nein";
    									} else {
    									    echo "Ja";
    								    }
									}?></td>
							</tr>

							<tr>
								<td>Berührungstrom</td>
								<td>max 0.25 mA</td>
								<td><?php if($pruefung['beruehrstrom']===null || $pruefung['sichtpruefung']== '0') { echo "-"; } else { echo $pruefung['beruehrstrom'].'mA'; } ?></td>
								<td><?php
									$y = 0.25;
									if($pruefung['beruehrstrom']===null || $pruefung['sichtpruefung']== '0') {
									       echo "-";
									} else {
    									if($pruefung['beruehrstrom'] >= $y) {
    									      echo "Nein";
    									} else {
    									    echo "Ja";
    								    }
									}?></td>
							</tr>
							<tr>
								<td>Funktionsprüfung</td>
								<td></td>
								<td></td>
								<td><?php if($pruefung['funktion']=='0' || $pruefung['sichtpruefung']== '0') { echo "Nein"; } else { echo "Ja"; }?></td>
							</tr>
							<tr>
								<td>&nbsp;</td>
								<td></td>
								<td></td>
								<td></td>
							</tr>
							<tr>
								<td>Ergebnis</td>
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
						<?php if($pruefung['bemerkung']=='') { echo "<br><br>"; } else { echo $pruefung['bemerkung']; }?>
				</div>



		</div><hr>
		Die Prüfung wurde ordnungsgemäß durchgeführt
		<br><br>
				<table style="width:100%"><tr>
			<td><?php $blubb = new DateTime($pruefung['datum']); echo $blubb->format('d.m.Y');  ?></td>
			<td></td>
			</tr></table>



		<hr>
		<table style="width:100%"><tr>
			<td>Datum</td>
			<td class="text-center">Unterschrift</td>
			</tr></table>


</div>
<center>Dieses Prüfprotokoll wurde maschinell erstellt und ist auch ohne Unterschrift gültig!</center>
