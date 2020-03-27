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
	
    $( "#hinzugefuegt" ).datepicker({ dateFormat: 'yy-mm-dd' });
});
</script>






<h1>Gerät hinzufügen/bearbeiten</h1>

<?php
echo form_open('geraete/edit/'.$geraet['gid']);
echo validation_errors();
?>
<input type="hidden" name="gid" value="<?php echo $geraet['gid']; ?>">
<div class="row">
 <div class="col-md-6">
	
<form>
  <div class="form-group row">
    <label for="orte" class="col-sm-5 col-form-label">Ort*</label>
    <div class="col-sm-7">
      <input type="text" class="form-control" id="orte" value="<?php echo $geraet['ortsname']; ?>" required>
      <input type="hidden" id="oid" name="oid" value="<?php echo $geraet['oid']; ?>">
    </div>
  </div>
  <div class="form-group row">
    <label for="name" class="col-sm-5 col-form-label">Name*</label>
    <div class="col-sm-7">
      <input type="text" class="form-control" name="name" id="name" value="<?php echo $geraet['name']; ?>" required>
    </div>
  </div>
  <div class="form-group row">
    <label for="hersteller" class="col-sm-5 col-form-label">Hersteller</label>
    <div class="col-sm-7">
      <input type="text" class="form-control" name="hersteller" id="hersteller" value="<?php echo $geraet['hersteller']; ?>">
    </div>
  </div>
  <div class="form-group row">
    <label for="typ" class="col-sm-5 col-form-label">Typ*</label>
    <div class="col-sm-7">
      <input type="text" class="form-control" name="typ" id="typ" value="<?php echo $geraet['typ']; ?>" required>
    </div>
  </div>
  <div class="form-group row">
    <label for="seriennummer" class="col-sm-5 col-form-label">seriennummer</label>
    <div class="col-sm-7">
      <input type="text" class="form-control" name="seriennummer" id="seriennummer" value="<?php echo $geraet['seriennummer']; ?>">
    </div>
  </div>
  <hr>
  <div class="form-group row">
    <label for="nennspannung" class="col-sm-5 col-form-label">Nennspannung (V)</label>
    <div class="col-sm-7">
      <input type="text" class="form-control" name="nennspannung" id="nennspannung" value="<?php echo $geraet['nennspannung']; ?>">
    </div>
  </div>
  <div class="form-group row">
    <label for="nennstrom" class="col-sm-5 col-form-label">Nennstrom (A)</label>
    <div class="col-sm-7">
      <input type="text" class="form-control" name="nennstrom" id="nennstrom" value="<?php echo $geraet['nennstrom']; ?>">
    </div>
  </div>
  <div class="form-group row">
    <label for="leistung" class="col-sm-5 col-form-label">Leistung (W)</label>
    <div class="col-sm-7">
      <input type="text" class="form-control" name="leistung" id="leistung" value="<?php echo $geraet['leistung']; ?>">
    </div>
  </div>
  <div class="form-group row">
    <label for="hinzugefuegt" class="col-sm-5 col-form-label">hinzugefuegt</label>
    <div class="col-sm-7">
      <input type="text" class="form-control" name="hinzugefuegt" id="hinzugefuegt" value="<?php echo $geraet['hinzugefuegt']; ?>">
    </div>
  </div>
  

  <fieldset class="form-group">
    <div class="row">
      <legend class="col-form-label col-sm-5 pt-0">Aktiv</legend>
      <div class="col-sm-7">
        <div class="form-check">
          <input class="form-check-input" type="radio" name="aktiv" id="aktiv" value="1" <?php if($geraet['aktiv']) { echo 'checked'; } ?>>
          <label class="form-check-label" for="aktiv">aktiv</label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="aktiv" id="inaktiv" value="0" <?php if(!$geraet['aktiv']) { echo 'checked'; } ?>>
          <label class="form-check-label" for="inaktiv">inaktiv</label>
        </div>
       
      </div>
    </div>
  </fieldset>
  <fieldset class="form-group">
    <div class="row">
      <legend class="col-form-label col-sm-5 pt-0">Schutzklasse*</legend>
      <div class="col-sm-7">
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
       
      </div>
    </div>
  </fieldset>
   <fieldset class="form-group">
    <div class="row">
      <legend class="col-form-label col-sm-5 pt-0">Verlängerungskabel</legend>
      <div class="col-sm-7">
        <div class="form-check">
          <input class="form-check-input" type="radio" name="verlaengerungskabel" id="verlaengerungskabel0" data-toggle="collapse" data-target=".collapseOne.show" value="0" <?php if(!$geraet['verlaengerungskabel']) { echo 'checked'; } ?>>
          <label class="form-check-label" for="verlaengerungskabel0">nein</label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="verlaengerungskabel" id="verlaengerungskabel1" data-toggle="collapse" data-target=".collapseOne:not(.show)" value="1" <?php if($geraet['verlaengerungskabel']) { echo 'checked'; } ?>>
          <label class="form-check-label" for="verlaengerungskabel1">ja</label>
        </div>
       
      </div>
    </div>
     
  </fieldset>
   <div class="collapseOne panel-collapse collapse">
  <div class="form-group row">
    <label for="kabellaenge" class="col-sm-5 col-form-label">Kabellänge (m)</label>
    <div class="col-sm-7">
      <input type="text" class="form-control" name="kabellaenge" id="kabellaenge" value="<?php echo $geraet['kabellaenge']; ?>">
    </div>
  </div>
</div>
  <div class="form-group row">
    <label for="beschreibung" class="col-sm-5 col-form-label">Beschreibung</label>
    <div class="col-sm-7">
      <textarea class="form-control" rows="3" name="beschreibung" id="beschreibung" value="<?php echo $geraet['beschreibung']; ?>"></textarea>
    </div>
  </div>
  
  






<br>
<input type="submit" class="btn btn-primary btn-lg btn-block" value="speichern">
</form>

</div>
 <div class="col-6"  style="width:50%"></div>
 
</div>