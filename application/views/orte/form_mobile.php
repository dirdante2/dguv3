<h1>Ort hinzufügen/bearbeiten</h1>
<br>
<?php

echo form_open('orte/edit/'.$ort['oid']);
echo validation_errors();

?>
<input type="hidden" name="oid" value="<?php echo $ort['oid'] ?>">
<div class="row" style="width=100%; border: 1px solid #0000;" > 
 <div class="col">
	
<form>

  <div class="form-group row">
  <label for="name" class="col-sm-5 col-form-label">Name*</label>

<input type="text" class="form-control" id="name" name="name" value="<?php echo $ort['name'] ?>">
</div>
  <br>

<div class="form-group row">
    <label for="name" class="col-sm-5 col-form-label">Beschreibung</label>
    
      <input type="text" class="form-control" name="beschreibung" id="beschreibung" value="<?php echo $ort['beschreibung']; ?>" >
    </div>
  
	<br>

<?php if($this->session->userdata('level')=='1'){?>
<div class="form-group row">
    <label for="Firma" class="col-sm-5 col-form-label">Firma*</label>
    
       	<select name="orte_firmaid" class="form-control form-control-lg custom-select-lg">
         
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
  
        <?php } ?>
<br>
<input type="submit" class="btn btn-primary btn-lg btn-block" value="speichern">
</form>

</div>

 </div>



