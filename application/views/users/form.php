
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
 <div class="col-md-6">
	
<form>
<div class="form-group row">
    <label for="orte" class="col-sm-5 col-form-label">Ort*</label>
    <div class="col-sm-7">
      <input type="text" class="form-control" id="orte" value="<?php echo $user['ortsname']; ?>" required>
      <!-- hidden -->
      <input type="hidden" id="user_oid" name="user_oid" value="<?php echo $user['user_oid']; ?>">
    </div>
  </div>
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
    <label for="name" class="col-sm-5 col-form-label">password*</label>
    <div class="col-sm-7">
      <input type="password" class="form-control" name="user_password" id="user_password" value="<?php echo $user['user_password']; ?>">
    </div>
  </div>
  <div class="form-group row">
    <label for="name" class="col-sm-5 col-form-label">Level*</label>
    <div class="col-sm-7">
      <input type="text" class="form-control" name="user_level" id="user_level" value="<?php echo $user['user_level']; ?>" required>
    </div>
  </div>
  <div class="form-group row">
    <label for="name" class="col-sm-5 col-form-label">Firma ID*</label>
    <div class="col-sm-7">
      <input type="text" class="form-control" name="user_firmaid" id="user_firmaid" value="<?php echo $user['user_firmaid']; ?>" required>
    </div>
  </div>

  
  <div class="form-group row">
    <label for="Messgerät" class="col-sm-5 col-form-label">Messgerät</label>
    <div class="col-sm-7">
    	<select name="user_mid">
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
<input type="submit" class="btn btn-primary btn-lg btn-block" value="speichern">
</form>

</div>
 <div class="col-6"  style="width:50%"></div>

</div>


