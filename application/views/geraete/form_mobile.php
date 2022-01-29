<script>
$().ready(function() {
		$('#orte').autocomplete({
	    source: function (request, response) {
        	$.getJSON("<?php echo site_url(); ?>/orte/json/" + request.term, function (data) {
	            response($.map(data, function (value, key) {
                	return {
	                    label: value,
                    	value: key
                	};
            	}));
			})
		},
		select: function( event, ui ) {
       	 	$( "#orte" ).val( ui.item.label );
			$( "#oid" ).val( ui.item.value );			
    	    return false;
	    },
    	minLength: 2,
	    delay: 100
	});
	
  $('#name').autocomplete({
	    source: function (request, response) {
        	$.getJSON("<?php echo site_url(); ?>/geraete/json/" + request.term, function (data) {
	            response($.map(data, function (value, key) {
                	return {
	                    label: value,
                    	value: key
                	};
            	}));
			})
		},
    
		select: function( event, ui ) {
       	 	$( "#typ" ).val( ui.item.label );
			$( "#name" ).val( ui.item.value );			
    	    return false;
	    },
    	minLength: 2,
	    delay: 100
	});

    $( "#hinzugefuegt" ).datepicker({ dateFormat: 'yy-mm-dd' });
});
</script>






<h1>Gerät hinzufügen/bearbeiten</h1>
<br>
<?php
echo form_open('geraete/edit/'.$geraet['gid']);
echo validation_errors();
?>
<input type="hidden" name="gid" value="<?php echo $geraet['gid']; ?>">
<div class="row" style="width=100%; border: 0px solid #0000;" > 
 <div class="col">
	
<form>
  <div class="form-group row">
    <label for="orte" class="col-sm-5 col-form-label">Ort*</label>
    
      <input type="text" class="form-control form-control-lg" id="orte" placeholder="name eingeben zum suchen" value="<?php echo $geraet['ortsname']; ?>" required>
      <input type="hidden" id="oid" name="oid" value="<?php echo $geraet['oid']; ?>">
    
  </div>
  <br>
  <div class="form-group row">
    <label for="name" class="col-sm-5 col-form-label">Name*</label>
   
      <input type="text" maxlength="40" class="form-control form-control-lg" name="name" id="name" placeholder="Typ oder name eingeben zum suchen" value="<?php echo $geraet['name']; ?>" required>
    
  </div>
  <br>
  <div class="form-group row">
    <label for="hersteller" class="col-sm-5 col-form-label">Hersteller</label>
    
      <input type="text" class="form-control form-control-lg" name="hersteller" id="hersteller" value="<?php echo $geraet['hersteller']; ?>">
    
  </div>
  <br>
  <div class="form-group row">
    <label for="typ" class="col-sm-5 col-form-label">Typ*</label>
    
      <input type="text" class="form-control form-control-lg" name="typ" id="typ" value="<?php echo $geraet['typ']; ?>" required>
   
  </div>
  <br>
  <div class="form-group row">
    <label for="seriennummer" class="col-sm-5 col-form-label">seriennummer</label>
    
      <input type="text" class="form-control form-control-lg" name="seriennummer" id="seriennummer" value="<?php echo $geraet['seriennummer']; ?>">
    
  </div>
  
  <?php if($this->session->userdata('level')=='1'){?><br>
<div class="form-group row">
    <label for="Firma" class="col col-form-label">Firma</label>
    
       	<select name="geraete_firmaid" class="form-control form-control-lg custom-select-lg">
         
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
  <hr>
  <br>
  <div class="form-group row">
    <label for="nennspannung" class="col-sm-5 col-form-label">Nennspannung (V)</label>
    
      <input type="text" class="form-control form-control-lg" name="nennspannung" id="nennspannung" placeholder="zB 230" value="<?php echo $geraet['nennspannung']; ?>">
    
  </div>
  <br>
  <div class="form-group row">
    <label for="nennstrom" class="col-sm-5 col-form-label">Nennstrom (A)</label>
  
      <input type="text" class="form-control form-control-lg" name="nennstrom" id="nennstrom" placeholder="zB 3.3" value="<?php echo $geraet['nennstrom']; ?>">
    
  </div>
  <br>
  <div class="form-group row">
    <label for="leistung" class="col-sm-5 col-form-label">Leistung (W)</label>
  
      <input type="text" class="form-control form-control-lg" name="leistung" id="leistung" placeholder="zB 400" value="<?php echo $geraet['leistung']; ?>">
    
  </div>
  <br>
  <div class="form-group row">
    <label for="hinzugefuegt" class="col-sm-5 col-form-label">hinzugefuegt</label>
   
      <input type="text" class="form-control form-control-lg" name="hinzugefuegt" id="hinzugefuegt" value="<?php echo $geraet['hinzugefuegt']; ?>">
    
  </div>
  <br>

  <fieldset class="form-group">
    <div class="row" style="width:100%;">
      <legend class="col-form-label col-sm-5">Aktiv</legend>
      <div class="form-check"> 
          <input class="form-check-input" type="radio" name="aktiv" id="aktiv" value="1" <?php if($geraet['aktiv']) { echo 'checked'; } ?>>
          <label class="form-check-label" for="aktiv">aktiv</label>
          </div>
          <br><br>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="aktiv" id="inaktiv" value="0" <?php if(!$geraet['aktiv']) { echo 'checked'; } ?>>
          <label class="form-check-label" for="inaktiv">inaktiv</label>
        </div>
       
      
    </div>
  </fieldset>
  <fieldset class="form-group">
    <div class="row">
      <legend class="col-form-label col-sm-5">Schutzklasse*</legend>
      
        <div class="form-check">
          <input class="form-check-input" type="radio" name="schutzklasse" id="1" value="1" <?php if($geraet['schutzklasse']=='1') { echo 'checked'; } ?> required>
          <label class="form-check-label" for="1">I</label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="schutzklasse" id="2" value="2" <?php if($geraet['schutzklasse']=='2') { echo 'checked'; } ?>>
          <label class="form-check-label" for="2">II</label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="schutzklasse" id="3" value="3" <?php if($geraet['schutzklasse']=='3') { echo 'checked'; } ?>>
          <label class="form-check-label" for="3">III</label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="schutzklasse" id="4" value="4" <?php if($geraet['schutzklasse']=='4') { echo 'checked'; } ?>>
          <label class="form-check-label" for="4">Leiter</label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="schutzklasse" id="5" value="5" <?php if($geraet['schutzklasse']=='5') { echo 'checked'; } ?>>
          <label class="form-check-label" for="5">Anderes Gerät</label>
        </div>
      
    </div>
  </fieldset>
  <br>
   <fieldset class="form-group">
    <div class="row">
      <legend class="col-form-label col-sm-5">Kabel</legend>
      
        <div class="form-check">
          <input class="form-check-input" type="radio" name="verlaengerungskabel" id="verlaengerungskabel0" data-toggle="collapse" data-target=".collapseOne.show" value="0" <?php if(!$geraet['verlaengerungskabel']) { echo 'checked'; } ?>>
          <label class="form-check-label" for="verlaengerungskabel0">nein</label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="verlaengerungskabel" id="verlaengerungskabel1" data-toggle="collapse" data-target=".collapseOne:not(.show)" value="1" <?php if($geraet['verlaengerungskabel']) { echo 'checked'; } ?>>
          <label class="form-check-label" for="verlaengerungskabel1">ja</label>
        </div>
       
    
    </div>
    <br>
  </fieldset>
   <div class="collapseOne panel-collapse collapse <?php if($geraet['verlaengerungskabel']) { echo 'show'; } ?>">
  <div class="form-group row">
    <label for="kabellaenge" class="col-sm-5 col-form-label">Kabellänge (m)</label>
    
      <input type="text" class="form-control form-control-lg" name="kabellaenge" id="kabellaenge" value="<?php echo $geraet['kabellaenge']; ?>">
    </div>
 <br>
</div>
  <div class="form-group row">
    <label for="beschreibung" class="col-sm-5 col-form-label">Beschreibung</label>
    
      <input type="text" class="form-control form-control-lg" rows="3" name="beschreibung" id="beschreibung" value="<?php echo $geraet['beschreibung']; ?>">
    
  </div>
  
  






<br>
<input type="submit" class="btn-lg btn-primary btn-block" value="speichern">
<br>
</form>

</div></div>
