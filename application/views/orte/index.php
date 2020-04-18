
<h1>Orte</h1>
<div class="btn-group pull-right">
<a href="<?php echo site_url('orte/edit'); ?>" class="btn btn-primary"><span class="iconify icon:typcn:document-add icon-width:20 icon-height:20"></span> Ort hinzufügen</a>
<a href="<?php echo base_url(); ?>index.php/orte/html2pdf_listen"  class="btn btn-primary">Übersichten erstellen</a>
              </div>
<br>
<br>

<?php	
if(array_key_exists('button1', $_POST)) { 
            button1($orte);
            echo '<br><br>'; 
        } 
        
function button1($orte) { 
	
	foreach($orte as $ort) {
	
        		$year=date("Y");
        		
        		
        		$ortsid= $ort['oid'];
        		$ortsname= $ort['name'];
        		if (!file_exists('pdf/'.$year.'/'.$ortsname)) { mkdir('pdf/'.$year.'/'.$ortsname, 0755, true); }
        		
            echo "PDF Übersicht ".$ortsname." wurde erstellt"; 
            
           $apikey = $html2pdf_api_key;
$value = 'https://dguv3.qabc.eu/index.php/geraete/geraete/'.$ortsid ; // a url starting with http or an HTML string.  see example #5 if you have a long HTML string
$result = file_get_contents("http://api.html2pdfrocket.com/pdf?apikey=" . urlencode($apikey) . "&value=" .$value ."&username=admin&password=pruefung");
file_put_contents('pdf/'.$year.'/'.$ortsname.'/liste.pdf',$result);
      }
    }
      
     
       ?>
<table class="table" id="table" style="width:100%">
<thead>
<tr>
	<th>ID</th>
	<th>Name</th>
	<th>Beschreiung</th>
	<th>Geräte</th>
	<?php if($this->session->userdata('level')=='1'){?><th>Firma</th><?php } ?>
	<th>PDF erstellt</th>
	<th>Aktion</th>
</tr>
</thead>
<tbody>
<?php

if(count($orte)==0) {

?>

<td colspan="4">Es sind noch keine Orte definiert.</td>

<?php

} else {
	$year=date("Y");
	foreach($orte as $ort) {

		?>
		<tr>
			<td><?php echo $ort['oid']; ?></td>
			<td><?php echo $ort['name']; ?></td>
			<td><?php echo $ort['beschreibung']; ?></td>
			<td><?php echo $ort['geraeteanzahl']; ?></td>
			<?php if($this->session->userdata('level')=='1'){?><td><?php echo $ort['firma_name']; ?></td><?php } ?>
			<td><?php if (file_exists('pdf/'.$year.'/'. $ort['name'].'/liste_'.$ort['name'].'.pdf')) { echo date("d.m.Y", filemtime('pdf/'.$year.'/'. $ort['name'].'/liste_'.$ort['name'].'.pdf')); } else { echo 'no file';} ?></td>
			<td>
				<div class="btn-group btn-group-sm" role="group" aria-label="options">
				<a href="<?php echo site_url('geraete/index/'.$ort['oid']); ?>" class="btn btn-primary"><span class="iconify" data-icon="jam:plug" data-width="20" data-height="20"></span> Geräte</a>
				<!--<a href="<?php echo site_url('geraete/geraete/'.$ort['oid']); ?>" class="btn btn-primary"><span class="iconify" data-icon="si-glyph:document-pdf" data-width="20" data-height="20"></span> Übersicht</a>
				-->
				
				<a href="<?php echo base_url('pdf/'.$year.'/'. $ort['name'].'/liste_'.$ort['name'].'.pdf');?>" target="_blank" class="btn btn-primary <?php if (!file_exists('pdf/'.$year.'/'. $ort['name'].'/liste_'.$ort['name'].'.pdf')) { echo "disabled"; } ?>"><span class="iconify" data-icon="si-glyph:document-pdf" data-width="20" data-height="20"></span> Übersicht</a>
				
			
				<a href="<?php echo site_url('orte/edit/'.$ort['oid']); ?>" class="<?php if($this->session->userdata('level')>='4') { echo " disabled"; }?> btn btn-secondary"><span class="iconify icon:typcn:edit icon-width:20 icon-height:20"></span> edit</a>
				<a href="<?php echo site_url('orte/delete/'.$ort['oid']); ?>" class="<?php if($this->session->userdata('level')>='2') { echo " disabled"; }?> btn btn-danger"><span class="iconify icon:typcn:delete icon-width:20 icon-height:20"></span> delete</a>
				
     
				</div>
			</td>
		</tr>
		<?php
	}
}

?>

</tbody>
</table>

