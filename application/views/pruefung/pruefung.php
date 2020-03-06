

<div class="row">
 <div class="col-md-8">
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

 <div class="col-md-4">
 	<img src="<?php echo base_url();?>emcotlogo.jpg" class="img-fluid" alt="Responsive image">
 </div>
 </div>
<div class="row">
	

<!-- table-hover table-bordered table-sm table-striped -->

		<table class="table-bordered table-striped" style="width:100%">
		<thead>
		<tr>
			<th>ID</th>
			<?php	if(!$ort) {?>	<th>Ort</th><?php	}?>
			<th>Name</th>
			<th>Hersteller</th>
			<th>Typ</th>
			<th>Seriennummer</th>
			<th>geprüft</th>
			<th>Beschreibung</th>
			<!--<th>hinzugefügt am</th>-->
			<!--<th>U</th>
			<th>I</th>
			<th>P</th>-->
			<th>Prüfer</th>
			<!--<th>Verlängerungskabel</th>-->
			<th>geprüft am</th>

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
				
				if($geraet['aktiv']=='1') {
						
					?>
					<tr class="<?php if($geraet['aktiv']=='0') { echo "table-danger"; } ?>">
						<td><?php echo $geraet['gid']; ?></td>
							<?php
				if(!$ort) {
			?>
						
						<td><?php echo $geraet['ortsname']; ?></td>
						
						<?php
				}
			?>
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
		}
		?>

		</tbody>
		</table>

	
</div>

<br><br>
<div class="row">
<table class="table-bordered table-striped" style="width:100%">
<thead>
<tr>
	<th>ID</th>
	<?php	if(!$ort) {?>	<th>Ort</th><?php	}?>
	<th>Name</th>
	<th>Hersteller</th>
	<th>Typ</th>
	<th>Seriennummer</th>
	<th>geprüft</th>
	<th>Beschreibung</th>
	<!--<th>hinzugefügt am</th>-->
	<!--<th>U</th>
	<th>I</th>
	<th>P</th>-->

	<!--<th>Verlängerungskabel</th>-->


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
		
		if($geraet['aktiv']=='0') {
		
				
			?>
			<tr class="<?php if($geraet['aktiv']=='0') { echo "table-danger"; } ?>">
				<td><?php echo $geraet['gid']; ?></td>
					<?php
		if(!$ort) {
	?>
				
				<td><?php echo $geraet['ortsname']; ?></td>
				
				<?php
		}
	?>
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
				
				<!--<td><?php if($geraet['verlaengerungskabel']=='0') { ?>  <?php } else { ?><?php echo $geraet['kabellaenge']; ?>m</td><?php	} ?>-->
				
			</tr>
			<?php
		}
	}
}
?>

</tbody>
</table>
</div>