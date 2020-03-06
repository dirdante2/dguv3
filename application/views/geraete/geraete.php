
<title><?php echo $ort['name']; ?> Geräte</title>  
<br>
<div class="row">
 <div class="col-5">
  <?php
  	if($ort) {
  ?>
  <h1>Geräte für <?php echo $ort['name']; ?></h1>
  <h3><?php echo $ort['beschreibung']; ?></h3>

  <?php
  	} else {
  ?>
  <h1>Geräte</h1>
  <?php
  	}
  ?>
 </div>
 <div class="col-3">
  <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=http://dguv3.qabc.eu/index.php/geraete/index/7" class="img-fluid" alt="Responsive image">
 </div>
 <div class="col-4">
<img src="<?php echo base_url();?>application/bilder/logo.jpg" class="img-fluid" alt="Responsive image">
 </div>
 </div>
 <br>
 
 


 

<div class="row">
	 <div class="col">

<!-- table-hover table-bordered table-sm table-striped -->

		<table class="table-bordered table-striped" id="table_print" style="width:100%" >
		<thead>
		<tr>
			<th class="d-none">status</th>
			<th class="nosort">ID</th>
			<th class="nosort <?php if($ort) { echo "d-none"; } ?>">Ort</th>
			<th class="nosort" data-class-name="priority">Name</th>
			<th class="nosort">Hersteller</th>
			<th class="nosort">Typ</th>
			<th class="nosort">Seriennummer</th>
			<th class="nosort" class="nosort">geprüft</th>
			<th class="nosort">Beschreibung</th>
			<!--<th>hinzugefügt am</th>-->
			<!--<th>U</th>
			<th class="nosort">I</th>
			<th class="nosort">P</th>-->
			<th class="nosort">Prüfer</th>
			<!--<th>Verlängerungskabel</th>-->
			<th class="nosort">geprüft am</th>
			

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
					<tr class="<?php if($geraet['aktiv']=='0') { echo "table-secondary"; } elseif($geraet['verlaengerungskabel']=='1')  { echo "table-danger"; } else { echo "4"; }?>">
						<!--
						<td class="d-none">
						
						sorting col
						status
							inaktiv=1 gray (aktiv==0)
							geprüft nein=2 red
							geprüft abgelaufen=3 red
							geprüft bald abgelaufen=4 yellow
							ok=5

						-->
						<td class="d-none"><?php if($geraet['aktiv']=='0') { echo "1"; } elseif($geraet['verlaengerungskabel']=='1')  { echo "3"; } else { echo "4"; }?></td>
						
						<td><?php echo $geraet['gid']; ?></td>
						
						
						<td class="<?php if($ort) { echo "d-none"; } ?>"><?php echo $geraet['ortsname']; ?></td>
						
						
						<td><?php echo $geraet['name']; ?><?php if($geraet['verlaengerungskabel']=='1') { ?> | <?php echo $geraet['kabellaenge']; ?>m</td><?php	} ?>	
							</td>
						<td><?php echo $geraet['hersteller']; ?></td>
						<td><?php echo $geraet['typ']; ?></td>
						<td><?php echo $geraet['seriennummer']; ?></td>
						<td><?php if($geraet['aktiv']=='0') { echo "nein"; } else { echo "ja"; } ?></td>
						<td><?php echo $geraet['beschreibung']; ?></td>
						<!--<td><?php $blubb = new DateTime($geraet['hinzugefuegt']); echo $blubb->format('d.m.Y');  ?></td>-->
			<!--			<td><?php if($geraet['nennspannung']=='') { echo "-"; } else { echo $geraet['nennspannung'].'V'; } ?></td>
						<td><?php if($geraet['nennstrom']=='') { echo "-"; } else { echo $geraet['nennstrom'].'A'; } ?></td>
						<td><?php if($geraet['leistung']=='') { echo "-"; } else { echo $geraet['leistung'].'W'; } ?></td>-->
						<td>?</td>
						<!--<td><?php if($geraet['verlaengerungskabel']=='0') { ?>  <?php } else { ?><?php echo $geraet['kabellaenge']; ?>m</td><?php	} ?>-->
						<td>-</td>
						
					</tr>
					<?php
				
			}

		}
		?>

		
	</tbody>
		</table>
			
</div>
</div>
