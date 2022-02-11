<h1>Ort hinzufügen/bearbeiten</h1>

<?php

echo form_open('orte/edit/'.$ort['oid']);
echo validation_errors();

?>
<input type="hidden" name="oid" value="<?php echo $ort['oid'] ?>">
<div class="row">
 <div class="col-md-6">
	
<form>

  <div class="form-group row">
  <label for="name" class="col-sm-5 col-form-label">Name*<br>zb. Nummernschild</label>
<div class="col-sm-7">
<input type="text" name="name" value="<?php echo $ort['name'] ?>">
</div>
  </div>


<div class="form-group row">
    <label for="name" class="col-sm-5 col-form-label">Beschreibung*<br>zb. Name des Besitzers</label>
    <div class="col-sm-7">
      <input type="text" class="form-control" name="beschreibung" id="beschreibung" value="<?php echo $ort['beschreibung']; ?>" >
    </div>
  </div>


<?php if($this->session->userdata('level')=='1'){?>
<div class="form-group row">
    <label for="Firma" class="col-sm-5 col-form-label">Firma</label>
    <div class="col-sm-7">
       	<select name="orte_firmaid">
         
    		<?php
    		foreach($firmen as $f) {
    		    echo '<option value="'.$f['firmen_firmaid'].'"';
    		    
                
    		    	if($f['firmen_firmaid'] == $this->session->userdata('firmaid')){
    		        echo ' selected';
    		    	}
    		    

    				echo '>'.$f['firma_name'].'</option>';
    		}
    		?>
    	</select>
    </div>
  </div>
        <?php } ?>
<br>
<input type="submit" class="btn btn-primary btn-lg btn-block" value="speichern">
</form>

</div>
 <div class="col-6"  style="width:50%"></div>
 </div>



