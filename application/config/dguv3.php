<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// Anschrift wird in protokollen angezeigt
// Beispiel: Testfirma<br>Musterstrasse 123<br>Superhausen
$config['dguv3_adresse']='emcot group GmbH<br>Vienhovenweg 2a<br>44867 Bochum';

// pfad zu logo ; wird in protokollen angezeigt
// kann lokaler pfad oder externe URL sein
// /application/bilder/logo.jpg
$config['dguv3_logourl']='/application/bilder/logo.jpg';

//zeitangabe ab wann pr�fungen als abgelaufen gelten
//12monate: 12 month
$config['dguv3_pruefungabgelaufen']='12 month';
//zeitangabe ab wann pr�fungen als bald abgelaufen gelten
//10monate: 10 month
$config['dguv3_pruefungbaldabgelaufen']='10 month';