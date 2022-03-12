<h1>Ort hinzufügen/bearbeiten</h1>

<?php

echo form_open('orte/edit/'.$ort['oid']);
echo validation_errors();

?>
<input type="hidden" name="oid" value="<?php echo $ort['oid'] ?>">
<div class="row">
 <div class="col-lg-6 col-md">
	
<form>

  <div class="form-group row">
  <label for="name" class="col-sm-4 col-form-label">Name*</label>
<div class="col-sm-8">
<input type="text" name="name" class="form-control" value="<?php echo $ort['name'] ?>">zb. Nummernschild<br><br>
</div>
  </div>


<div class="form-group row">
    <label for="name" class="col-sm-4 col-form-label">Beschreibung*</label>
    <div class="col-sm-8">
      <input type="text" class="form-control" name="beschreibung" id="beschreibung" value="<?php echo $ort['beschreibung']; ?>" >zb. Name des Besitzers<br><br>
    </div>
  </div>


<?php if($this->session->userdata('level')=='1'){?>
<div class="form-group row">
    <label for="Firma" class="col-sm-4 col-form-label">Firma</label>
    <div class="col-sm-8">
       	<select name="orte_firmaid" class="form-control">
         
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

 </div>



