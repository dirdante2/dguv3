<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// Anschrift wird in protokollen angezeigt
// Wert: Testfirma<br>Musterstrasse 123<br>Superhausen
$config['dguv3_adresse']='emcot group GmbH<br>Vienhovenweg 2a<br>44867 Bochum';

// pfad zu logo ; wird in protokollen angezeigt
// kann lokaler pfad oder externe URL sein
// Wert: /application/bilder/logo.jpg
$config['dguv3_logourl']='/application/bilder/logo.jpg';

//zeitangabe ab wann prüfungen als abgelaufen gelten
//prüfdatum + wert= zeitpunkt abgelaufen
//Wert: 12 month
$config['dguv3_pruefungabgelaufen']='12 month';

//zeitangabe ab wann prüfungen als bald abgelaufen gelten
//Wert: 10 month
$config['dguv3_pruefungbaldabgelaufen']='10 month';


//anzeige von spalten auf geräte index seite 1 =an 0=aus
//array(name,1/0)
$config['dguv3_show_geraete_col'] = array(
array('ID',1),
array('Status',0),
array('Ort',1),
array('Name',1),
array('Hersteller',1),
array('Typ',1),
array('Seriennummer',1),
array('aktiv',0),
array('Beschreibung',1),
array('hinzugefügt am',1),
array('Spannung',0),
array('Strom',0),
array('Leistung',0),
array('Schutzklasse',1),
array('Kabel',0),
array('Prüfung',1),
array('Aktion',1)
);
//anzeige von spalten auf geräte pdf übersicht seite 1 =an 0=aus
//array(name,1/0)
$config['dguv3_show_geraete_pdf_col'] = array(
array('ID',0),
array('Status',0),
array('Ort',1),
array('Name',1),
array('Hersteller',1),
array('Typ',1),
array('Seriennummer',1),
array('aktiv',0),
array('Beschreibung',0),
array('hinzugefügt am',1),
array('Spannung',0),
array('Strom',0),
array('Leistung',0),
array('Schutzklasse',0),
array('Kabel',0),
array('letzte Prüfung',1),
array('Bestanden',1),
array('Prüfer',1),
array('Aktion',0)
);
