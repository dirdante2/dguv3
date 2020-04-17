<h1>Messgerät hinzufügen/bearbeiten</h1>

<?php

echo form_open('firmen/edit/'.$firma['firma_id']);
echo validation_errors();

?>
<input type="text" name="firma_id" value="<?php echo $firma['firma_id'] ?>">

Name:<br>
<input type="text" name="firma_name" value="<?php echo $firma['firma_name'] ?>"><br>
Ort:<br>
<input type="text" name="firma_name" value="<?php echo $firma['firma_ort'] ?>"><br>
Strasse:<br>
<input type="text" name="firma_name" value="<?php echo $firma['firma_strasse'] ?>"><br>
PLZ:<br>
<input type="text" name="firma_name" value="<?php echo $firma['firma_plz'] ?>"><br>
Beschreibung<br>
<textarea name="firma_beschreibung">
<?php echo $firma['firma_beschreibung'] ?>
</textarea>
<br>
<input type="submit" class="btn btn-primary" value="speichern">
</form>



