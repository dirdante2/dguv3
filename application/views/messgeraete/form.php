<h1>Messgerät hinzufügen/bearbeiten</h1>

<?php

echo form_open('messgeraete/edit/'.$messgeraet['mid']);
echo validation_errors();

?>
<input type="hidden" name="mid" value="<?php echo $messgeraet['mid'] ?>">

Name:<br>
<input type="text" name="name" value="<?php echo $messgeraet['name'] ?>"><br>
Beschreibung<br>
<textarea name="beschreibung">
<?php echo $messgeraet['beschreibung'] ?>
</textarea>
<br>
<input type="submit" class="btn btn-primary" value="speichern">
</form>



