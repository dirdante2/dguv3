<h1>Ort hinzufügen/bearbeiten</h1>

<?php

echo form_open('orte/edit/'.$ort['oid']);
echo validation_errors();

?>
<input type="hidden" name="oid" value="<?php echo $ort['oid'] ?>">

Name:<br>
<input type="text" name="name" value="<?php echo $ort['name'] ?>"><br>
Beschreibung<br>
<textarea name="beschreibung">
<?php echo $ort['beschreibung'] ?>
</textarea>
<br>
<input type="submit" class="btn btn-primary" value="speichern">
</form>



