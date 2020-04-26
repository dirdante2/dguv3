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
                <tr>
                    <td><span class="iconify" data-icon="fa-solid:users" data-width="20" data-height="20"></span> Users</td>
                    <td>
                        <?php echo $users_count; ?>
                    </td>
                </tr>
                <tr>
                    <td><span class="iconify" data-icon="bx:bxs-business" data-width="20" data-height="20"></span> Firmen</td>
                    <td>
                        <?php echo $firmen_count; ?>
                    </td>
                </tr>
            </tbody>
        </table>

    </div>



    <div class="col" style="width: 100%; max-width: 200px;">
        <h4>Anschrift</h4><br>
        <?php if ($this->session->userdata('firmaid')) { ?>
            <?php echo $firma['firma_name']; ?><br>
            <?php echo $firma['firma_strasse']; ?><br>
            <?php echo $firma['firma_plz']; ?> <?php echo $firma['firma_ort']; ?>
        <?php } else {?>
            keine Firma
        <?php } ?>
    </div>

	<div class="col" style="width: 100%; max-width: 200px;">
        <h4>PDF Server</h4><br>
		<?php
$server_status = file_get_contents('https://olive-copper-spitz-json2pdf.herokuapp.com/pdfgen/ping');
//echo '_'.$server_status.'_';
if(strpos($server_status, 'pong') !== false) { ?>

<a href="" class="btn-sm btn-success">Status OK</a>
<?php } ?>
    </div>

    <div class="col" style="width: 90px; white-space: nowrap;">
        <h4>Archiv</h4><br>

        <?php
         $root = 'pdf/'.$this->session->userdata('firmaid').'/';
        if (!$this->session->userdata('firmaid')) { ?>
            keine Firma

        <?php } elseif (!file_exists($root)) { ?>
           keine pdf erstellt
        <?php } else { ?>
            <?php foreach($archiv_ordner as $file) {
                if (is_dir('pdf/'.$firma['firmen_firmaid'].'/'.$file)) {
                ?>

                <span class="iconify" data-icon="whh:archive" data-width="20" data-height="20"></span>

                    <?php if (file_exists('pdf/'.$firma['firmen_firmaid'].'/'.$file.'.zip')) {
                    $filetime= date("d.m.y|H:i:s", filemtime('pdf/'.$firma['firmen_firmaid'].'/'.$file.'.zip'));


                    ?>
                    <!-- ordner und archiv existieren -->
                    <a class="btn-sm btn-secondary" href="<?php echo site_url('dguv3/download_file/'.$file.'/.zip'); ?>"><?php echo $file; ?></a> <a href="<?php echo site_url('dguv3/create_archiv/'.$file); ?>" class="btn-sm btn-warning">neu</a> <?php echo $filetime; ?>
                    <?php } else {?>
                    <!--  ordner existiert aber kein zip archiv -->
                    <a class="btn-sm btn-light" ><?php echo $file; ?></a> <a href="<?php echo site_url('dguv3/create_archiv/'.$file); ?>" class="btn-sm btn-success">neu</a>


                    <?php } ?>
                <br>
                <?php }

            }

         } ?>

    </div>

</div>


