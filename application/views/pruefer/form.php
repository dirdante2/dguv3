<h1>Prüfer hinzufügen/bearbeiten</h1>

<?php

echo form_open('pruefer/edit/'.$pruefer['pid']);
echo validation_errors();

?>
<input type="hidden" name="pid" value="<?php echo $pruefer['pid'] ?>">

Name:<br>
<input type="text" name="name" value="<?php echo $pruefer['name'] ?>"><br>
Beschreibung<br>
<textarea name="beschreibung">
<?php echo $pruefer['beschreibung'] ?>
</textarea>
<br>
<input type="submit" class="btn btn-primary" value="speichern">
</form>



