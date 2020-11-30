<?php
$query = "select * from eserc where tipo == 'M'";
$db = new apiObj();
$db->execute($query);

$queryMag = "select * from magana";
$dbMagAna = new apiObj();
$dbMagAna->execute($queryMag);
?>
<div class="row">
    <div class="col col-6">
        <label>Anno</label>
        <select class="form-control form-control-sm">
            <?php
            while(!$db->EOF){
                ?>
                <option value="<?php echo $db->getField('codice') ?>"><?php echo $db->getField('codice') ?></option>
                <?php
                $db->moveNext();
            }
            ?>
        </select>
    </div>
    <div class="col col-6">
        <label>Magazzino</label>
        <select class="form-control form-control-sm">
            <?php
            while(!$dbMagAna->EOF){
                ?>
                <option value="<?php echo $dbMagAna->getField('codice') ?>"><?php echo $dbMagAna->getField('descrizion') ?></option>
                <?php
                $dbMagAna->moveNext();
            }
            ?>
        </select>
    </div>
</div>
<div class="row">
    <div class="col col-8">

    </div>
    <div class="col col-4">
        <button class="btn btn-block btn-sm btn-primary"><i class="fas fa-gear pr-2"></i>Carica</button>
    </div>
</div>
<div class="row">
    <div class="col col-12">
        <table class="table table-striped table-sm">
            <thead>
                <td></td>
            </thead>
        </table>
    </div>
</div>