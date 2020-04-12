<?php
/**
* @description rekursives erstellen eines zip archives mit php
* @inspired by @url http://andreknieriem.de
* @todo: rekursive blacklist's
*/

/*
 * Anmerkung: Der Ordner . bezeichnet immer den Ordner selbst. Der Ordner .. 
 * den jeweils darüber liegenden Ordner. Leere Ordner enthalten nur . und .. 
 * und sind darüber zu erkennen.
 * Ordner die nicht leer sind, werden durch die enthaltenden Ordner oder Dateien 
 * übernommen.
 */

// zu zippender ordner
$root = "pdf";

$files = glob($root.'/*.{zip}', GLOB_BRACE);
foreach($files as $file) {
  //do your work here
  echo $file;
  echo ' ';
}

$directories = glob($root . '/*' , GLOB_ONLYDIR);
print_r($directories);

foreach ($directories as $folder) {

// file und dir counter
$fc = 0;
$dc = 0;

// die maximale Ausführzeit erhöhen
ini_set("max_execution_time", 300);

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
echo "<h4>Das Archiv ".$folder.".zip wurde erfolgreich erstellt.</h4>";
echo "<p>Ordner: " . $dc . "</br>";
echo "Dateien: " . $fc . "</p>";
}


?>