
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
			$( "#user_oid" ).val( ui.item.value );
    	    return false;
	    },
    	minLength: 2,
	    delay: 100
	});


});
</script>


<h1>user hinzufügen/bearbeiten</h1>

<?php

echo form_open('users/edit/'.$user['user_id']);
echo validation_errors();

?>


<input type="hidden" name="user_id" value="<?php echo $user['user_id']; ?>">
<div class="row">
 <div class="col-md">

<form>

  <div class="form-group row">
    <label for="name" class="col-sm-5 col-form-label">Name*</label>
    <div class="col-sm-7">
      <input type="text" class="form-control" name="user_name" id="user_name" value="<?php echo $user['user_name']; ?>" required>
    </div>
  </div>
  <div class="form-group row">
    <label for="name" class="col-sm-5 col-form-label">email*</label>
    <div class="col-sm-7">
      <input type="text" class="form-control" name="user_email" id="user_email" value="<?php echo $user['user_email']; ?>" required>
    </div>
  </div>
  <div class="form-group row">
    <label for="name" class="col-sm-5 col-form-label">password</label>
    <div class="col-sm-7">
      <input type="password" class="form-control" name="user_password" id="user_password" value="">
    </div>
  </div>
  <?php if($this->session->userdata('level')=='1'){?>



  <fieldset class="form-group">
    <div class="row">
      <legend class="col-form-label col-sm-5 pt-0">Level*</legend>
      <div class="col-sm-7">
        <div class="form-check">
          <input class="form-check-input" type="radio" name="user_level" id="1" value="1" <?php if($user['user_level']=='1') { echo 'checked'; } ?> required>
          <label class="form-check-label" for="1">1 Admin</label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="user_level" id="2" value="2" <?php if($user['user_level']=='2') { echo 'checked'; } ?>>
          <label class="form-check-label" for="2">2 Prüfer</label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="user_level" id="3" value="3" <?php if($user['user_level']=='3') { echo 'checked'; } ?>>
          <label class="form-check-label" for="3">3 Verwaltung</label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="user_level" id="4" value="4" <?php if($user['user_level']=='4') { echo 'checked'; } ?>>
          <label class="form-check-label" for="4">4 User</label>
        </div>

      </div>

    </div>
  </fieldset>
  <fieldset class="form-group">
    <div class="row">
      <legend class="col-form-label col-sm-5 pt-0">Show link1*</legend>
      <div class="col-sm-7">
        <div class="form-check">

		<input class="form-check-input" type="checkbox" name="user_showlink1" id="user_showlink1" value="1" <?php if($user['user_showlink1']=='1') { echo 'checked'; } ?> >
          <label class="form-check-label" for="user_showlink11">1 website link</label>
		  <br>
		  <input class="form-check-input" type="checkbox" name="user_delete" id="user_delete" value="1" <?php if($user['user_delete']=='1') { echo 'checked'; } ?> >
          <label class="form-check-label" for="user_delete">user_deletek</label>
		  <br>
		  <input class="form-check-input" type="checkbox" name="user_edit" id="user_edit" value="1" <?php if($user['user_edit']=='1') { echo 'checked'; } ?> >
          <label class="form-check-label" for="user_edit">user_edit</label>
		  <br>
		  <input class="form-check-input" type="checkbox" name="user_new" id="user_new" value="1" <?php if($user['user_new']=='1') { echo 'checked'; } ?> >
          <label class="form-check-label" for="user_new">user_new</label>
		  <br>
		  <input class="form-check-input" type="checkbox" name="user_edituser" id="user_edituser" value="1" <?php if($user['user_edituser']=='1') { echo 'checked'; } ?> >
          <label class="form-check-label" for="user_edituser">user_edituser</label>
        </div>



      </div>

    </div>
  </fieldset>
  <div class="form-group row">
    <label for="Firma" class="col-sm-5 col-form-label">Firma</label>
    <div class="col-sm-7">
       	<select name="users_firmaid">
         <option value="0" selected> keins</option>
    		<?php
    		foreach($firmen as $f) {
    		    echo '<option value="'.$f['firmen_firmaid'].'"';


    		    	if($f['firmen_firmaid'] == $user['users_firmaid']){
    		        echo ' selected';
    		    	}


    				echo '>'.$f['firma_name'].'</option>';
    		}
    		?>
    	</select>
    </div>
  </div>

  <?php	}?>
  <div class="form-group row">
    <label for="orte" class="col-sm-5 col-form-label">Ort</label>
    <div class="col-sm-7">
      <input type="text" class="form-control" id="orte" value="<?php echo $user['ortsname']; ?>">
      <!-- hidden -->
      <input type="hidden" id="user_oid" name="user_oid" value="<?php echo $user['user_oid']; ?>">
    </div>
  </div>


  <div class="form-group row">
    <label for="Messgerät" class="col-sm-5 col-form-label">Messgerät</label>
    <div class="col-sm-7">
    	<select name="user_mid">
      <option value="0" selected> keins</option>
    		<?php
    		foreach($messgeraete as $m) {
    		    echo '<option value="'.$m['mid'].'"';


    		    	if($m['mid'] == $user['user_mid']){
    		        echo ' selected';
    		    	}


    		    echo '>'.$m['name'].'</option>';
    		}
    		?>
    	</select>
    </div>
  </div>
  <div class="form-group row">
    <label for="Prüfer" class="col-sm-5 col-form-label">Prüfer</label>
    <div class="col-sm-7">
       	<select name="user_pid">
         <option value="0" selected> keins</option>
    		<?php
    		foreach($pruefer as $p) {
    		    echo '<option value="'.$p['pid'].'"';


    		    	if($p['pid'] == $user['user_pid']){
    		        echo ' selected';
    		    	}


    				echo '>'.$p['name'].'</option>';
    		}
    		?>
    	</select>
    </div>
  </div>


<br>
<input type="submit" class="btn btn-primary btn-lg btn-block" value="speichern"><br><br>
</form>

</div>
 <div class="col-6"  style="width:50%"><br>
 <p>
      <b><u>User Level</u></b><br>
      <b>1 Admin</b><br>
      darf alles<br>

      <b>2 Prüfer</b><br>
      darf keine Geräte löschen<br>
      zugriff Nur auf eigene firma<br>

      <b>3 Verwaltung</b><br>
      Alles drüber<br>
      darf keine Geräte löschen bearbeiten oder neu<br>
      Keine Prüfung löschen bearbeiten oder neu<br>
      keine orte löschen bearbeiten oder neu<br>

      <b>4 User</b><br>
      Alles drüber<br>
      Darf nur eigene firma / Ort sehen<br>
      Nur eigene Geräte sehen bearbeiten</p>

	  <b>delete</b><br>
     	darf sachen löschen</p>

	 <b>edit</b><br>
     	darf sachen bearbeiten</p>

		 <b>new</b><br>
     darf sachen neu erstellen</p>

	 <b>useredit</b><br>
     darf user anlegen bearbeiten kleiner als selbst</p>

 </div>

</div>


