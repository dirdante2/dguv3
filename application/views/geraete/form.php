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
                console.log(data);
                	return {
	                    label: value.dummyname,
                    	value: key
                	};
            	}));
			})
		},
    
		select: function( event, ui ) {

      $.getJSON("<?php echo site_url(); ?>/geraete/jsongid/" + ui.item.value, function (data) {
	            
                console.log(data);
                
                $( "#typ" ).val( data.typ );
		          	$( "#name" ).val( data.name );
                $( "#hersteller" ).val( data.hersteller );
                $( "#leistung" ).val( data.leistung );	
                $( "#nennspannung" ).val( data.nennspannung );	
                $( "#nennstrom" ).val( data.nennstrom );
                $( "#kabellaenge" ).val( data.kabellaenge );
               
                // if (data.aktiv == 1) {
                //   radiobtna = document.getElementById("aktiv");
                // } else {
                //   radiobtna = document.getElementById("inaktiv");
                // }
                // radiobtna.checked = true;

                if (data.verlaengerungskabel == 1) {
                  radiobtnk = document.getElementById("verlaengerungskabel1");
                } else {
                  radiobtnk = document.getElementById("verlaengerungskabel0");
                }
                radiobtnk.checked = true;

                if (data.schutzklasse == 1) {
                  radiobtns = document.getElementById("schutzklasse1");
                } else if (data.schutzklasse == 2) {
                  radiobtns = document.getElementById("schutzklasse2");
                } else if (data.schutzklasse == 3) {
                  radiobtns = document.getElementById("schutzklasse3");
                } else if (data.schutzklasse == 4) {
                  radiobtns = document.getElementById("schutzklasse4");
                } else if (data.schutzklasse == 5) {
                  radiobtns = document.getElementById("schutzklasse5");
                }
                radiobtns.checked = true;


            });





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
#print_r($geraet);
?>
<input type="hidden" name="gid" value="<?php echo $geraet['gid']; ?>">
<div class="row">
 <div class="col-lg-6 col-md">
	
<form id="gdetails" name="gdetails">
  <div class="form-group row">
    <label for="orte" class="col-sm-4 col-form-label">Ort*</label>
    <div class="col-sm-8">
      <input type="text" class="form-control" id="orte" placeholder="name eingeben zum suchen" value="<?php if($geraet['ortsname']) {echo $geraet['ortsname']; echo '('.$geraet['orte_beschreibung'].')';} ?>">
      <input type="hidden" id="oid" name="oid" value="<?php echo $geraet['oid']; ?>">
    </div>
  </div>
  <div class="form-group row">
    <label for="Lager" class="col-sm-4 col-form-label">Lager</label>
    <div class="col-sm-8">
       	<select name="lagerorte" class="form-control"> 
         <option value="NULL">kein Lager</option>
    		<?php
    		foreach($lagerorte as $lager) {
    		    echo '<option value="'.$lager['oid'].'"';
    		     
    				echo '>'.$lager['name'].' ('.$lager['beschreibung'].')</option>';
    		}
    		?>
    	</select>
    </div>
  </div>

  <div class="form-group row">
    <label for="name" class="col-sm-4 col-form-label">Name*</label>
    <div class="col-sm-8">
      <input type="text" maxlength="40" class="form-control" name="name" id="name" placeholder="Typ oder name eingeben zum suchen" value="<?php echo $geraet['name']; ?>" required>
    </div>
  </div>
  <div class="form-group row">
    <label for="hersteller" class="col-sm-4 col-form-label">Hersteller</label>
    <div class="col-sm-8">
      <input type="text" class="form-control" name="hersteller" id="hersteller" value="<?php echo $geraet['hersteller']; ?>">
    </div>
  </div>
  <div class="form-group row">
    <label for="typ" class="col-sm-4 col-form-label">Typ*</label>
    <div class="col-sm-8">
      <input type="text" class="form-control" name="typ" id="typ" value="<?php echo $geraet['typ']; ?>" required>
    </div>
  </div>
  <div class="form-group row">
    <label for="seriennummer" class="col-sm-4 col-form-label">seriennummer</label>
    <div class="col-sm-8">
      <input type="text" class="form-control" name="seriennummer" id="seriennummer" value="<?php echo $geraet['seriennummer']; ?>">
    </div>
  </div>
  <?php if($this->session->userdata('level')=='1'){?>
<div class="form-group row">
    <label for="Firma" class="col-sm-4 col-form-label">Firma</label>
    <div class="col-sm-8">
       	<select name="geraete_firmaid" class="form-control">
         
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
  <hr>
  <div class="form-group row">
    <label for="nennspannung" class="col-sm-4 col-form-label">Nennspannung (V)</label>
    <div class="col-sm-8">
      <input type="text" class="form-control" name="nennspannung" id="nennspannung" placeholder="zB 230" value="<?php echo $geraet['nennspannung']; ?>">
    </div>
  </div>
  <div class="form-group row">
    <label for="nennstrom" class="col-sm-4 col-form-label">Nennstrom (A)</label>
    <div class="col-sm-8">
      <input type="text" class="form-control" name="nennstrom" id="nennstrom" placeholder="zB 3.3" value="<?php echo $geraet['nennstrom']; ?>">
    </div>
  </div>
  <div class="form-group row">
    <label for="leistung" class="col-sm-4 col-form-label">Leistung (W)</label>
    <div class="col-sm-8">
      <input type="text" class="form-control" name="leistung" id="leistung" placeholder="zB 400" value="<?php echo $geraet['leistung']; ?>">
    </div>
  </div>
  <div class="form-group row">
    <label for="hinzugefuegt" class="col-sm-4 col-form-label">hinzugefuegt</label>
    <div class="col-sm-8">
      <input type="text" class="form-control" name="hinzugefuegt" id="hinzugefuegt" value="<?php echo $geraet['hinzugefuegt']; ?>">
    </div>
  </div>
  

  <fieldset class="form-group">
    <div class="row">
      <legend class="col-form-label col-sm-4 pt-0">Aktiv</legend>
      <div class="col-sm-8">
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
      <legend class="col-form-label col-sm-4 pt-0">Schutzklasse*</legend>
      <div class="col-sm-8">
        <div class="form-check">
          <input class="form-check-input" type="radio" name="schutzklasse" id="schutzklasse1" value="1" <?php if($geraet['schutzklasse']=='1') { echo 'checked'; } ?> required>
          <label class="form-check-label" for="1">I</label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="schutzklasse" id="schutzklasse2" value="2" <?php if($geraet['schutzklasse']=='2') { echo 'checked'; } ?>>
          <label class="form-check-label" for="2">II</label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="schutzklasse" id="schutzklasse3" value="3" <?php if($geraet['schutzklasse']=='3') { echo 'checked'; } ?>>
          <label class="form-check-label" for="3">III</label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="schutzklasse" id="schutzklasse4" value="4" <?php if($geraet['schutzklasse']=='4') { echo 'checked'; } ?>>
          <label class="form-check-label" for="4">Leiter</label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="schutzklasse" id="schutzklasse5" value="5" <?php if($geraet['schutzklasse']=='5') { echo 'checked'; } ?>>
          <label class="form-check-label" for="5">Anderes Gerät</label>
        </div>
       
      </div>
    </div>
  </fieldset>
   <fieldset class="form-group">
    <div class="row">
      <legend class="col-form-label col-sm-4 pt-0">Verlängerungskabel</legend>
      <div class="col-sm-8">
        <div class="form-check">
          <input class="form-check-input" type="radio" name="verlaengerungskabel" id="verlaengerungskabel0" data-toggle="collapse" data-target=".collapseOne.show" value="0" <?php if($geraet['verlaengerungskabel']=='0' || $geraet['verlaengerungskabel']==null) { echo 'checked'; } ?>>
          <label class="form-check-label" for="verlaengerungskabel0">nein</label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="verlaengerungskabel" id="verlaengerungskabel1" data-toggle="collapse" data-target=".collapseOne:not(.show)" value="1" <?php if($geraet['verlaengerungskabel']=='1') { echo 'checked'; } ?>>
          <label class="form-check-label" for="verlaengerungskabel1">ja</label>
        </div>
       
      </div>
    </div>
     
  </fieldset>
   <!-- <div class="collapseOne panel-collapse collapse"> -->
  <div class="form-group row">
    <label for="kabellaenge" class="col-sm-4 col-form-label">Kabellänge (m)</label>
    <div class="col-sm-8">
      <input type="text" class="form-control" name="kabellaenge" id="kabellaenge" value="<?php echo $geraet['kabellaenge']; ?>">
    </div>
  <!-- </div> -->
</div>
  <div class="form-group row">
    <label for="beschreibung" class="col-sm-4 col-form-label">Beschreibung</label>
    <div class="col-sm-8">
      <input type="textarea" class="form-control" rows="3" name="beschreibung" id="beschreibung" value="<?php echo $geraet['beschreibung']; ?>">
    </div>
  </div>
  
  






<br>
<input type="submit" class="btn btn-primary btn-lg btn-block" value="speichern">
</form>
<br><br>
</div>
<<<<<<< HEAD
 <div class="col-lg-4"  >

 <?php if ($product_typ_pic['pic_exist']) { ?>
	<img  class="mx-auto d-block" src="<?php echo $product_typ_pic['url_orginal'] ?>" height="300px" alt="Responsive image">
<?php } else {
	echo 'error';?>
	<?php echo $product_typ_pic['url_orginal']?>
	<?php } ?>

 </div>
=======
 <div class="col-lg-6"  ></div>
>>>>>>> 10346586e10449e2b380656870ba181159d8dea2
 
</div>