<?php
?>
<div class="row">
    <div class="col col-12">
        <label class="col-form-label-sm">Articolo</label>
        <div class="input-group input-group-sm">
            <input id="articolo" class="form-control form-control-sm" onkeypress="if(event.keyCode == 13) {FindArticolo(this.value);}">
            <div class="input-group-append">
                <button id="btnCercaArticolo" type="button" class="btn btn-sm btn-outline-secondary" onclick="FindArticolo($('#articolo').val());"><i class="fas fa-search"></i></button>
            </div>
        </div>
    </div>
    <div class="col col-12">
        <label id="label_descrizione" class="col-form-label-sm"></label>
    </div>
</div>
<div class="row" id="row_ubicazioni">
    <div class="col col-12">
        <label>Ubicazione corrente</label>
        <input id="ubicazione_corrente" class="form-control form-control-sm disabled" readonly>
    </div>
    <div class="col col-12">
        <label>Ubicazione futura</label>
        <div class="input-group input-group-sm">
            <input id="ubicazione_futura" class="form-control form-control-sm" onkeypress="if(event.keyCode == 13){CercaUbicazione();}">
            <div class="input-group-append">
                <button id="btnCercaUbicazione" type="button" class="btn btn-sm btn-outline-secondary" onclick="CercaUbicazione();"><i class="fas fa-search"></i></button>
            </div>
        </div>
        <label id="label_ubicazione_futura"></label>
    </div>
    <div class="col col-12 pt-2">
        <button type="submit" class="btn btn-sm btn-block btn-dark" id="btnOk" onclick="ConfermaDati();"><i class="fas fa-check pr-2"></i>OK</button>
    </div>
</div>

<script>
    $( document ).ready(function() {
        $("#row_ubicazioni").hide();
        $("#articolo").text("");
        $("#articolo").focus();
        $("#btnOk").hide();
    });

    function CercaUbicazione(){
        var ubic = $("#ubicazione_futura").val();
        if(ubic.trim()==""){
            $("#ubicazione_futura").text("");
            $("#ubicazione_futura").focus();
            $("#btnOk").show();
            return;
        }

        var query = "SELECT * FROM ubicaz WHERE codice = '" + ubic +"'";
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
                if (myArray["success"].length == 0){
                    //l'ubicazione non esiste
                    alert("L'ubicazione non esiste.");
                    $("#ubicazione_futura").val("");
                    $("#ubicazione_futura").focus();
                }
                else {
                    //l'ubicazione l'ho trovata
                    $("#label_ubicazione_futura").text(myArray["success"][0]["descrizion"]);
                    $("#btnOk").show();
                }
            }
        });
    }

    function FindArticolo(codicearti){
        if($("#articolo").attr("readonly") == "readonly"){
            return ;
        }
        codicearti = codicearti.toUpperCase().trim();

        var arrArt = CercaArticolo(codicearti);
        if(arrArt==null){
            $("#articolo").text("");
            $("#label_descrizione").text("");
            $("#row_ubicazioni").hide();

            $("#articolo").focus();
            return ;
        }

        if(arrArt["success"].length == 0){
            alert("L'articolo non esiste.");
            $("#articolo").val("");
            $("#articolo").focus();
            $("#label_descrizione").text("");
            $("#row_ubicazioni").hide();
        }
        else {
            //l'articolo l'ho trovato
            $("#articolo").val(arrArt["success"][0]["codice"]);
            $("#articolo").attr("readonly", "readonly");
            $("#btnCercaArticolo").hide();
            $("#label_descrizione").text(arrArt["success"][0]["descrizion"]);
            $("#row_ubicazioni").show();
            $("#ubicazione_corrente").val(arrArt["success"][0]["ubicazione"]);
            $("#ubicazione_futura").focus();
        }
    }

    function ConfermaDati(){
        $("#btnOk").hide();
        //aggiorno l'ubicazione dell'articolo
        var ubicazione = $("#ubicazione_futura").val();
        var codicearti = $("#articolo").val();
        var query = "UPDATE magart set ubicazione = '" + ubicazione + "' WHERE allt(codice) == allt('" + codicearti + "')";
        xhr = jQuery.ajax({
            type: "GET",
            url: "query.php",
            data: {
                query: query
            },
            async: false,
            beforeSend: function(){
            },
            complete: function(){
            },
            success: function (obj, textstatus){
                location.reload();
            }
        });
    }
</script>