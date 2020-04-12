
<title><?php if($ort) { echo $ort['name']; } ?> Geräte</title>  
<br>

<table style="width:100%">
	<tr>
		<td class="text-left">
			<?php if($ort) { ?>
  <h1>Geräte für <?php echo $ort['name']; ?></h1>
  <h3><?php echo $ort['beschreibung']; ?></h3>
  <br>
	<?php echo $adresse; ?>
	
	
	
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

		<table class="table-bordered table-striped" id="table_print" style="width:100%" >
		<thead>
			<tr>
				<th class="<?php if($dguv3_show_geraete_col[0][1]=='0') { echo "d-none"; } ?>"><?php echo $dguv3_show_geraete_col[0][0]; ?></th>
				<th class="<?php if($dguv3_show_geraete_col[1][1]=='0') { echo "d-none"; } ?>"><?php echo $dguv3_show_geraete_col[1][0]; ?></th>
				<th class="<?php if($ort || $dguv3_show_geraete_col[2][1]=='0') { echo "d-none"; } ?>"><?php echo $dguv3_show_geraete_col[2][0]; ?></th>
				<th class="<?php if($dguv3_show_geraete_col[3][1]=='0') { echo "d-none"; } ?>"><?php echo $dguv3_show_geraete_col[3][0]; ?></th>
				<th class="<?php if($dguv3_show_geraete_col[4][1]=='0') { echo "d-none"; } ?>"><?php echo $dguv3_show_geraete_col[4][0]; ?></th>
				<th class="<?php if($dguv3_show_geraete_col[5][1]=='0') { echo "d-none"; } ?>"><?php echo $dguv3_show_geraete_col[5][0]; ?></th>
				<th class="<?php if($dguv3_show_geraete_col[6][1]=='0') { echo "d-none"; } ?>"><?php echo $dguv3_show_geraete_col[6][0]; ?></th>
				<th class="<?php if($dguv3_show_geraete_col[7][1]=='0') { echo "d-none"; } ?>"><?php echo $dguv3_show_geraete_col[7][0]; ?></th>
				<th class="<?php if($dguv3_show_geraete_col[8][1]=='0') { echo "d-none"; } ?>"><?php echo $dguv3_show_geraete_col[8][0]; ?></th>
				<th class="<?php if($dguv3_show_geraete_col[9][1]=='0') { echo "d-none"; } ?>"><?php echo $dguv3_show_geraete_col[9][0]; ?></th>
				<th class="<?php if($dguv3_show_geraete_col[10][1]=='0') { echo "d-none"; } ?>"><?php echo $dguv3_show_geraete_col[10][0]; ?></th>
				<th class="<?php if($dguv3_show_geraete_col[11][1]=='0') { echo "d-none"; } ?>"><?php echo $dguv3_show_geraete_col[11][0]; ?></th>
				<th class="<?php if($dguv3_show_geraete_col[12][1]=='0') { echo "d-none"; } ?>"><?php echo $dguv3_show_geraete_col[12][0]; ?></th>
				<th class="<?php if($dguv3_show_geraete_col[13][1]=='0') { echo "d-none"; } ?>"><?php echo $dguv3_show_geraete_col[13][0]; ?></th>
				<th class="<?php if($dguv3_show_geraete_col[14][1]=='0') { echo "d-none"; } ?>"><?php echo $dguv3_show_geraete_col[14][0]; ?></th>
				<th class="<?php if($dguv3_show_geraete_col[15][1]=='0') { echo "d-none"; } ?>"><?php echo $dguv3_show_geraete_col[15][0]; ?></th>
				<th class="<?php if($dguv3_show_geraete_col[16][1]=='0') { echo "d-none"; } ?>"><?php echo $dguv3_show_geraete_col[16][0]; ?></th>
				<th class="<?php if($dguv3_show_geraete_col[17][1]=='0') { echo "d-none"; } ?>"><?php echo $dguv3_show_geraete_col[17][0]; ?></th>
				
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
		<tr>
			<td class="<?php if($dguv3_show_geraete_col[0][1]=='0') { echo "d-none"; } ?>"><?php echo $geraet['gid']; ?></td>
			
			<td class="<?php if($dguv3_show_geraete_col[1][1]=='0') { echo "d-none"; } ?>"><?php if($geraet['aktiv']=='0') { echo "1"; } elseif ($geraet['bestanden']=='0')  { echo "4"; } elseif ($nextyear < $today)  { echo "2"; } elseif ($nextyearfast < $today) { echo "3"; }?></td>
			
			
				<td class="<?php if($ort || $dguv3_show_geraete_col[2][1]=='0') { echo "d-none"; } ?>"><?php echo $geraet['ortsname']; ?></td>
				
			<td class="<?php if($dguv3_show_geraete_col[3][1]=='0') { echo "d-none"; } ?>"><?php echo $geraet['name']; ?><?php if($geraet['verlaengerungskabel']=='1') { ?> | <?php echo $geraet['kabellaenge']; ?>m<?php	} ?>	
				</td>
			<td class="<?php if($dguv3_show_geraete_col[4][1]=='0') { echo "d-none"; } ?>"><?php echo $geraet['hersteller']; ?></td>
			<td class="<?php if($dguv3_show_geraete_col[5][1]=='0') { echo "d-none"; } ?>"><?php echo $geraet['typ']; ?></td>
			<td class="<?php if($dguv3_show_geraete_col[6][1]=='0') { echo "d-none"; } ?>"><?php echo $geraet['seriennummer']; ?></td>
			<td class="<?php if($dguv3_show_geraete_col[7][1]=='0') { echo "d-none"; } ?>"><?php if($geraet['aktiv']=='0') { echo "nein"; } else { echo "ja"; } ?></td>
			<td class="<?php if($dguv3_show_geraete_col[8][1]=='0') { echo "d-none"; } ?>"><?php echo $geraet['beschreibung']; ?></td>
			<td class="<?php if($dguv3_show_geraete_col[9][1]=='0') { echo "d-none"; } ?>"><?php $blubb = new DateTime($geraet['hinzugefuegt']); echo $blubb->format('d.m.Y');  ?></td>
			<td class="<?php if($dguv3_show_geraete_col[10][1]=='0') { echo "d-none"; } ?>"><?php if($geraet['nennspannung']=='0') { echo "-"; } else { echo $geraet['nennspannung'].'V'; } ?></td>
			<td class="<?php if($dguv3_show_geraete_col[11][1]=='0') { echo "d-none"; } ?>"><?php if($geraet['nennstrom']=='0.00') { echo "-"; } else { echo $geraet['nennstrom'].'A'; } ?></td>
			<td class="<?php if($dguv3_show_geraete_col[12][1]=='0') { echo "d-none"; } ?>"><?php if($geraet['leistung']=='0') { echo "-"; } else { echo $geraet['leistung'].'W'; } ?></td>
			<td class="<?php if($dguv3_show_geraete_col[13][1]=='0') { echo "d-none"; } ?>"><?php echo $geraet['schutzklasse']; ?></td>
			<td class="<?php if($dguv3_show_geraete_col[14][1]=='0') { echo "d-none"; } ?>"><?php if($geraet['verlaengerungskabel']=='0') { ?>  <?php } else { ?><?php echo $geraet['kabellaenge']; ?>m</td><?php	} ?>
			<td class="<?php if($dguv3_show_geraete_col[15][1]=='0') { echo "d-none"; } ?>"><?php if($geraet['letztesdatum']) {$blubb = new DateTime($geraet['letztesdatum']); echo $blubb->format('d.m.Y');}  ?></td>
			<td class="<?php if($dguv3_show_geraete_col[16][1]=='0') { echo "d-none"; } ?>"><?php if($geraet['bestanden']=='1') { echo "ja"; } elseif($geraet['bestanden']=='0') { echo "nein"; } ?></td>
			<td class="<?php if($dguv3_show_geraete_col[17][1]=='0') { echo "d-none"; } ?>"><?php echo $geraet['pruefername']; ?></td>
			<td class="<?php if($dguv3_show_geraete_col[18][1]=='0') { echo "d-none"; } ?>">
				<div class="text-right btn-group btn-group-sm" role="group" aria-label="options">
					
					<a href="<?php if($geraet) { echo site_url('pruefung/new/'.$geraet['gid']); } ?>" class="<?php if(!$geraet) { echo "d-none"; } ?> btn btn-success btn-sm <?php if($geraet['aktiv']=='0') { echo " disabled"; } ?>"><span class="iconify icon:typcn:document-add icon-width:20 icon-height:20"></span> Neue Prüfung</a>
					<a href="<?php echo site_url('pruefung/index/'.$geraet['gid']); ?>" class="btn btn-primary btn-sm <?php if($geraet['aktiv']=='0') { echo " disabled"; } ?>"><span class="iconify icon:typcn:clipboard icon-width:20 icon-height:20"></span> prüfung</a>
					<a href="<?php echo site_url('geraete/index/'.$geraet['oid']); ?>" class="<?php if($ort) { echo "d-none"; } ?> btn btn-primary btn-sm"><span class="iconify" data-icon="ic:baseline-room" data-width="20" data-height="20"></span> Ort</a>
					<a href="<?php echo site_url('geraete/edit/'.$geraet['gid']); ?>" class="btn btn-secondary btn-sm"><span class="iconify icon:typcn:edit icon-width:20 icon-height:20"></span> edit</a>
					<a href="<?php echo site_url('geraete/delete/'.$geraet['gid']); ?>" class="btn btn-danger btn-sm"><span class="iconify icon:typcn:delete icon-width:20 icon-height:20"></span> delete</a>
				</div>
			
		
			</td>
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