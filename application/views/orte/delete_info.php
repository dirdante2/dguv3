<br><br>


<?php echo validation_errors(); ?>
<?php if (isset($message)) { ?>
    
<?php echo $message; ?>
<?php } ?>
<br>
<h1>Wirklich löschen </h1>
<br>
<b>Objekt</b><br><br>
<div class="row" style="border: 1px solid #000; max-width: 900px;">
<div class="col" style="width: 500px;border: 0px solid #000;white-space: nowrap;">
						

						<table  class="table table-sm">
							<tr>
								<td>ID</td>
								<td><?php if($ort['oid']==NULL) { echo "-"; } else { echo $ort['oid']; } ?></td>
							</tr>
							<tr>
								<td>Ort</td>
								<td><?php if($ort['name']==NULL) { echo "-"; } else { echo $ort['name'];} ?></td>
							</tr>
							<tr>
								<td>Beschreibung</td>
								<td><?php if($ort['beschreibung']==NULL) { echo "-"; } else { echo $ort['beschreibung']; } ?></td>
							</tr>
							
						</table>
</div>
</div>