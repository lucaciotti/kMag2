<?php
$anno = date("Y");
$num = (isset($_GET['num']) ? trim($_GET['num']) : -1 );
$ubi = (isset($_GET['ubi']) ? trim($_GET['ubi']) : '' );
$codMaga = (isset($_GET['maga']) ? $_GET['maga'] : '00001');
$codOrd = (isset($_GET['ord']) ? $_GET['ord'] : 0 );

$query = "select * from eserc where tipo == 'M'";
$db = new apiObj();
$db->execute($query);

$queryMag = "select * from magana";
$dbMagAna = new apiObj();
$dbMagAna->execute($queryMag);
?>
<input id="num" value="<?php echo $num; ?>" hidden>
<input id="ubi" value="<?php echo $ubi; ?>" hidden>
<input id="codord" value="<?php echo $codOrd; ?>" hidden>

<div class="row pb-2 border-bottom">
    <div class="col col-6">
        <label>Anno</label>
        <select class="form-control form-control-sm" id="anno">
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
        <select class="form-control form-control-sm" id="codmaga">
            <?php
            while(!$dbMagAna->EOF){
                ?>
                <option value="<?php echo $dbMagAna->getField('codice') ?>"><?php echo $dbMagAna->getField('descrizion') . " (" . $dbMagAna->getField('codice') . ')' ?></option>
                <?php
                $dbMagAna->moveNext();
            }
            ?>
        </select>
    </div>
</div>
<div class="row pt-2">
    <div class="col col-12">
        <div id='navcontainer'>
            <p style='font-weight:bold; text-align:center; padding:0;'>Ordina Per:</p>
        </div>
    </div>
    <div class="col col-3">
        <button id="btnOrd0" class="btn btn-sm btn-block btn-secondary" onclick="$('#codord').val('0'); caricaSparate();">Cartellino</button>
    </div>
    <div class="col col-3">
        <button id="btnOrd1" class="btn btn-sm btn-block btn-secondary" onclick="$('#codord').val('1'); caricaSparate();">Articolo</button>
    </div>
    <div class="col col-3">
        <button id="btnOrd2" class="btn btn-sm btn-block btn-secondary" onclick="$('#codord').val('2'); caricaSparate();">Tot.Articolo</button>
    </div>
    <div class="col col-3">
        <button id="btnOrd3" class="btn btn-sm btn-block btn-secondary" onclick="$('#codord').val('3'); caricaSparate();">Segnalate!</button>
    </div>
</div>
<div class="row pt-2">
    <div class="col col-12">
        <table class="table table-striped table-sm" id="tableSparate">
            <thead class="table-dark">
                <tr>
                    <td>idcart</td>
                    <td>n. Cartellino</td>
                    <td>Cod. Art.</td>
                    <td>Descr. Articolo</td>
                    <td>Lotto</td>
                    <td>U.M.</td>
                    <td>Qta Invent.</td>
                    <td>Ubicazione</td>
                    <td style="width: 1%">Segn.</td>
                    <td>Elimina</td>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
</div>

<script>
    $(document).ready(function() {
        var table = $('#tableSparate').DataTable({
            "paging": true,
            "info": false
        });

        $("#anno").val("<?php echo $anno; ?>");
        $("#codmaga").val("<?php echo $codMaga; ?>");

        caricaSparate();
    });

    function deleteCart(idcart){
        var maga = "00"+idcart.substr(4,3);
        var num = idcart.substr(7,5);

        var message = "ATTENZIONE!!\nCancellazione Cartellino n. "+num+" in Magazzino: "+maga+"\nProcedo?";
        if(confirm(message)){
            //elimino la riga
            var query = "DELETE FROM u_invent WHERE codcart=='" + idcart + "'";
            xhr = jQuery.ajax({
                type: "GET",
                url: "query.php",
                data: {
                    query: query
                },
                async: false,
                beforeSend: function(){
                    // $("#btnsubmit").enabled = false;
                    // $("#articolo").enabled = false;
                },
                complete: function(){
                    // $("#btnsubmit").enabled = true;
                    // $("#articolo").enabled = true;
                },
                success: function (obj, textstatus){
                    location.reload();
                }
            });
        }

    }

    function caricaSparate(){
        var query = "";
        var maga = $("#codmaga").val();
        var anno = $("#anno").val();
        var codOrd = $("#codord").val();
        $("#tableSparate tbody").empty();

        $("#btnOrd0").removeClass("btn-primary");
        $("#btnOrd1").removeClass("btn-primary");
        $("#btnOrd2").removeClass("btn-primary");
        $("#btnOrd3").removeClass("btn-primary");
        $("#btnOrd0").removeClass("btn-secondary");
        $("#btnOrd1").removeClass("btn-secondary");
        $("#btnOrd2").removeClass("btn-secondary");
        $("#btnOrd3").removeClass("btn-secondary");
        switch (codOrd){
            case "0":
                $("#btnOrd0").addClass("btn-primary");
                $("#btnOrd1").addClass("btn-secondary");
                $("#btnOrd2").addClass("btn-secondary");
                $("#btnOrd3").addClass("btn-secondary");
                query = "SELECT u_invent.*, magart.descrizion, magart.unmisura FROM u_invent left outer join magart on magart.codice==u_invent.codicearti where u_invent.esercizio=='" + anno + "' and u_invent.magazzino=='" + maga + "'"
                break;
            case "1":
                $("#btnOrd0").addClass("btn-secondary");
                $("#btnOrd1").addClass("btn-primary");
                $("#btnOrd2").addClass("btn-secondary");
                $("#btnOrd3").addClass("btn-secondary");
                query = "SELECT u_invent.*, magart.descrizion, magart.unmisura FROM u_invent left outer join magart on magart.codice==u_invent.codicearti where u_invent.esercizio=='" + anno + "' and u_invent.magazzino=='" + maga + "' order by u_invent.codicearti, u_invent.lotto";
                break;
            case "2":
                $("#btnOrd0").addClass("btn-secondary");
                $("#btnOrd1").addClass("btn-secondary");
                $("#btnOrd2").addClass("btn-primary");
                $("#btnOrd3").addClass("btn-secondary");
                query = "SELECT u_invent.codicearti, SUM(u_invent.quantita) as quantita, u_invent.lotto, MAX(u_invent.magazzino) as magazzino, MAX(u_invent.codcart) as codcart, MAX(magart.descrizion) as descrizion, MAX(magart.unmisura) as unmisura FROM u_invent left outer join magart on magart.codice==u_invent.codicearti where u_invent.esercizio=='" + anno + "' and u_invent.magazzino=='" + maga + "' group by u_invent.codicearti, u_invent.lotto";
                break;
            case "3":
                $("#btnOrd0").addClass("btn-secondary");
                $("#btnOrd1").addClass("btn-secondary");
                $("#btnOrd2").addClass("btn-secondary");
                $("#btnOrd3").addClass("btn-primary");
                query = "SELECT u_invent.*, magart.descrizion, magart.unmisura FROM u_invent left outer join magart on magart.codice==u_invent.codicearti where u_invent.esercizio=='" + anno + "' and u_invent.magazzino=='" + maga + "' and u_invent.warn";
                break;
        }

        xhr = jQuery.ajax({
            type: "GET",
            url: "query.php",
            data: {
                query: query
            },
            async: false,
            beforeSend: function(){
                // $("#btnsubmit").enabled = false;
                // $("#articolo").enabled = false;
            },
            complete: function(){
                // $("#btnsubmit").enabled = true;
                // $("#articolo").enabled = true;
            },
            success: function (obj, textstatus){
                var myArray = JSON.parse(obj);
                //ciclo su tutte le righe e le inserisco nella tabella
                for (var i = 0 ; i<myArray["success"].length ; i++){
                    //aggiungo la riga alla tabella
                    var idcart = myArray["success"][i]["codcart"];
                    var numCart = myArray["success"][i]["codcart"].substr(7,5);
                    var codart = myArray["success"][i]["codicearti"];
                    var descrart = myArray["success"][i]["descrizion"];
                    var lotto = myArray["success"][i]["lotto"];
                    var unMisura = myArray["success"][i]["unmisura"];
                    var qtaInv = myArray["success"][i]["quantita"];
                    var ubicaz = myArray["success"][i]["ubicaz"];
                    var warn = myArray["success"][i]["warn"];

                    var riga = "<tr>";
                    riga += "<td>" + idcart + "</td>";
                    riga += "<td>" + numCart + "</td>";
                    riga += "<td>" + codart + "</td>";
                    riga += "<td>" + descrart + "</td>";
                    riga += "<td>" + lotto + "</td>";
                    riga += "<td>" + unMisura + "</td>";
                    riga += "<td>" + qtaInv + "</td>";
                    riga += "<td>" + ubicaz + "</td>";
                    if(warn){
                        riga += "<td><i class='fas fa-flag text-danger'></i></td>";
                        riga += "<td><button class='btn btn-danger btn-block' onclick='deleteCart(\"" + idcart + "\")'><i class='fas fa-trash pr-2'></i>Elimina</button></td>";
                    }
                    else{
                        riga += "<td></td>";
                        riga += "<td></td>";
                    }

                    riga += "<tr>";

                    $("#tableSparate tbody").append(riga);
                }
            }
        });
    }
</script>