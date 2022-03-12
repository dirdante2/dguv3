<h1>Firma hinzufügen/bearbeiten</h1>

<?php

echo form_open('firmen/edit/'.$firma['firmen_firmaid']);
echo validation_errors();

?>
<input type="hidden" name="firmen_firmaid" value="<?php echo $firma['firmen_firmaid'] ?>">
<div class="row">
 <div class="col-lg-6 col-md">
	
<form>
<div class="form-group row">
    <label for="name" class="col-sm-3 col-form-label">Name*</label>
    <div class="col-sm-9">
      <input type="text" class="form-control" name="firma_name" id="firma_name" value="<?php echo $firma['firma_name']; ?>" required>
    </div>
  </div>

  <div class="form-group row">
    <label for="name" class="col-sm-3 col-form-label">Ort*</label>
    <div class="col-sm-9">
      <input type="text" class="form-control" name="firma_ort" id="firma_ort" value="<?php echo $firma['firma_ort']; ?>" required>
    </div>
  </div>
  <div class="form-group row">
    <label for="name" class="col-sm-3 col-form-label">Strasse*</label>
    <div class="col-sm-9">
      <input type="text" class="form-control" name="firma_strasse" id="firma_strasse" value="<?php echo $firma['firma_strasse']; ?>" required>
    </div>
  </div>
  <div class="form-group row">
    <label for="name" class="col-sm-3 col-form-label">PLZ*</label>
    <div class="col-sm-9">
      <input type="text" class="form-control" name="firma_plz" id="firma_plz" value="<?php echo $firma['firma_plz']; ?>" required>
    </div>
  </div>
  <div class="form-group row">
    <label for="name" class="col-sm-3 col-form-label">Beschreibung</label>
    <div class="col-sm-9">
      <input type="text" class="form-control" name="firma_beschreibung" id="firma_beschreibung" value="<?php echo $firma['firma_beschreibung']; ?>" >
    </div>
  </div>

<br>
<input type="submit" class="btn btn-primary btn-lg btn-block" value="speichern">
</form>

</div>


</div>

