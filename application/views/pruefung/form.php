<script>
$().ready(function() {
			
    $( "#datum" ).datepicker({ dateFormat: 'yy-mm-dd' });
});
</script>

<h1>Prüfung bearbeiten</h1>  <br>
<h2><?php echo $geraet['geraetename'].' ( ID: '.$geraet['gid'].')'; ?> <br>von <?php echo $geraet['ortsname']; ?></h2>
<br>
<div class="row">
<div class="col-3">
						<b>Objekt</b><br><br>
<table  class="table table-sm">
							<tr>
								<td>ID</td>
								<td><?php echo $geraet['gid']; ?></td>
							</tr>
							<tr>
								<td>Ort</td>
								<td><?php echo $geraet['ortsname']; ?></td>
							</tr>
							<tr>
								<td>Name</td>
								<td><?php echo $geraet['name']; ?></td>
							</tr>
							<tr>
								<td>Hersteller</td>
								<td><?php echo $geraet['hersteller']; ?></td>
							</tr>
							<tr>
								<td>Typ</td>
								<td><?php echo $geraet['typ']; ?></td>
							</tr>
							<tr>
								<td>Seriennummer</td>
								<td><?php echo $geraet['seriennummer']; ?></td>
							</tr>
							<tr>
								<td>Beschreibung</td>
								<td><?php echo $geraet['geraetebeschreibung']; ?></td>
							</tr>
						</table>
</div>
<div class="col-3">
						<b> </b><br><br>
<table  class="table table-sm">
							<tr>
								<td>Nennspannung</td>
								<td><?php if($geraet['nennspannung']=='0') { echo "-"; } else { echo $geraet['nennspannung'].'V'; } ?></td>
							</tr>
							<tr>
								<td>Nennstrom</td>
								<td><?php if($geraet['nennstrom']=='0.00') { echo "-"; } else { echo $geraet['nennstrom'].'A'; } ?></td>
							</tr>
							<tr>
								<td>Leistung</td>
								<td><?php if($geraet['leistung']=='0') { echo "-"; } else { echo $geraet['leistung'].'W'; } ?></td>
							</tr>
							<tr>
								<td>Schutzklasse</td>
								<td><?php echo $geraet['schutzklasse']; ?></td>
							</tr>
							<tr>
								<td>Verlängerungskabel</td>
								<td><?php if($geraet['verlaengerungskabel']=='0') { ?>-<?php } else { ?><?php echo $geraet['kabellaenge']; ?>m</td><?php	} ?></td>
							</tr>
							<tr>
								<td>Aktiv</td>
								<td><?php if($geraet['aktiv']=='0') { echo "nein"; } else { echo "ja"; } ?></td>
							</tr>
						
						</table>
</div>
</div>
<?php
echo form_open('pruefung/edit/'.$geraet['pruefungid']);
echo validation_errors();
?>
<div class="row">
<div class="col-md-6">
<form>

  <div class="form-group row">
    <label for="name" class="col-sm-5 col-form-label">Datum</label>
    <div class="col-sm-7">
      <input type="text" class="form-control" name="datum" id="datum" value="<?php echo $geraet['datum']; ?>" required>
    </div>
  </div>
  <div class="form-group row">
    <label for="hersteller" class="col-sm-5 col-form-label">Messgerät</label>
    <div class="col-sm-7">
    	<select name="mid">
    		<?php
    		foreach($messgeraete as $m) {
    		    echo '<option value="'.$m['mid'].'"';
    		    if($m['mid'] == $geraet['mid']) {
    		        echo ' selected';
    		    }
    		    echo '>'.$m['name'].'</option>';
    		}
    		?>
    	</select>
    </div>
  </div>
  <div class="form-group row">
    <label for="hersteller" class="col-sm-5 col-form-label">Prüfer</label>
    <div class="col-sm-7">
       	<select name="pid">
    		<?php
    		foreach($pruefer as $p) {
    		    echo '<option value="'.$p['pid'].'"';
    		    if($p['pid'] == $geraet['pid']) {
    		        echo ' selected';
    		    }
    		    echo '>'.$p['name'].'</option>';
    		}
    		?>
    	</select>
    </div>
  </div>

  <fieldset class="form-group">
    <div class="row">
      <legend class="col-form-label col-sm-5 pt-0">Sichtpruefung</legend>
      <div class="col-sm-7">
        <div class="form-check">
          <input class="form-check-input" type="radio" name="sichtpruefung" id="sichtpruefung0" value="0" <?php if(!$geraet['sichtpruefung']) { echo 'checked'; } ?>>
          <label class="form-check-label" for="sichtpruefung0">nein</label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="sichtpruefung" id="sichtpruefung" value="1" <?php if($geraet['sichtpruefung']) { echo 'checked'; } ?>>
          <label class="form-check-label" for="sichtpruefung">ja</label>
        </div>
      </div>
    </div>
  </fieldset>

  <?php if ( $geraet['schutzklasse'] == '1') {?>
  <div class="form-group row">
    <label for="typ" class="col-sm-5 col-form-label">Schutzleiter</label>
    <div class="col-sm-7">
      <input type="number" step="0.01" class="form-control" name="schutzleiter" id="schutzleiter" value="<?php echo $geraet['schutzleiter']; ?>" > (max 0.3)(<?php echo $RPEmax; ?>)
    </div>
  </div>
  <?php }?>
  <div class="form-group row">
    <label for="seriennummer" class="col-sm-5 col-form-label">Isowiderstand</label>
    <div class="col-sm-7">
    	<!--0,3 Ohm für die ersten 5m betragen
für jede weiteren 7,5m 0,1 Ohm mehr
maximal jedoch 1 Ohm.-->
      <input type="number" step="0.01" class="form-control" name="isowiderstand" id="isowiderstand" value="<?php echo $geraet['isowiderstand']; ?>"> (min 2)
    </div>
  </div>
  <?php if ( $geraet['schutzklasse'] == '1') {?>
  <div class="form-group row">
    <label for="typ" class="col-sm-5 col-form-label">Schutzleiterstrom</label>
    <div class="col-sm-7">
      <input type="number" step="0.01" class="form-control" name="schutzleiterstrom" id="schutzleiterstrom" value="<?php echo $geraet['schutzleiterstrom']; ?>" > (max 0.5)
    </div>
  </div>
  <?php }?>
  <?php if ( $geraet['schutzklasse'] == '1' || $geraet['schutzklasse'] == '2') {?>
  <div class="form-group row">
    <label for="typ" class="col-sm-5 col-form-label">Beruehrstrom</label>
    <div class="col-sm-7">
      <input type="number" step="0.01" class="form-control" name="beruehrstrom" id="beruehrstrom" value="<?php echo $geraet['beruehrstrom']; ?>" > (max 0.25)
    </div>
  </div>
  <?php }?>


   <fieldset class="form-group">
    <div class="row">
      <legend class="col-form-label col-sm-5 pt-0">Funktion</legend>
      <div class="col-sm-7">
        <div class="form-check">
          <input class="form-check-input" type="radio" name="funktion" id="funktion" data-toggle="collapse" data-target=".collapseOne.show" value="0" <?php if(!$geraet['funktion']) { echo 'checked'; } ?>>
          <label class="form-check-label" for="verlaengerungskabel0">nein</label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="funktion" id="funktion1" data-toggle="collapse" data-target=".collapseOne:not(.show)" value="1" <?php if($geraet['funktion']) { echo 'checked'; } ?>>
          <label class="form-check-label" for="funktion1">ja</label>
        </div>
      </div>
    </div>
  </fieldset>

  <div class="form-group row">
    <label for="beschreibung" class="col-sm-5 col-form-label">Bemerkung</label>
    <div class="col-sm-7">
      <textarea class="form-control" rows="3" name="bemerkung" id="bemerkung" ><?php echo $geraet['bemerkung']; ?></textarea>
    </div>
  </div>



<br>
<input type="submit" class="btn btn-primary btn-lg btn-block" value="speichern">
</form>

</div>
 <div class="col-6"  style="width:50%"></div>

</div>
