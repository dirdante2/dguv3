<h1>Prüfer hinzufügen/bearbeiten</h1>

<?php

echo form_open('pruefer/edit/'.$pruefer['pid']);
echo validation_errors();

?>
<input type="hidden" name="pid" value="<?php echo $pruefer['pid'] ?>">
<div class="row">
 <div class="col-lg-6 col-md">
<form>

  <div class="form-group row">
  <label for="name" class="col-sm-3 col-form-label">Name*</label>
<div class="col-sm-9">
<input type="text" name="name" class="form-control" value="<?php echo $pruefer['name'] ?>">
</div>
  </div>


<div class="form-group row">
    <label for="name" class="col-sm-3 col-form-label">Beschreibung</label>
    <div class="col-sm-9">
      <input type="text" class="form-control" name="beschreibung" id="beschreibung" value="<?php echo $pruefer['beschreibung']; ?>" >
    </div>
  </div>


<?php if($this->session->userdata('level')=='1'){?>
<div class="form-group row">
    <label for="Firma" class="col-sm-3 col-form-label">Firma</label>
    <div class="col-sm-9">
       	<select name="pruefer_firmaid" class="form-control">
         
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

