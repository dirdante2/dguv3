



<?php if (isset($message)) { ?>
<?php echo $message; ?>
<?php } ?>

<?php echo form_open($target); 

#echo $useragent;
if($useragent=='mobile') {

    $mobilebutton='btn-lg';
} else {
    $mobilebutton='';

}

?><br>
<p>
Sind Sie sich sicher ?<br>



<input type="checkbox" name="confirm" value="1" size="50"> Ja<br><br>

<div class="row" style="width: 100%;max-width: 700px; border: 0px solid #000;">
<div class="col">
<input type="submit" value="Bestätigen" class="btn btn-danger <?php echo $mobilebutton; ?>">
</div><div class="col">
<a href="<?php echo site_url($canceltarget); ?>" class="btn btn-primary <?php echo $mobilebutton; ?>">Abbrechen</a>
</div>
</p>
</form><br><br><br>

