
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
	
    
});
</script>


<h1>user hinzufügen/bearbeiten</h1>

<?php

echo form_open('users/edit/'.$user['user_id']);
echo validation_errors();

?>


user id<input type="text" name="user_id" value="<?php echo $user['user_id']; ?>">
<div class="row">
 <div class="col-md-6">
	
<form>
<div class="form-group row">
    <label for="orte" class="col-sm-5 col-form-label">Ort*</label>
    <div class="col-sm-7">
      <input type="text" class="form-control" id="orte" value="<?php echo $user['user_oid']; ?>" required>
      <!-- hidden -->
      <input type="text" id="oid" name="oid" value="<?php echo $user['user_oid']; ?>">
    </div>
  </div>
  <div class="form-group row">
    <label for="name" class="col-sm-5 col-form-label">Name*</label>
    <div class="col-sm-7">
      <input type="text" class="form-control" name="name" id="name" value="<?php echo $user['user_name']; ?>" required>
    </div>
  </div>


  
  <div class="form-group row">
    <label for="Messgerät" class="col-sm-5 col-form-label">Messgerät</label>
    <div class="col-sm-7">
    	<select name="mid">
    		<?php
    		foreach($messgeraete as $m) {
    		    echo '<option value="'.$m['mid'].'"';
    		    
    		    if($this->session->userdata('usermid')){
    		    	 if($this->session->userdata('usermid') == $m['mid']){
    		    	 	
    		    	echo ' selected';
    		    	}
    		    } else {
    		    	if($m['mid'] == $user['user_mid']){
    		        echo ' selected';
    		    	}
    		    
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
       	<select name="pid">
    		<?php
    		foreach($pruefer as $p) {
    		    echo '<option value="'.$p['pid'].'"';
    		    
    		    if($this->session->userdata('userpid')){
    		    	 if($this->session->userdata('userpid') == $p['pid']){
    		    	 	
    		    	echo ' selected';
    		    	}
    		    } else {
    		    	if($p['pid'] == $geraet['pid']){
    		        echo ' selected';
    		    	}
    		    
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


