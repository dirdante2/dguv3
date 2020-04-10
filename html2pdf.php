<?php

require __DIR__.'/vendor/autoload.php';

use Spipu\Html2Pdf\Html2Pdf;

//protokoll portrait = P
//übersicht landscape = L
$html2pdf = new HTML2PDF("P","A4","de", true, "UTF-8", array(20, 10, 20, 10));

//var
$html2pdf->writeHTML('<h1>HelloWorld</h1>This is my first test');

//dateipfad protokoll= /pdf/<prüfung_jahr>/<ortsname>/<geräteID>_<prüfungID>_<gerätename>.pdf
//dateipfad ortsübersicht /pdf/<jahr>/<ortsname>/übersicht.pdf
$html2pdf->output(__DIR__.'/pdf/file_xxxx.pdf', 'F');

?>