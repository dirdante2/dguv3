
<br>

<table style="width:100%">
	<tr>
		<td class="text-left">
			<?php if($ort) { ?>
  <h1>Geräte für <?php echo $ort['name']; ?></h1>
  <h3><?php echo $ort['beschreibung']; ?></h3>
  <br>
  	<?php echo $ort['firma_name']; ?><br>
	<?php echo $ort['firma_strasse']; ?><br>
    <?php echo $ort['firma_plz']; ?> <?php echo $ort['firma_ort']; ?>



  <?php
  	} else {
  ?>
  <h1>Geräte</h1>
  <?php	} ?>

		</td>
		<td class="text-center">
			 <?php if($ort) { ?><img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=<?php echo base_url();?>index.php/geraete/index/<?php echo $ort['oid']; ?>" width="100px" class="img-fluid" alt="Responsive image"><?php	} ?>
 	<br><?php $blubb = new DateTime(); echo $blubb->format('d.m.Y');  ?>

		</td>
		<td class="text-right">
			<img src="<?php echo base_url();?>application/bilder/logo.jpg" width="300px" alt="Responsive image" >


		</td>
	</tr>
</table>


 <br>

<div class="row">
	 <div class="col">

<!-- table-hover table-bordered table-sm table-striped -->

		<table class="table-bordered table-striped no-sort" id="table_print" style="width:100%" >
		<thead>
		<tr>
				<th class="">ID</th>
				<th class="d-none">status</th>
				<th style="" class="<?php if($ort) { echo "d-none"; } ?>">Ort</th>
				<th class="">Name</th>
				<th class="">Hersteller</th>
				<th class="">Typ</th>
				<th class="">Seriennummer</th>
				<th class="d-none">aktiv</th>
				<th class="">Beschreibung</th>
				<th class="">hinzugefügt</th>
				
				
				
				<th class="">Prüfung</th>
				
			</tr>
		</thead>
		<tbody>
		<?php

if(count($geraete)==0) {

	?>
	
	<td colspan="15">Es sind noch keine Geräte vorhanden.</td>
	
	<?php
	
	} else {
		foreach($geraete as $geraet) {
	
			
	
	
	
			?>
		<tr class="">
		<td class=""><?php echo $geraet['gid']; ?></td>

			<td class="d-none"></td>


				<td style="white-space:nowrap" class="<?php if($ort) { echo "d-none"; } ?>"><?php echo $geraet['ortsname']; ?></td>

			<td class=""><?php echo $geraet['name']; ?><?php if($geraet['verlaengerungskabel']=='1') { ?> | <?php echo $geraet['kabellaenge']; ?>m<?php	} ?>
				</td>
			<td class=""><?php echo $geraet['hersteller']; ?></td>
			<td class=""><?php echo $geraet['typ']; ?></td>
			<td class=""><?php echo $geraet['seriennummer']; ?></td>
			<td class="d-none"><?php if($geraet['aktiv']=='0') { echo "nein"; } else { echo "ja"; } ?></td>
			<td class=""><?php echo $geraet['beschreibung']; ?></td>
			<td class=""><?php $blubb = new DateTime($geraet['hinzugefuegt']); echo $blubb->format('d.m.Y');  ?></td>
			
			<td class=""><?php echo $geraet['letztesdatum']?>    (<?php echo $geraet['anzahl']?>)</td>
			
		</tr>
					<?php

			}

		}
		?>


	</tbody>
		</table>

</div>
</div>

<div class="row">
	<div class="col">

						<br><br>
<table  class="table" style="width:700px">
	<thead>
		<tr>
		<th>Messung</th>
		<th>Grenzwerte</th>
		</tr>
	</thead>
		<tbody>
							<tr>
								<td>Schutzleiterwiderstand</td>
								<td>Max 0.3 Ohm (Pro Meter Kabel +0.1 Ohm aber Max 1.0 Ohm)</td>
							</tr>
							<tr>
								<td>Isolationsprüfung 500V</td>
								<td>Min 2,00 MOhm</td>
							</tr>
							<tr>
								<td>Schutzleiterstrom</td>
								<td>Max 0,50 mA</td>
							</tr>
							<tr>
								<td>Berührungstrom</td>
								<td>Max 0,25 mA</td>
							</tr>
						</tbody>
						</table>

</div>
</div>
