<?php

require __DIR__.'/vendor/autoload.php';

use Spipu\Html2Pdf\Html2Pdf;


$html2pdf = new HTML2PDF("P","A4","de", true, "UTF-8", array(20, 10, 20, 10));

$html2pdf->writeHTML('<h1>HelloWorld</h1>This is my first test');

$html2pdf->output(__DIR__.'/pdf/file_xxxx.pdf', 'F');

?>