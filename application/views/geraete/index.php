
<title><?php if($ort) { echo $ort['name']; } ?> Geräte</title> 
<div class="row">
 <div class="col">
 	 
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
<div class="btn-group pull-right">
<a class="<?php if(!$ort) { echo "d-none"; } ?> btn btn-primary" href="<?php echo site_url('geraete'); ?>">Alle Geräte auflisten</a>

<a href="<?php echo site_url('geraete/edit'); ?>" class="btn btn-success"><span class="iconify icon:typcn:document-add icon-width:20 icon-height:20"></span> Neues Gerät hinzufügen</a>

</div>
</div>

</div>
<br>

<div class="btn-group pull-right">
<button id="suche_abgelaufen" class="btn btn-warning filter">Prüfung Abgelaufen</button>
<button id="suche_baldabgelaufen" class="btn btn-info filter">Prüfung bald Abgelaufen</button>
<button id="suche_inaktiv" class="btn btn-secondary filter">Gerät auser Betrieb</button>

<button id="suche_alle" class="btn btn-info filter">Alle</button>
</div>
<br>
<br>
<!-- table-hover table-bordered table-sm table-striped -->

<table class="table-hover table-bordered table-sm table-striped" id="table" style="width:100%">
<thead>
<tr>
	<th>ID</th>
	<th class="d-none">status</th>
	
	<th class="<?php if($ort) { echo "d-none"; } ?>">Ort</th>
	<th>Name</th>
	<th>Hersteller</th>
	<th>Typ</th>
	<th>Seriennummer</th>
	<th>aktiv</th>
	<th>Beschreibung</th>
	<!--<th>hinzugefügt am</th>-->
	<th class="d-none">U</th>
	<th class="d-none">I</th>
	<th class="d-none">P</th>
	<th>Schutzklasse</th>
	<!--<th>Verlängerungskabel</th>-->
	<th>Prüfungen</th>
	<th>Aktion</th>
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

				$today = date("Y-m");
				$day     = $geraet['letztesdatum'];
				$nextyear = strtotime("+12 month", strtotime($day));
				$nextyearfast = strtotime("+10 month", strtotime($day));
				$nextyear = date("Y-m", $nextyear);
				$nextyearfast = date("Y-m", $nextyearfast);



		?>
			<!--
						<td class="d-none">
						
						sorting col
						status
							inaktiv=1 gray (aktiv==0)
							geprüft nein=2 -
							geprüft abgelaufen=2 warning
							geprüft bald abgelaufen=3 info
							failed 4 red

						-->

													
		<tr class="<?php if($geraet['aktiv']=='0') { echo "table-secondary"; } elseif ($nextyear < $today)  { echo "table-warning"; } elseif ($nextyearfast < $today) { echo "table-info"; }?>">
			<td><?php echo $geraet['gid']; ?></td>
			
			<td class="d-none"><?php if($geraet['aktiv']=='0') { echo "1"; } elseif ($nextyear < $today)  { echo "2"; } elseif ($nextyearfast < $today) { echo "3"; }?></td>
			
			
				<td class="<?php if($ort) { echo "d-none"; } ?>"><?php echo $geraet['ortsname']; ?></td>
				
			<td><?php echo $geraet['name']; ?><?php if($geraet['verlaengerungskabel']=='1') { ?> | <?php echo $geraet['kabellaenge']; ?>m<?php	} ?>	
				</td>
			<td><?php echo $geraet['hersteller']; ?></td>
			<td><?php echo $geraet['typ']; ?></td>
			<td><?php echo $geraet['seriennummer']; ?></td>
			<td><?php if($geraet['aktiv']=='0') { echo "nein"; } else { echo "ja"; } ?></td>
			<td><?php echo $geraet['beschreibung']; ?></td>
			<!--<td><?php $blubb = new DateTime($geraet['hinzugefuegt']); echo $blubb->format('d.m.Y');  ?></td>-->
			<td class="d-none"><?php if($geraet['nennspannung']=='0') { echo "-"; } else { echo $geraet['nennspannung'].'V'; } ?></td>
			<td class="d-none"><?php if($geraet['nennstrom']=='0.00') { echo "-"; } else { echo $geraet['nennstrom'].'A'; } ?></td>
			<td class="d-none"><?php if($geraet['leistung']=='0') { echo "-"; } else { echo $geraet['leistung'].'W'; } ?></td>
			<td><?php echo $geraet['schutzklasse']; ?></td>
			<!--<td><?php if($geraet['verlaengerungskabel']=='0') { ?>  <?php } else { ?><?php echo $geraet['kabellaenge']; ?>m</td><?php	} ?>-->
			<td><?php echo $geraet['letztesdatum']?>    (<?php echo $geraet['anzahl']?>)</td>
			<td>
				<div class="btn-group btn-group-sm" role="group" aria-label="options">
					<a href="<?php echo site_url('pruefung/index/'.$geraet['gid']); ?>" class="btn btn-primary btn-sm"><span class="iconify icon:typcn:clipboard icon-width:20 icon-height:20"></span> prüfung</a>
					<a href="<?php echo site_url('geraete/index/'.$geraet['oid']); ?>" class="<?php if($ort) { echo "d-none"; } ?> btn btn-primary"><span class="iconify" data-icon="ic:baseline-room" data-width="20" data-height="20"></span> Ort</a>
					<a href="<?php echo site_url('geraete/edit/'.$geraet['gid']); ?>" class="btn btn-secondary btn-sm"><span class="iconify icon:typcn:edit icon-width:20 icon-height:20"></span> edit</a>
					<a href="<?php echo site_url('geraete/delete/'.$geraet['gid']); ?>" class="btn btn-danger btn-sm"><span class="iconify icon:typcn:delete icon-width:20 icon-height:20"></span> delete</a>
				</div>
			<!--<a href="<?php echo site_url('geraete/edit/'.$geraet['gid']); ?>">bearbeiten</a> | <a href="<?php echo site_url('geraete/delete/'.$geraet['gid']); ?>">löschen</a>-->
		
			</td>
		</tr>
		<?php
	}
}
?>

</tbody>
</table>

</div>