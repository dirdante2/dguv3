

<div class="row">
 <div class="col">
 	 

 <h1>Orte</h1>



<div class="btn-group" role="group" aria-label="options" style="width:100%">
<a href="<?php echo site_url('orte/edit'); ?>" class="btn btn-success"><span class="iconify icon:typcn:document-add icon-width:50 icon-height:50"></span> Ort hinzufügen</a>
		

</div>
</div>

</div>
<br>


<div class="btn-group btn-group-sm" role="group" aria-label="options" style="width:100%">
<button class="btn btn-outline-dark" type="button" data-toggle="collapse" data-target="#suche_ok" aria-expanded="false" aria-controls="suche_ok">ok</button>
<button class="btn btn-warning" type="button" data-toggle="collapse" data-target="#suche_keinegeraete" aria-expanded="false" aria-controls="suche_keinegeraete">keine Geräte</button>


</div>
<br><br>
<!-- table-hover table-bordered table-sm table-striped -->


<?php

if(count($orte)==0) {

?>

keine geräte vorhanden

<?php

} else { ?>

<div id="accordion" class="scroll" style="width:100%">

<?php	foreach($orte as $ort) {

		?>	
		
		<div class="card collapse multi-collapse show" style="border: 1px solid #343a40;" id='<?php if($ort['geraeteanzahl']=='0') { echo "suche_keinegeraete"; } else { echo 'suche_ok';} ?>'> 
  
		
		<div id="heading<?php echo $ort['oid']; ?>" class="card-header <?php if($ort['geraeteanzahl']=='0') { echo "bg-warning"; } ?> " data-toggle="collapse" data-target="#ort<?php echo $ort['oid']; ?>" aria-expanded="true" aria-controls="ort<?php echo $ort['oid']; ?>">

			<h4 class="mb-0" >
			<div class="row">	
			<div class="col-6 text-left" id="<?php echo $ort['oid']; ?>"><?php  echo $ort['name']; ?> </div><div class="col-6 text-right" id="<?php echo $ort['oid']; ?>"><?php if($this->session->userdata('level')=='1'){?><?php echo $ort['firma_name']; ?><?php } ?></div>
			</div>
				
			</h4>
			</div>
			
			<div id="ort<?php echo $ort['oid']; ?>" class="collapse" aria-labelledby="heading<?php echo $ort['oid']; ?>" data-parent="#accordion">
			<div class="card-body bg-light">
				<div class="row" id="<?php echo $ort['oid']; ?>">
					<div class="col-5">Beschreibung:</div><div class="col-7" style="white-space:nowrap;"><?php echo $ort['beschreibung']; ?></div>
					<div class="col-5">Geräteanzahl:</div><div class="col-7" style="white-space:nowrap;"><?php echo $ort['geraeteanzahl']; ?></div>
					
				</div>

					<div id="1" class="text-right btn-group" role="group" aria-label="options" style="width:100%">
							
							<a href="<?php echo site_url('geraete/index/'.$ort['oid']); ?>" class="btn btn-primary btn"><span class="iconify" data-icon="ic:baseline-room" data-width="50" data-height="50"></span> Geräte</a>
							<a href="<?php echo site_url('orte/edit/'.$ort['oid']); ?>" class="btn btn-secondary <?php if($this->session->userdata('level')=='3') { echo " disabled"; }?>"><span class="iconify icon:typcn:edit icon-width:50 icon-height:50"></span> edit</a>
							<a href="<?php echo site_url('orte/delete/'.$ort['oid']); ?>" class="btn btn-danger <?php if($this->session->userdata('level')>='2') { echo " disabled"; }?>"><span class="iconify icon:typcn:delete icon-width:50 icon-height:50"></span> delete</a>
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

