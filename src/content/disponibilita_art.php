<?php
$codicearti = $_GET["codicearti"];
$anno = date("Y");
$query = "SELECT magart.codice, magart.descrizion, magart.ubicazione, ubicaz.descrizion as descrubicaz FROM MagArt LEFT JOIN ubicaz ON magart.ubicazione == ubicaz.codice WHERE magart.codice = '$codicearti'";
$db = new apiObj();
$db->execute($query);

$dbGiac = new apiObj();
$queryGiac = "Select giacini+progqtacar-progqtasca as giacenza, magazzino from maggiac where esercizio = '$anno' and alltrim(articolo) == alltrim('$codicearti')";
$dbGiac->execute($queryGiac);

$dbUbic = new apiObj();
$queryUbic = "Select ubicazione from u_ubicaz where alltrim(codicearti)==alltrim('$codicearti')";
$dbUbic->execute($queryUbic);
?>

<div class="row">
    <div class="col col-3 table-secondary">
        <label class="text-secondary pr-2 text-xs">Codice:</label>
    </div>
    <div class="col col-9 bg-gray-light">
        <label class="text-primary"><?php echo $codicearti; ?></label>
    </div>
    <div class="col col-3 table-secondary">
        <label class="text-gray pr-2 text-xs">Descrizione:</label>
    </div>
    <div class="col col-9">
        <label class="text-primary"><?php echo $db->getField("descrizion"); ?></label>
    </div>
    <div class="col col-3 table-secondary">
        <label class="text-gray pr-2 text-xs">Ubicazione principale:</label>
    </div>
    <div class="col col-9 bg-gray-light">
        <label class="text-primary"><?php echo $db->getField("ubicazione") . " - " . $db->getField("descrubicaz"); ?></label>
    </div>
    <div class="col col-12 table-secondary">
        <label class="text-bold">Giacenze</label>
    </div>
    <div class="col col-12 p-0">
        <table class="table table-sm table-striped w-100">
            <thead class="table-dark">
                <td>Magazzino</td>
                <td>Giacenza</td>
                <td>Disp.</td>
            </thead>
            <tbody>
            <?php
            while(!$dbGiac->EOF){
                $maga = $dbGiac->getField("magazzino");
                $giac = $dbGiac->getField("giacenza");
                $dbDisp = new apiObj();
                $queryDisp = "Select ordinato-impegnato as dispon from magoi where magazzino='$maga' and alltrim(articolo) == alltrim('$codicearti')";
                $dbDisp->execute($queryDisp);
                if($dbDisp->EOF){
                    $disp = $giac;
                }
                else{
                    $disp = $giac + $dbDisp->getField("dispon");
                }
                ?>
                <tr>
                    <td><?php echo $maga; ?></td>
                    <td><?php echo $giac; ?></td>
                    <td><?php echo $disp; ?></td>
                </tr>
            <?php
                $dbGiac->moveNext();
            }
            ?>
            </tbody>
        </table>
    </div>
    <div class="col col-12 table-secondary">
        <label class="text-bold">Ubicazioni</label>
    </div>
    <div class="col col-12 p-0">
        <table class="table table-sm table-striped w-100">
                <tbody>
            <?php
            while (!$dbUbic->EOF){
                ?>
                <tr>
                    <td><?php echo $dbUbic->getField("ubicazione"); ?></td>
                </tr>
            <?php
                $dbUbic->moveNext();
            }
            ?>
            </tbody>
        </table>
    </div>
</div>
