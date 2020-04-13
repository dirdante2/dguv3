<h1>Willkommen!</h1>
<br>
<br>

<h2>Statistiken \o/</h2>
<br>
<div class="row">
    <div class="col" style="width: 100%; max-width: 300px;">

        <table class="table">
            <thead>
                <th><span class="iconify" data-icon="jam:plug" data-width="20" data-height="20"></span> Geräte</th>
                <th></th>
            </thead>
            <tbody>
                <tr>
                    <td>Gesamt</td>
                    <td>
                        <?php echo $geraete_count; ?>
                    </td>
                </tr>
                <tr>
                    <td style="text-indent:20px;">inaktiv</td>
                    <td>
                        <?php echo $geraete_aktiv_0; ?>
                    </td>
                </tr>
                <tr>
                    <td style="text-indent:20px;">aktiv</td>
                    <td>
                        <?php echo $geraete_aktiv_1; ?>
                    </td>
                </tr>
                
                
                <tr>
                    <td style="text-indent:30px;">ungeprüft</td>
                    <td>
                        <?php echo $geraete_count_geprueft_null; ?>
                    </td>
                </tr>
                
                <tr>
                    <td style="text-indent:30px;">geprüft</td>
                    <td>
                        <?php echo $geraete_count_geprueft; ?>
                    </td>
                </tr>
                <tr>
                    <td style="text-indent:40px;">durchgefallen</td>
                    <td>
                        <?php echo $geraete_count_geprueft_0; ?>
                    </td>
                </tr>
                <tr>
                    <td style="text-indent:40px;">bestanden</td>
                    <td>
                        <?php echo $geraete_count_geprueft_1; ?>
                    </td>
                </tr>
                <tr>
                    <td style="text-indent:50px;">abgelaufen</td>
                    <td>
                        <?php echo $geraete_count_geprueft_abgelaufen; ?>
                    </td>
                </tr>
                <tr>
                    <td style="text-indent:50px;">bald abgelaufen</td>
                    <td>
                        <?php echo $geraete_count_geprueft_baldabgelaufen; ?>
                    </td>
                </tr>
                
                
                
            </tbody>
        </table>

    </div>

    <div class="col" style="width: 100%; max-width: 300px;">

        <table class="table">
            <thead>
                <th><span class="iconify icon:typcn:clipboard icon-width:20 icon-height:20"></span> Prüfungen</th>
                <th></th>
            </thead>
            <tbody>
                <tr>
                    <td>Gesamt</td>
                    <td>
                        <?php echo $pruefung_count; ?>
                    </td>
                </tr>
                <tr>
                    <td style="text-indent:20px;">bestanden</td>
                    <td>
                        <?php echo $pruefung_bestanden_1; ?>
                    </td>
                </tr>
                <tr>
                    <td style="text-indent:20px;">fehlgeschlagen</td>
                    <td>
                        <?php echo $pruefung_bestanden_0; ?>
                    </td>
                </tr>

            </tbody>
        </table>

    </div>

    <div class="col" style="width: 100%; max-width: 300px;">

        <table class="table">
            <thead>
                <th>Rest</th>
                <th></th>
            </thead>
            <tbody>
                <tr>
                    <td><span class="iconify" data-icon="ic:baseline-account-circle" data-width="20" data-height="20"></span> Prüfer</td>
                    <td>
                        <?php echo $pruefer_count; ?>
                    </td>
                </tr>
                <tr>
                    <td><span class="iconify" data-icon="ic:outline-computer" data-width="20" data-height="20"></span> Messgeräte</td>
                    <td>
                        <?php echo $messgeraete_count; ?>
                    </td>
                </tr>
                <tr>
                    <td><span class="iconify" data-icon="ic:baseline-room" data-width="20" data-height="20"></span> Orte</td>
                    <td>
                        <?php echo $orte_count; ?>
                    </td>
                </tr>
            </tbody>
        </table>

    </div>
    <div class="col" style="width: 100%; max-width: 300px;">
        <h4>Anschrift</h4>
        <?php echo $adresse; ?>

    </div>
     <div class="col" style="width: 100%; max-width: 300px;">
        <h4>Archiv</h4>
       
        <form method="post"> 
        <input type="submit" name="button1"
                class="btn-sm" value="alle erstellen" /></form><br>
        <?php 
        
        if(array_key_exists('button1', $_POST)) { 
            button1(); 
        } 
        
      
        
        function button1($folder=Null) { 
        	
        	if($folder==NULL) {
        	$root = "pdf";
        		$directories = glob($root . '/*' , GLOB_ONLYDIR);
					} else {
						$directories[0]=$folder;
					}

foreach ($directories as $folder) {

// file und dir counter
$fc = -1;
$dc = -1;

// die maximale Ausführzeit erhöhen
ini_set("max_execution_time", 300);
//if (!file_exists($folder.".zip")) { 
	 
// Objekt erstellen und schauen, ob der Server zippen kann
$zip = new ZipArchive();
if ($zip->open($folder.".zip", ZIPARCHIVE::CREATE) !== TRUE) {
	die ("Das Archiv konnte nicht erstellt werden!");
}

echo "<pre>";
// Gehe durch die Ordner und füge alles dem Archiv hinzu
$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($folder));
foreach ($iterator as $key=>$value) {
  
  if(!is_dir($key)) { // wenn es kein ordner sondern eine datei ist
    // echo $key . " _ _ _ _Datei wurde übernommen</br>";
    $zip->addFile(realpath($key), $key) or die ("FEHLER: Kann Datei nicht anfuegen: $key");
    $fc++;

  } elseif (count(scandir($key)) <= 2) { // der ordner ist bis auf . und .. leer
    // echo $key . " _ _ _ _Leerer Ordner wurde übernommen</br>";
    $zip->addEmptyDir(substr($key, -1*strlen($key),strlen($key)-1));
    $dc++;
  
  } elseif (substr($key, -2)=="/.") { // ordner .
    $dc++; // nur für den bericht am ende
    
  } elseif (substr($key, -3)=="/.."){ // ordner ..
    // tue nichts
    
  } else { // zeige andere ausgelassene Ordner (sollte eigentlich nicht vorkommen)
    echo $key . "WARNUNG: Der Ordner wurde nicht ins Archiv übernommen.</br>";
  }
}
echo "</pre>";

// speichert die Zip-Datei
$zip->close();

// bericht
echo $folder.".zip wurde erstellt.";
echo "<p>Ordner: " . $dc . "; Dateien: " . $fc . "</p>";

}
//}

        } 
$root = "pdf";
$zipfiles= glob($root.'/*.{zip}', GLOB_BRACE);

foreach($zipfiles as $file) { ?>

  <span class="iconify" data-icon="whh:archive" data-width="20" data-height="20"></span> <a class="btn-sm" href="<?php echo base_url(); echo $file; ?>"><?php echo $file; ?></a>
   
 
                
  
  <br>
<?php

     } ?>
        
        
        

    </div>

</div>


