<h1>Wirklich löschen: <?php echo $beschreibung; ?></h1>

<?php echo validation_errors(); ?>

<?php if (isset($message)) { ?>
<?php echo $message; ?>
<?php } ?>

<?php echo form_open($target); ?>
<p>
Sind Sie sich sicher ?<br>
<input type="checkbox" name="confirm" value="1" size="50">Ja<br>
<input type="submit" value="Bestätigen" class="btn btn-danger">
<a href="<?php echo site_url($canceltarget); ?>" class="btn btn-primary">Abbrechen</a>
</p>
</form>

