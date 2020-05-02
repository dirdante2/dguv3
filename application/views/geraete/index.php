
<!--<title><?php if($ort) { echo $ort['name']; } ?> Geräte</title> -->
<div class="row">
 <div class="col">

<?php	if($ort) { ?>
<h1>Geräte für <?php echo $ort['name']; ?></h1>
<h3><?php echo $ort['beschreibung']; ?></h3>


<?php	} else { ?>
<h1>Geräte</h1>
<?php	} ?>

<div class="btn-group pull-right">
<a class="<?php if(!$ort) { echo "d-none"; } ?> btn btn-primary" href="<?php echo site_url('geraete'); ?>">Alle Geräte auflisten</a>
<a class="btn btn-success <?php if($this->session->userdata('level')=='3') { echo " disabled"; }?>" href="<?php echo site_url('geraete/edit'); ?>"><span class="iconify icon:typcn:document-add icon-width:20 icon-height:20"></span> Neues Gerät hinzufügen</a>

<?php
	if($ort) {


		?>

			<a href="<?php echo site_url('orte/edit/'.$ort['oid']); ?>" class="btn btn-secondary <?php if($this->session->userdata('level')=='3') { echo " disabled"; }?>"><span class="iconify icon:typcn:edit icon-width:20 icon-height:20"></span> Ort bearbeiten</a>



		<a href="<?php echo base_url('orte/download_file/1/'.$ort['oid']);?>" target="_blank" class="btn btn-primary <?php if (!file_exists($pdf_data)) { echo "disabled"; } ?>"><span class="iconify" data-icon="si-glyph:document-pdf" data-width="20" data-height="20"></span> Übersicht</a>
		<?php } ?>
</div>
</div>

</div>
<br>

<div class="btn-group pull-right">
<button id="suche_baldabgelaufen" class="btn btn-info filter">Prüfung bald Abgelaufen</button>
<button id="suche_abgelaufen" class="btn btn-warning filter">Prüfung Abgelaufen</button>
<button id="suche_failed" class="btn btn-danger filter">Prüfung fehlgeschlagen</button>
<button id="suche_inaktiv" class="btn btn-secondary filter">Gerät auser Betrieb</button>

<button id="suche_alle" class="btn btn-info filter">Alle</button>
</div>
<br><br>


<?php
if(!$ort) {
	$ortsid=0;
} else {
	$ortsid=$ort['oid'];
}
if($page_total_rows<=$page_show_rows) {

	$page_show_rows=$page_total_rows;
}

//wenn pages mehr als 5 dann kürze pagination ein
if($page_pages>=5) {
	if($page_pageid>=3) {
		$page_start=$page_pageid -3;
		$page_end=$page_pageid +4;
	} else {
		$page_start=0;
		$page_end=7;
	}
} else {
	$page_start=0;
	$page_end=$page_pages;
}
if($page_pages>=5 && $page_pageid+4>= $page_pages) {
$page_end=$page_pages;
$page_start=$page_end -7;
}

?>
<!--
<?php echo $page_start; ?> start<br>
<?php echo $page_end; ?> end<br> -->
<div class="" style="text-align: center;border: 0px solid #343a40;" role="group" aria-label="pagination">


	<a class="btn btn-outline-dark <?php if($page_pageid==0) { echo 'disabled';} ?>" type="button" href="<?php echo base_url(); ?>geraete/pagination/<?php echo $ortsid; ?>/0">start</a>
<?php
$i = $page_start;
while($i < $page_end) { ?>


	<a class="btn <?php if($i==$page_pageid) { echo 'btn-dark disabled active';} else { echo 'btn-outline-dark';} ?>" type="button" href="<?php echo base_url(); ?>geraete/pagination/<?php echo $ortsid; ?>/<?php echo $i; ?>" tabindex="0"><?php echo $i +1; ?></a>

	<?php

   //echo "$i, ";

   $i++;
}
?>
<a class="btn btn-outline-dark <?php if($page_pageid+1==$page_pages) { echo 'disabled';} ?>" type="button" href="<?php echo base_url(); ?>geraete/pagination/<?php echo $ortsid; ?>/<?php echo $page_pages-1; ?>">ende</a>
<br>zeige <?php echo $page_show_rows; ?> von <?php echo $page_total_rows; ?> auf <?php echo $page_pages; ?> Seiten<br>

</div>

<br>
<!-- table-hover table-bordered table-sm table-striped -->




<table class="table-hover table-bordered table-sm table-striped" id="table" style="width:100%">
<thead>
			<tr>
				<th class="">ID</th>
				<th class="d-none">status</th>
				<th class="<?php if($ort) { echo "d-none"; } ?>">Ort</th>
				<th class="">Name</th>
				<th class="">Hersteller</th>
				<th class="">Typ</th>
				<th class="">Seriennummer</th>
				<th class="d-none">aktiv</th>
				<th class="">Beschreibung</th>
				<th class="">hinzugefügt</th>
				<th class="d-none">Spannung</th>
				<th class="d-none">Strom</th>
				<th class="d-none">Leistung</th>
				<th class="">Schutzklasse</th>
				<th class="d-none">Kabel</th>
				<th class="">Prüfung</th>
				<th class="">Aktion</th>
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

				$today = date("Y-m-d");
				$day     = $geraet['letztesdatum'];
				$nextyear = strtotime('+'.$pruefungabgelaufen, strtotime($day));
				$nextyearfast = strtotime('+'.$pruefungbaldabgelaufen, strtotime($day));
				$nextyear = date("Y-m-d", $nextyear);
				$nextyearfast = date("Y-m-d", $nextyearfast);



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


		<tr class="<?php if($geraet['aktiv']=='0') { echo "table-secondary"; } elseif ($geraet['bestanden']=='0')  { echo "table-danger"; } elseif ($nextyear < $today)  { echo "table-warning"; } elseif ($nextyearfast < $today) { echo "table-info"; }?>">
		<td class=""><?php echo $geraet['gid']; ?></td>

			<td class="d-none"><?php if($geraet['aktiv']=='0') { echo "1"; } elseif ($geraet['bestanden']=='0')  { echo "4"; } elseif ($nextyear < $today)  { echo "2"; } elseif ($nextyearfast < $today) { echo "3"; }?></td>


				<td style="white-space:nowrap;" class="<?php if($ort) { echo "d-none"; } ?>"><?php echo $geraet['ortsname']; ?></td>

			<td class=""><?php echo $geraet['name']; ?><?php if($geraet['verlaengerungskabel']=='1') { ?> | <?php echo $geraet['kabellaenge']; ?>m<?php	} ?>
				</td>
			<td class=""><?php echo $geraet['hersteller']; ?></td>
			<td class=""><?php echo $geraet['typ']; ?></td>
			<td class=""><?php echo $geraet['seriennummer']; ?></td>
			<td class="d-none"><?php if($geraet['aktiv']=='0') { echo "nein"; } else { echo "ja"; } ?></td>
			<td class=""><?php echo $geraet['beschreibung']; ?></td>
			<td class=""><?php $blubb = new DateTime($geraet['hinzugefuegt']); echo $blubb->format('d.m.Y');  ?></td>
			<td class="d-none"><?php if($geraet['nennspannung']=='0') { echo "-"; } else { echo $geraet['nennspannung'].'V'; } ?></td>
			<td class="d-none"><?php if($geraet['nennstrom']=='0.00') { echo "-"; } else { echo $geraet['nennstrom'].'A'; } ?></td>
			<td class="d-none"><?php if($geraet['leistung']=='0') { echo "-"; } else { echo $geraet['leistung'].'W'; } ?></td>
			<td class=""><?php echo $geraet['schutzklasse']; ?></td>
			<td class="d-none"><?php if($geraet['verlaengerungskabel']=='0') { ?>  <?php } else { ?><?php echo $geraet['kabellaenge']; ?>m</td><?php	} ?>
			<td class=""><?php echo $geraet['letztesdatum']?>    (<?php echo $geraet['anzahl']?>)</td>
			<td class="">
				<div class="text-right btn-group btn-group-sm" role="group" aria-label="options">

					<a href="<?php if($geraet) { echo site_url('pruefung/new/'.$geraet['gid']); } ?>" class="<?php if(!$geraet) { echo "d-none"; } ?> btn btn-success btn-sm <?php if($geraet['aktiv']=='0' || $this->session->userdata('level')>='3') { echo " disabled"; } ?>"><span class="iconify icon:typcn:document-add icon-width:20 icon-height:20"></span> Neue Prüfung</a>
					<a href="<?php echo site_url('pruefung/index/'.$geraet['gid']); ?>" class="btn btn-primary btn-sm <?php if($geraet['aktiv']=='0') { echo " disabled"; } ?>"><span class="iconify icon:typcn:clipboard icon-width:20 icon-height:20"></span> prüfung</a>
					<a href="<?php echo site_url('geraete/index/'.$geraet['oid']); ?>" class="<?php if($ort) { echo "d-none"; } ?> btn btn-primary btn-sm"><span class="iconify" data-icon="ic:baseline-room" data-width="20" data-height="20"></span> Ort</a>
					<a href="<?php echo site_url('geraete/edit/'.$geraet['gid']); ?>" class="btn btn-secondary btn-sm <?php if($this->session->userdata('level')=='3') { echo " disabled"; }?>"><span class="iconify icon:typcn:edit icon-width:20 icon-height:20"></span> edit</a>
					<a href="<?php echo site_url('geraete/delete/'.$geraet['gid']); ?>" class="btn btn-danger btn-sm <?php if($this->session->userdata('level')>='2') { echo " disabled"; }?>"><span class="iconify icon:typcn:delete icon-width:20 icon-height:20"></span> delete</a>
				</div>


			</td>
		</tr>
		<?php
	}
}
?>

</tbody>
</table>

