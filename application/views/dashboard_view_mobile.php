<h1>Willkommen!</h1>
Letzter login: <?php echo $this->session->userdata('lastlogin'); ?><br>

<div class="row">


<?php if($cronjobs) { ?>
    <div class="col pb-5">
    <table class="table table-bordered" style="width: 100%; font-size: 1em; padding: 10px 10px;">
            <thead class="thead-light">
                <th>Aufgaben</th>

            </thead>
            <tbody>
                        <tr>
                    <td>
                        <div class="text-center">
                    Fehlende Aufgaben: <span class="badge badge-danger"><?php echo $cronjobs; ?></span><br>
                    
                        <a href="<?php echo site_url('cron/create_pdf_3/'); ?>" class="btn btn-warning btn-lg" style="width: 100%; font-size: 1em; padding: 10px 10px;"><span class="iconify" data-icon="material-symbols:autorenew" data-width="40" data-height="40"></span> PDF erstellen</a>
                    </div>


                    </td>
                                       
                                    </tr>
                                </tbody>
                            </table>
                            </div>
            <?php } ?>



    <div class="card-header" id="collaps_header_statistik" style="width: 100%;">

        <button class="btn btn-info btn-lg" data-toggle="collapse" data-target="#collaps_statistik" aria-expanded="true" aria-controls="collaps_statistik" style="width: 100%; font-size: 1em; padding: 10px 10px;">
            <span class="iconify" data-icon="whh:statistics" data-width="50" data-height="50"></span> <b>Statistiken \o/</b>
        </button>

    </div>
    <div class="collapse" id="collaps_statistik" style="width: 100%;">
        <div class="card card-body">


            <div id="accordion">
                <div class="card">
                    <div class="card-header" id="haedinggeraete">
                        <button class="btn btn-info btn-lg" style="width: 100%; font-size: 1em; padding: 10px 10px;" data-toggle="collapse" data-target="#collapsegeraete" aria-expanded="true" aria-controls="collapsegeraete">
                            <span class="iconify" data-icon="jam:plug" data-width="50" data-height="50"></span> <b>Geräte</b>
                        </button>

                    </div>

                    <div id="collapsegeraete" class="collapse show" aria-labelledby="haedinggeraete" data-parent="#accordion">
                        <div class="card-body">



                            <!-- Tabelle für Aktiv/Inaktiv (Unterpunkt von Gesamt) -->
                            <table class="table table-sm">
                            <thead class="thead-light">
                                    <th><span class="iconify" data-icon="fluent-mdl2:total" data-width="50" data-height="50"></span> Gesamt</th>

                                    <th style="text-align: right;"><?php echo $geraete_count; ?></th>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><span class="iconify" data-icon="mdi:stop-pause-outline" data-width="50" data-height="50"></span> Inaktiv</td>
                                               <td style="text-align: right;"><?php echo $geraete_aktiv_0; ?></td>
                                    </tr>
                                    <tr>
                                        <td><span class="iconify" data-icon="octicon:play-24" data-width="50" data-height="50"></span> Aktiv</td>
                                               
                                            <td style="text-align: right;"><?php echo $geraete_aktiv_1; ?></td>
                                       
                                    </tr>
                                </tbody>
                            </table>

                            <!-- Tabelle für Geprüft/Ungeprüft (Unterpunkt von Aktiv) -->
                            <table class="table table-sm" style="width: 100%;">
                                <thead class="thead-light">
                                    <th><span class="iconify" data-icon="octicon:play-24" data-width="50" data-height="50"></span> Aktiv</th>
                                    <th style="text-align: right;"><?php echo $geraete_aktiv_1; ?></th>

                                </thead>
                                <tbody>
                                    <tr>
                                        <td><span class="iconify" data-icon="fluent:checkbox-unchecked-20-regular" data-width="50" data-height="50"></span> Ungeprüft</td>
                                        <td style="text-align: right;"><?php echo $geraete_count_geprueft_null; ?></td>
                                    </tr>
                                    <tr>
                                        <td><span class="iconify" data-icon="fluent:checkbox-checked-20-regular" data-width="50" data-height="50"></span> Geprüft</td>
                                        <td style="text-align: right;"><?php echo $geraete_count_geprueft; ?></td>
                                    </tr>
                                </tbody>
                            </table>

                            <!-- Tabelle für Durchgefallen/Bestanden (Unterpunkt von Geprüft) -->
                            <table class="table table-sm" style="width: 100%;">
                                <thead class="thead-light">
                                    <th><span class="iconify" data-icon="fluent:checkbox-checked-20-regular" data-width="50" data-height="50"></span> Geprüft</th>
                                    <th style="text-align: right;"><?php echo $geraete_count_geprueft; ?></th>

                                </thead>
                                <tbody>
                                    <tr>
                                        <td><span class="iconify" data-icon="mdi:stop-alert-outline" data-width="50" data-height="50"></span> Durchgefallen</td>
                                        <td style="text-align: right;"><?php echo $geraete_count_geprueft_0; ?></td>
                                    </tr>
                                    <tr>
                                        <td><span class="iconify" data-icon="clarity:success-standard-line" data-width="50" data-height="50"></span> Bestanden</td>
                                        <td style="text-align: right;"><?php echo $geraete_count_geprueft_1; ?></td>
                                    </tr>
                                </tbody>
                            </table>

                            <!-- Tabelle für Abgelaufen/Bald abgelaufen (Unterpunkt von Bestanden) -->
                            <table class="table table-sm" style="width: 100%;">
                                <thead class="thead-light">
                                    <th><span class="iconify" data-icon="clarity:success-standard-line" data-width="50" data-height="50"></span> Bestanden</th>
                                    <th style="text-align: right;"><?php echo $geraete_count_geprueft_1; ?></th>

                                </thead>
                                <tbody>
                                    <tr>
                                        <td><span class="iconify" data-icon="mdi:stopwatch-remove-outline" data-width="50" data-height="50"></span> Abgelaufen</td>
                                        <td style="text-align: right;"><?php echo $geraete_count_geprueft_abgelaufen; ?></td>
                                    </tr>
                                    <tr>
                                        <td><span class="iconify" data-icon="pajamas:expire" data-width="50" data-height="50"></span> Bald abgelaufen</td>
                                        <td style="text-align: right;"><?php echo $geraete_count_geprueft_baldabgelaufen; ?></td>
                                    </tr>
                                    <tr>
                                        <td><span class="iconify" data-icon="fluent-mdl2:waitlist-confirm" data-width="50" data-height="50"></span> aktuell</td>
                                        <td style="text-align: right;"><?php echo $geraete_count_geprueft_aktuell; ?></td>
                                    </tr>
                                </tbody>
                            </table>



                        </div>
                    </div>
                </div>


                <div class="card">
                    <div class="card-header" id="haedingpruefung">
                        <button class="btn btn-info btn-lg" style="width: 100%; font-size: 1em; padding: 10px 10px;" data-toggle="collapse" data-target="#collapsepruefung" aria-expanded="true" aria-controls="collapsepruefung">
                            <span class="iconify" data-icon="typcn:clipboard" data-width="50" data-height="50"></span> <b>Prüfung</b>
                        </button>

                    </div>

                    <div id="collapsepruefung" class="collapse" aria-labelledby="haedingpruefung" data-parent="#accordion">
                        <div class="card-body">
                            <table class="table">
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
                    </div>
                </div>

                <div class="card">
                    <div class="card-header" id="haedingrest">
                        <button class="btn btn-info btn-lg" style="width: 100%; font-size: 1em; padding: 10px 10px;" data-toggle="collapse" data-target="#collapserest" aria-expanded="true" aria-controls="collapserest">
                            <span class="iconify" data-icon="vaadin:ellipsis-dots-h" data-width="50" data-height="50"></span> <b>Rest</b>
                        </button>

                    </div>

                    <div id="collapserest" class="collapse" aria-labelledby="haedingrest" data-parent="#accordion">
                        <div class="card-body">

                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td><span class="iconify" data-icon="ic:baseline-account-circle" data-width="50" data-height="50"></span> Prüfer</td>
                                        <td>
                                            <?php echo $pruefer_count; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><span class="iconify" data-icon="ic:outline-computer" data-width="50" data-height="50"></span> Messgeräte</td>
                                        <td>
                                            <?php echo $messgeraete_count; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><span class="iconify" data-icon="ic:baseline-room" data-width="50" data-height="50"></span> Orte</td>
                                        <td>
                                            <?php echo $orte_count; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><span class="iconify" data-icon="fa-solid:users" data-width="50" data-height="50"></span> Users</td>
                                        <td>
                                            <?php echo $users_count; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><span class="iconify" data-icon="bx:bxs-business" data-width="50" data-height="50"></span> Firmen</td>
                                        <td>
                                            <?php echo $firmen_count; ?>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                        </div>






                    </div>
                </div>


            </div>

        </div>
    </div>



    <div class="col-auto pt-5" style="width: 100%;">
        <table class="table table-bordered">
            <thead class="thead-light">
                <th>Anschrift</th>

            </thead>
            <tbody>
                <tr>
                    <td>
                        <?php if ($this->session->userdata('firmaid')) { ?>
                            <?php echo $firma['firma_name']; ?><br>
                            <?php echo $firma['firma_strasse']; ?><br>
                            <?php echo $firma['firma_plz']; ?> <?php echo $firma['firma_ort']; ?>
                        <?php } else { ?>
                            keine Firma
                        <?php } ?>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>


    <div class="col-auto pt-3" style="width: 100%;">
        <table class="table table-bordered">
            <thead class="thead-light">
                <th>Fehlerquote</th>

            </thead>
            <tbody>
                <tr>
                    <td>

                        <?php
                        if ($fehlerquote['prozent'] <= '2') {
                            $fehlerquotecolor = "text-success";
                        } elseif ($fehlerquote['prozent'] <= '10') {
                            $fehlerquotecolor = "text-warning";
                        } else {
                            $fehlerquotecolor = "text-danger";
                        }

                        ?>

                        <b class="<?php echo $fehlerquotecolor; ?>">Prozent: <?php echo $fehlerquote['prozent']; ?>%</b><br>

                        seit: <?php echo $fehlerquote['zeitraum']; ?><br>
                        Geprüft: <?php echo $fehlerquote['geprüft']; ?><br>
                        Bestanden: <?php echo $fehlerquote['anzahlbestanden']; ?><br>
                        Durchgefallen: <?php echo $fehlerquote['anzahldurchgefallen']; ?>

                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="col-auto pt-3" style="width: 100%; border: 0px solid #000;">
        <table class="table table-bordered">
            <thead class="thead-light">
                <th>PDF Server</th>

            </thead>
            <tbody>
                <tr>
                    <td>
                        <div class="btn-group-vertical" role="group" style="width: 100%;">
                            <?php
                            $i = 0;
                            foreach ($pdfserver as $serverurl) {
                                $i++; ?>

                                <?php

                                $ch = curl_init();
                                curl_setopt($ch, CURLOPT_HEADER, 0);
                                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //Set curl to return the data instead of printing it to the browser.
                                curl_setopt($ch, CURLOPT_URL, $serverurl . '/pdfgen/ping');
                                $data = curl_exec($ch);
                                curl_close($ch);
                                if (strpos($data, 'pong!')) {




                                ?>
                                    <a href="<?php echo $serverurl; ?>" target="_blank" role="button" class="btn btn-sm btn-success">Server <?php echo $i; ?> OK</a>
                                <?php
                                } else { ?>
                                    <!-- <button type="button" class="btn btn-sm btn-danger">Server <?php echo $i; ?> Error</button> -->
                                    <a href="<?php echo $serverurl; ?>" target="_blank" role="button" class="btn btn-sm btn-danger">Server <?php echo $i; ?> Error</a>
                            <?php }
                            } ?>

                        </div>
                    </td>
                </tr>
            </tbody>
        </table>

    </div>

    <div class="col-auto  pt-3" style="width: 100%; border: 0px solid #000;">
        <table class="table table-bordered">
            <thead class="thead-light">
                <th>Archiv</th>

            </thead>
            <tbody>
                

             

            <?php

            $root = 'pdf/' . $this->session->userdata('firmaid') . '/';
            if (!$this->session->userdata('firmaid')) { ?>
                keine Firma

            <?php } elseif (!file_exists($root)) { ?>
                keine pdf erstellt
            <?php } else {
                //print_r($archiv_ordner);
                $year = date('Y');
            ?>

                <?php foreach ($archiv_ordner as $file) {

                    if (is_dir('pdf/' . $firma['firmen_firmaid'] . '/' . $file)) {

                ?>
                <tr>
                <td>
                       



                            <?php if (file_exists('pdf/' . $firma['firmen_firmaid'] . '/' . $file . '.zip')) {
                                $details = file_get_contents('pdf/' . $firma['firmen_firmaid'] . '/' . $file . '.txt', true);

                                $filetime = date("d.m.y|H:i:s", filemtime('pdf/' . $firma['firmen_firmaid'] . '/' . $file . '.zip'));
                                //Get the file size in bytes.
                                $fileSizeBytes = filesize('pdf/' . $firma['firmen_firmaid'] . '/' . $file . '.zip');

                                //Convert the bytes into MB.
                                $fileSizeMB = ($fileSizeBytes / 1024 / 1024);

                                //269,708 bytes is 0.2572135925293 MB

                                //Format it so that only 2 decimal points are displayed.
                                $fileSizeMB = number_format($fileSizeMB, 2);



                            ?>
                               
                                    
                                    <!-- ordner und archiv existieren -->
                                    <a class="btn btn-secondary" href="<?php echo site_url('dguv3/download_file/' . $file . '/3'); ?>"><span class="iconify" data-icon="whh:archive" data-width="40" data-height="40"></span> <?php echo $file; ?> (<?php echo $fileSizeMB; ?>MB)</a>
                                    <!-- $file+1 wenn in vergangenheit neuerstellen -->
                                    <?php if ($file >= $year) { ?>
                                        
                                    <a href="<?php echo site_url('dguv3/create_archiv/' . $file); ?>" class="btn btn-warning btn-lg float-right"><span class="iconify" data-icon="material-symbols:autorenew" data-width="40" data-height="40"></span> neu</a>
                                    <?php } ?><br>
                                    <?php echo $filetime; ?>
                                    <br><?php echo $details; ?>
                                </div>
                             <?php } else { ?>
                               
                                    <span class="iconify" data-icon="whh:archive" data-width="50" data-height="50"></span>
                                    <!--  ordner existiert aber kein zip archiv -->
                                    
                                    <a href="<?php echo site_url('dguv3/create_archiv/' . $file); ?>" class="btn btn-warning btn-lg float-right"><span class="iconify" data-icon="material-symbols:autorenew" data-width="40" data-height="40"></span> neu</a>
                               


                            <?php } ?>
                            
                       
                    <?php } ?>
                    </td>
                </tr>

                <?php  } ?>

            <?php } ?>

    </div>
    </td>
    </tr>
    </tbody>
    </table>
</div>