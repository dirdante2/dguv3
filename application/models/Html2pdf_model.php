
<?php
/**
* Dguv3 - Klasse
* (C) Christian Klein, 2020
*/

defined('BASEPATH') OR exit('No direct script access allowed');

require __DIR__.'/../../vendor/autoload.php';
use Spipu\Html2Pdf\Html2Pdf;
		
class Html2pdf_model extends CI_Model {

	function __construct() {
		$this->load->database();
	}

function html2pdfget($content,$name=NULL)
{


$file = 'somefile.txt';
file_put_contents($file, $content);

//protokoll portrait = P
//übersicht landscape = L
$html2pdf = new HTML2PDF("P","A4","de", true, "UTF-8", array(20, 10, 20, 10));

//var
$html2pdf->writeHTML($content);

//dateipfad protokoll= /pdf/<prüfung_jahr>/<ortsname>/<geräteID>_<prüfungID>_<gerätename>.pdf
//dateipfad ortsübersicht /pdf/<jahr>/<ortsname>/übersicht.pdf
$html2pdf->output(__DIR__.'/../../pdf/file_xxxx.pdf', 'F');


}


}
?>