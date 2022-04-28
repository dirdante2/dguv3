
<div class="row">
 <div class="col">

<?php	if($ort) { ?>
<h1>Geräte für <?php echo $ort['name']; ?></h1>
<h2><?php echo $ort['beschreibung']; ?></h2>


<?php	} else { ?>
<h1>Geräte</h1>
<?php	} ?>

<div class="btn-group-vertical" role="group" aria-label="options" style="width:100%">
<a class="btn-lg <?php if(!$ort) { echo "d-none"; } ?> btn btn-primary" href="<?php echo site_url('geraete'); ?>">Alle Geräte auflisten</a>
<a class="btn-lg btn btn-success <?php if($this->session->userdata('level')=='3') { echo " disabled"; }?>" href="<?php echo site_url('geraete/edit/'); ?><?php if($ort) { echo '0/'.$ort['oid'];} ?>"><span class="iconify icon:typcn:document-add icon-width:50 icon-height:50"></span> Neues Gerät hinzufügen</a>

<?php
	if($ort) {

		$year=date("Y"); ?>

			<a href="<?php echo site_url('orte/edit/'.$ort['oid']); ?>" class="btn-lg btn btn-secondary <?php if($this->session->userdata('level')=='3') { echo " disabled"; }?>"><span class="iconify icon:typcn:edit icon-width:50 icon-height:50"></span> Ort bearbeiten</a>

			<a href="<?php echo base_url('orte/download_file/1/'.$ort['oid']);?>" target="_blank" class="btn btn-primary <?php if (!file_exists($pdf_data) || (filesize($pdf_data)=='0')) { echo "disabled"; } ?>"><span class="iconify" data-icon="si-glyph:document-pdf" data-width="50" data-height="50"></span> Übersicht</a>



		<!--<a href="<?php echo site_url('geraete/geraete/'.$ort['oid']); ?>" class="btn btn-primary"><span class="iconify" data-icon="si-glyph:document-pdf" data-width="20" data-height="20"></span> Übersicht</a>
		-->
		<!-- <a href="<?php echo base_url(); ?>index.php/geraete/html2pdf_liste/<?php echo $ort['oid']  ?>"  class="btn btn-primary <?php if($this->session->userdata('level')>='4') { echo " disabled"; }?>">Übersicht erstellen</a> -->
       <!-- <form method="post">
        <input type="submit" name="button1"
                class="btn btn-primary" value="Übersicht erstellen" /></form> -->
	<?php	} ?>
</div>
</div>

</div>
<br>


<div class="btn-group btn-group-sm" role="group" aria-label="options" style="width:100%">
<button class="btn btn-outline-dark" type="button" data-toggle="collapse" data-target="#suche_ok" aria-expanded="false" aria-controls="suche_ok">ok</button>
<button class="btn btn-info" type="button" data-toggle="collapse" data-target="#suche_baldabgelaufen" aria-expanded="false" aria-controls="suche_baldabgelaufen">Bald Abgelaufen</button>
<button class="btn btn-warning" type="button" data-toggle="collapse" data-target="#suche_abgelaufen" aria-expanded="false" aria-controls="suche_abgelaufen">Abgelaufen</button>
<button class="btn btn-danger" type="button" data-toggle="collapse" data-target="#suche_failed" aria-expanded="false" aria-controls="suche_failed">durchgefallen</button>
<button class="btn btn-secondary" type="button" data-toggle="collapse" data-target="#suche_inaktiv" aria-expanded="false" aria-controls="suche_inaktiv">inaktiv</button>


</div>
<br><br>
<!-- table-hover table-bordered table-sm table-striped -->
 <!-- <?php echo $page_total_rows; ?> total rows<br>
<?php echo $page_show_rows; ?> show rows<br>
<?php echo $page_pages; ?> pages<br>
<?php echo $page_pageid; ?> pageid<br>
<?php echo $page_offset; ?> offset<br>  -->

<?php
if(!$ort) {
	$page_id=0;
} else {
	$page_id=$ort['oid'];
}
if($page_total_rows<=$page_show_rows) {

	$page_show_rows= $page_total_rows;
}

//wenn pages mehr als 5 dann kürze pagination ein
if($page_pages<=5) {
	$page_start=0;
	$page_end=$page_pages;
} else {
	
	if($page_pageid>=3) {
		$page_start=$page_pageid -3;
		
		$page_end=$page_pageid +4;
		
	} else {

		$page_start=0;
		$page_end=5;
	}
}





?>

<!-- <?php echo $page_total_rows; ?> total rows<br>
<?php echo $page_show_rows; ?> show rows<br>
<?php echo $page_pages; ?> pages<br>
<?php echo $page_pageid; ?> pageid<br>
<?php echo $page_offset; ?> offset<br>  -->
<div class="text-center">
<div class="btn-group" role="toolbar" aria-label="Toolbar with button groups" style="border: 0px solid #343a40;">
<div class="btn-group mr-5" role="group" aria-label="pagination1" >



	<a class="btn-lg btn btn-outline-dark <?php if($page_pageid==0) { echo 'disabled';} ?>" type="button" href="<?php echo base_url(); ?>geraete/pagination/<?php echo $page_id; ?>/0">start</a>
	</div>
	<div class="btn-group mr-5" role="group" aria-label="pagination2" >
<?php
$i = $page_start;
while($i < $page_end) { ?>


	<a class="btn btn-lg <?php if($i==$page_pageid) { echo 'btn-dark disabled active';} else { echo 'btn-outline-dark';} ?>" type="button" href="<?php echo base_url(); ?>geraete/pagination/<?php echo $page_id; ?>/<?php echo $i; ?>" tabindex="0"><?php echo $i +1; ?></a>

	<?php

   //echo "$i, ";

   $i++;
   if($i>=$page_pages) {
	   break;
   }
}
?>
</div>
<div class="btn-group mr-5" role="group" aria-label="pagination3" >
<a class="btn-lg btn btn-outline-dark <?php if($page_pageid+1==$page_pages || $page_pages==0) { echo 'disabled';} ?>" type="button" href="<?php echo base_url(); ?>geraete/pagination/<?php echo $page_id; ?>/<?php echo $page_pages-1; ?>">ende</a>
</div>


</div>
<br>zeige <?php echo $page_show_rows; ?> von <?php echo $page_total_rows; ?> auf <?php echo $page_pages; ?> Seiten<br>
</div>

<?php

if($geraete==NULL) {

?>

keine geräte vorhanden

<?php

} else { ?>

<div id="accordion" class="scroll" style="width:100%">


<?php	foreach($geraete as $geraet) {

				$today = date("Y-m-d");
				$day     = $geraet['letztesdatum'];
				$nextyear = strtotime('+'.$pruefungabgelaufen, strtotime($day));
				$nextyearfast = strtotime('+'.$pruefungbaldabgelaufen, strtotime($day));
				$nextyear = date("Y-m-d", $nextyear);
				$nextyearfast = date("Y-m-d", $nextyearfast);

				if($geraet['aktiv']=='0') { $tabletr_color= "bg-secondary"; 
				} elseif ($geraet['schutzklasse'] == "5") { $tabletr_color= "bg-light"; 
				} elseif ($geraet['bestanden']=='0')  { $tabletr_color= "bg-danger"; 
				} elseif ($nextyear <= $today)  { $tabletr_color= "bg-warning"; 
				} elseif ($nextyearfast <= $today) { $tabletr_color= "bg-info"; 
				} else {$tabletr_color= "bg-light";}

				#0 suche bestanden
				#1 suche inaktiv
				#2 suche abgelaufen
				#3 suche bald abgelaufen
				#4 suche failed
				#* suche alle
				#5 suche werkzeug

				if($geraet['aktiv']== "0") { $tabletd_filterid= "1"; 
				} elseif ($geraet['schutzklasse'] == "5") { $tabletd_filterid= "5"; 
				} elseif ($geraet['bestanden']=="0") { $tabletd_filterid= "4"; 
				} elseif ($nextyear <= $today) { $tabletd_filterid= "2"; 
				} elseif ($nextyearfast <= $today) { $tabletd_filterid= "3"; 
				} else { $tabletd_filterid= "0";}

<<<<<<< HEAD
				$product_typ_pic = get_product_typ_pic_url($geraet);

=======
>>>>>>> 10346586e10449e2b380656870ba181159d8dea2



		?>

			 <div class="card collapse multi-collapse show" style="border: 1px solid #343a40;" id='<?php if($geraet['aktiv']=='0') { echo "suche_inaktiv"; } elseif ($geraet['schutzklasse'] == "5") { echo "suche_ok"; } elseif ($geraet['bestanden']=='0')  { echo "suche_failed"; } elseif ($nextyear < $today)  { echo "suche_abgelaufen"; } elseif ($nextyearfast < $today) { echo "suche_baldabgelaufen"; } else { echo 'suche_ok';} ?>'>


			<div id="heading<?php echo $geraet['gid']; ?>" class="card-header <?php echo $tabletr_color; ?>" data-toggle="collapse" data-target="#geraet<?php echo $geraet['gid']; ?>" aria-expanded="true" aria-controls="geraet<?php echo $geraet['gid']; ?>">

			<h4 class="mb-0" id="<?php echo $geraet['gid']; ?>">
			<div class="row">
			<div class="col-6 text-left" id="<?php echo $geraet['gid']; ?>">
			<?php if(!$ort) { echo $geraet['ortsname']; } ?> <?php echo $geraet['name']; ?><?php if($geraet['verlaengerungskabel']=='1') { ?> | <?php echo $geraet['kabellaenge']; ?>m<?php	} ?></div>
 			<div class="col-6 text-right" id="<?php echo $geraet['gid']; ?>"><?php if($this->session->userdata('level')=='1'){?><?php echo $geraet['firma_name']; ?><?php } ?></div>
			</div>

			</h4>
			</div>

			<div id="geraet<?php echo $geraet['gid']; ?>" class="collapse" aria-labelledby="heading<?php echo $geraet['gid']; ?>" data-parent="#accordion">
			<div class="card-body bg-light">
				<div class="row">
					<div class="col-5">Hersteller:</div><div class="col-7" style="white-space:nowrap;"><?php echo $geraet['hersteller']; ?></div>
					<div class="col-5">Typ:</div><div class="col-7" style="white-space:nowrap;"><?php echo $geraet['typ']; ?></div>
					<div class="col-5">Seriennummer:</div><div class="col-7" style="white-space:nowrap;"><?php echo $geraet['seriennummer']; ?></div>
					<div class="col-5">Aktiv:</div><div class="col-7"><?php if($geraet['aktiv']=='0') { echo "nein"; } else { echo "ja"; } ?></div>
					<div class="col-5">Hinzugefügt:</div><div class="col-7" style="white-space:nowrap;"><?php $blubb = new DateTime($geraet['hinzugefuegt']); echo $blubb->format('d.m.Y');  ?></div>
					<div class="col-5">Schutzklasse:</div><div class="col-7"><?php echo $geraet['schutzklasse']; ?></div>
					<div class="col-5">letzte Prüfung:</div><div class="col-7"><?php echo $geraet['letztesdatum']?>  <?php if($geraet['letztesdatum']) { echo '('.$geraet['anzahl'].')'; } ?> </div>
					<div class="col-5">Beschreibung:</div><div class="col-7"><?php echo $geraet['beschreibung']; ?></div><br>
					<div class="col" style="border: 1px solid #343a40;">

					<?php if ($product_typ_pic['pic_exist']) { ?>
					<img  class="mx-auto d-block" src="<?php echo $product_typ_pic['url_orginal'] ?>" height="300px" alt="Responsive image">
					<?php } else {
					echo 'kein Foto';?>
				
					<?php } ?></div>
				</div>
<<<<<<< HEAD
				<br>
				<div id="1" class="btn-group-lg btn-group-vertical text-right btn-group" role="group" aria-label="options" style="width:100%">
				<?php if ($geraet['schutzklasse']<=4) { ?>
							<a href="<?php if($geraet) { echo site_url('pruefung/new/'.$geraet['gid']); } ?>" class="<?php if(!$geraet) { echo "d-none"; } ?> btn btn-success <?php if($geraet['aktiv']=='0' || $this->session->userdata('level')>='3') { echo " disabled"; } ?>"><span class="iconify icon:typcn:document-add icon-width:50 icon-height:50"></span> Neue Prüfung</a><?php } ?>
=======
				
				<div id="1" class="btn-group-lg btn-group-vertical text-right btn-group" role="group" aria-label="options" style="width:100%">

							<a href="<?php if($geraet) { echo site_url('pruefung/new/'.$geraet['gid']); } ?>" class="<?php if(!$geraet) { echo "d-none"; } ?> btn btn-success <?php if($geraet['aktiv']=='0' || $this->session->userdata('level')>='3') { echo " disabled"; } ?>"><span class="iconify icon:typcn:document-add icon-width:50 icon-height:50"></span> Neue Prüfung</a>
>>>>>>> 10346586e10449e2b380656870ba181159d8dea2
							<a href="<?php echo site_url('geraete/index/'.$geraet['oid']); ?>" class="<?php if($ort) { echo "d-none"; } ?> btn btn-primary btn"><span class="iconify" data-icon="ic:baseline-room" data-width="50" data-height="50"></span> Ort</a>
							<a href="<?php echo site_url('geraete/edit/'.$geraet['gid']); ?>" class="btn btn-secondary <?php if($this->session->userdata('level')=='3') { echo " disabled"; }?>"><span class="iconify icon:typcn:edit icon-width:50 icon-height:50"></span> edit</a>
						</div>
<br><br>
<<<<<<< HEAD
				<div id="2" class="text-right btn-group" role="group" aria-label="options" style="width:100%"><?php if ($geraet['schutzklasse']<=4) { ?>
				<a href="<?php echo site_url('pruefung/index/'.$geraet['gid']); ?>" class="btn btn-primary <?php if($geraet['aktiv']=='0') { echo " disabled"; } ?>"><span class="iconify icon:typcn:clipboard icon-width:50 icon-height:50"></span> Prüfungen</a><?php } ?>
=======
				<div id="2" class="text-right btn-group" role="group" aria-label="options" style="width:100%">
				<a href="<?php echo site_url('pruefung/index/'.$geraet['gid']); ?>" class="btn btn-primary <?php if($geraet['aktiv']=='0') { echo " disabled"; } ?>"><span class="iconify icon:typcn:clipboard icon-width:50 icon-height:50"></span> Prüfungen</a>
>>>>>>> 10346586e10449e2b380656870ba181159d8dea2

				<a href="<?php echo site_url('geraete/delete/'.$geraet['gid']); ?>" class="btn btn-danger <?php if($this->session->userdata('level')>='2') { echo " disabled"; }?>"><span class="iconify icon:typcn:delete icon-width:50 icon-height:50"></span> delete</a>


				</div>
				
					</div>
					</div>
					</div>










		<?php
	} ?>
	</div>




<?php }
?>
</div>

