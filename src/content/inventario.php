<div class="collapse" id="collapsetop">
    <div class="row pt-2">
        <div class="col col-7">
            <label class="text-xs">Cartellino</label>
            <div class="input-group input-group-sm">
                <input id="cartellino" class="form-control form-control-sm" onkeypress="if(event.keyCode == 13){CercaCartellino();}">
                <div class="input-group-append">
                    <button id="btnCercaCartellino" type="button" class="btn btn-sm btn-outline-secondary" onclick="CercaCartellino();"><i class="fas fa-search"></i></button>
                </div>
            </div>
        </div>
        <div class="col col-5" id="riga_magazzino">
            <label class="text-xs">Magazzino</label>
            <input id="magazzino" class="form-control form-control-sm" readonly>
        </div>

    </div>
    <div class="row" id="riga_articolo">
        <div class="col col-12">
            <label class="text-xs">Articolo</label>
            <div class="input-group input-group-sm">
                <input id="articolo" class="form-control form-control-sm" onkeypress="if(event.keyCode == 13) {FindArticolo(this.value);}">
                <div class="input-group-append">
                    <button id="btnCercaArticolo" type="button" class="btn btn-sm btn-outline-secondary" onclick="FindArticolo($('#articolo').val());"><i class="fas fa-search"></i></button>
                </div>
            </div>
            <label id="label_articolo" class="text-gray text-xs"></label>
        </div>
    </div>
    <div class="row">
        <div class="col col-6" id="riga_lotto">
            <label class="text-xs">Lotto</label>
            <div class="input-group input-group-sm">
                <input id="lotto" class="form-control form-control-sm" onkeypress="if(event.keyCode == 13) {CercaLotto();}">
                <div class="input-group-append">
                    <button id="btnCercaLotto" type="button" class="btn btn-sm btn-outline-secondary" onclick="CercaLotto();"><i class="fas fa-search"></i></button>
                </div>
            </div>
        </div>
        <div class="col col-6" id="riga_ubicazione">
            <label class="text-xs">Ubicazione</label>
            <div class="input-group input-group-sm">
                <input id="ubicazione" class="form-control form-control-sm" onkeypress="if(event.keyCode == 13) {CercaUbicazione();}">
                <div class="input-group-append">
                    <button id="btnCercaUbicazione" type="button" class="btn btn-sm btn-outline-secondary" onclick="CercaUbicazione();"><i class="fas fa-search"></i></button>
                </div>
            </div>
            <label id="label_ubicazione" class="text-gray text-xs"></label>
        </div>
    </div>
    <div class="row pb-2" id="riga_qta">
        <div class="col col-3">
            <label class="text-xs">UM</label>
            <select class="form-control form-control-sm" id="unmisura" onchange="VisualizzaConversione();">
            </select>
        </div>
        <div class="col col-2 align-text-bottom">
            <label class="text-xs">Fatt.</label>
            <label class="text-lg text-bold" id="label_fatt"></label>
        </div>
        <div class="col col-7">
            <label class="text-xs">Quantità</label>
            <div class="input-group input-group-sm">
                <input id="quantita" type="number" min="0" class="form-control form-control-sm" onkeypress="if(event.keyCode == 13) {CheckQuantita();}">
                <div class="input-group-append">
                    <button id="btnCheckQuantita" type="button" class="btn btn-sm btn-outline-secondary" onclick="CheckQuantita();"><i class="fas fa-check"></i></button>
                </div>
            </div>
        </div>
    </div>
    <div class="row pt-2">
        <div class="col col-4">
            <button id="btnSegnalaErrato" class="btn btn-danger btn-block btn-sm h-100" onclick="SegnalaErrato();">
                <div><i class="fas fa-asterisk pr-2"></i></div>
                <div>Segnala Errato</div>
            </button>
        </div>
        <div class="col col-4">
            <button id="btnUbicazioni" class="btn btn-sm btn-secondary h-100 btn-block" onclick="VisualizzaSparate();">
                <div><i class="fas fa-list pr-2"></i></div>
                <div>Elenco Sparate</div>
            </button>
        </div>
        <div class="col col-4">
            <button id="btnConferma" class="btn btn-primary btn-block btn-sm h-100" onclick="ConfermaDati();">
                <div><i class="fas fa-check pr-2"></i></div>
                <div>Conferma</div>
            </button>
        </div>
    </div>
</div>
<div class="collapse" id="riga_tabellaubicazioni">
    <div class="row">
        <div class="col col-12 pt-2 pb-2">
            <button class="btn btn-sm btn-block btn-primary" onclick="TornaAlCartellino();">Torna al cartellino</button>
        </div>
        <div class="col col-12">
            <label class="text-xs">Sparate Inventario Effettuate in UBICAZIONE</label>
            <table id="tabella_sparate" class="table table-sm table-striped">
                <thead class="table-dark">
                    <tr>
                        <td>Codice</td>
                        <td>Descrizione</td>
                        <td>Q.tà</td>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
</div>

<input readonly id="termid" value="<?php echo $termid; ?>" hidden>
<input readonly id="ubicazObb" value="<?php echo (CONFIGWEB::$IS_FILIALE ? "0" : "1"); ?>" hidden>
<input readonly id="umDefault" value="" hidden>

<script>
    $(document).ready(function() {
        $("#riga_magazzino").hide();
        $("#riga_articolo").hide();
        $("#riga_lotto").hide();
        $("#riga_qta").hide();
        $("#riga_ubicazione").hide();
        $("#btnConferma").hide();
        $("#btnSegnalaErrato").hide();
        $("#btnUbicazioni").hide();
        $("#collapsetop").collapse("show");
        $("#riga_tabellaubicazioni").collapse("hide");
        $("#cartellino").focus();
    });

    function VisualizzaConversione() {
        var um = $("#unmisura").val();
        $("#label_fatt").text(um + " * ");

        //nascondo il pulsante conferma perchè se cambio l'nità di misura devo rifare il check della quantità
        $("#btnConferma").hide();
    }

    function TornaAlCartellino() {
        $("#riga_tabellaubicazioni").collapse("hide");
        $("#collapsetop").collapse("show");
        $("#quantita").focus();
    }

    function CercaCartellino() {
        if ($("#cartellino").attr("readonly") == "readonly") {
            return;
        }

        var idcartellino = $("#cartellino").val().trim().toUpperCase();
        if (idcartellino == "" || idcartellino.length > 13) {
            alert("Cartellino non trovato!");
            $("#cartellino").val("");
            $("#cartellino").focus();
            return;
        }

        if (idcartellino.substring(0, 2) != "24") {
            alert("Codice cartellino non valido.");
            $("#cartellino").val("");
            $("#cartellino").focus();
            return;
        }

        //vado a vedere se il cartellino è già stato sparato
        var isSparato = false;
        jQuery.ajax({
            type: "GET",
            url: "query.php",
            data: {
                query: "SELECT u_invent.* FROM u_invent WHERE codcart = '" + idcartellino + "'"
            },
            async: false,
            success: function(obj, textstatus) {
                var myArray = JSON.parse(obj);
                if (myArray["success"].length > 0) {
                    //il cartellino è già stato sparato
                    isSparato = true;

                    if (myArray["success"][0]["warn"] == true) {
                        alert("Il cartellino è già segnalato come errato.");
                        $("#cartellino").val("");
                        $("#cartellino").focus();
                        return;
                    }
                    alert("Il cartellino è già stato sparato");

                    $("#btnCercaCartellino").hide();

                    //visualizzo i dati del cartellino
                    $("#riga_magazzino").show();
                    $("#magazzino").val(myArray["success"][0]["magazzino"]);

                    $("#riga_articolo").show();
                    $("#articolo").val(myArray["success"][0]["codicearti"]);
                    FindArticolo(myArray["success"][0]["codicearti"]);
                    $("#articolo").attr("readonly", "readonly");
                    $("#btnCercaArticolo").hide();

                    $("#riga_lotto").show();
                    $("#lotto").val(myArray["success"][0]["lotto"]);
                    $("#lotto").attr("readonly", "readonly");
                    $("#btnCercaLotto").hide();

                    $("#riga_ubicazione").show();
                    $("#ubicazione").val(myArray["success"][0]["ubicaz"]);
                    CercaUbicazione();
                    $("#ubicazione").attr("readonly", "readonly");
                    $("#btnCercaUbicazione").hide();

                    $("#riga_qta").show();
                    $("#quantita").val(myArray["success"][0]["quantita"]);
                    $("#quantita").attr("readonly", "readonly");
                    $("#unmisura").attr("readonly", "readonly");
                    VisualizzaConversione();
                    $("#btnCheckQuantita").hide();

                    $("#btnSegnalaErrato").show();
                }
            }
        });

        if (isSparato == true) {
            return;
        }

        var maga = idcartellino.substring(4, 7);
        var query = "SELECT * FROM MAGANA WHERE RIGHT(alltrim(codice),3) = '" + maga + "'";
        xhr = jQuery.ajax({
            type: "GET",
            url: "query.php",
            data: {
                query: query
            },
            async: false,
            success: function(obj, textstatus) {
                var myArray = JSON.parse(obj);
                if (myArray["success"].length == 0) {
                    //il magazzino non esiste
                    alert("Il magazzino non esiste.");
                    $("#cartellino").val("");
                    $("#cartellino").focus();
                } else {
                    //il magazzino l'ho trovato
                    $("#riga_magazzino").show();
                    $("#magazzino").val(myArray["success"][0]["codice"]);

                    $("#riga_articolo").show();
                    $("#articolo").val("");
                    $("#articolo").focus();
                }
            }
        });

        $("#cartellino").attr("readonly", "readonly");
        $("#btnCercaCartellino").hide();
    }

    function FindArticolo(codicearti) {
        if ($("#articolo").attr("readonly") == "readonly") {
            return;
        }

        codicearti = codicearti.toUpperCase();
        var arrArt = CercaArticolo(codicearti);

        if (arrArt == null) {
            $("#articolo").focus();
            return;
        }

        if (arrArt["success"].length == 0) {
            //l'articolo non l'ho trovato
            alert("L'articolo non esiste.");
            $("#articolo").val("");
            $("#articolo").focus();
        } else {
            $("#articolo").val(arrArt["success"][0]["codice"]);
            $("#label_articolo").text(arrArt["success"][0]["descrizion"]);

            var um = arrArt["success"][0]["unmisura"];
            var um1 = arrArt["success"][0]["unmisura1"];
            var um2 = arrArt["success"][0]["unmisura2"];
            var um3 = arrArt["success"][0]["unmisura3"];
            var fatt1 = arrArt["success"][0]["fatt1"];
            var fatt2 = arrArt["success"][0]["fatt2"];
            var fatt3 = arrArt["success"][0]["fatt3"];
            var lottoSi = arrArt["success"][0]["lotti"];

            $("#umDefault").val(um);
            $("#unmisura").empty();
            $("#unmisura").append('<option value="1">' + um + '</option>');

            if (um1 != um) {
                $("#unmisura").append('<option value="' + fatt1 + '">' + um1 + '</option>');
            }
            if (um2 != um1) {
                if (um2 != um) {
                    $("#unmisura").append('<option value="' + fatt2 + '">' + um2 + '</option>');
                }
            }
            if (um3 != um2) {
                if (um3 != um1) {
                    if (um3 != um) {
                        $("#unmisura").append('<option value="' + fatt3 + '">' + um3 + '</option>');
                    }
                }
            }
            $("#articolo").attr("readonly", "readonly");
            $("#btnCercaArticolo").hide();
            VisualizzaConversione();
            $("#lotto").val("");
            $("#riga_lotto").show();
            if (lottoSi) {
                $("#lotto").focus();
            } else {
                $("#lotto").attr("readonly", "readonly");
                $("#btnCercaLotto").hide();

                $("#riga_ubicazione").show();
                //Solo se Ubicaz è Obbligatoria
                if ($("#ubicazObb").val() == "1") {
                    $("#ubicazione").focus();
                } else {
                    $("#riga_qta").show();
                    $("#quantita").focus();
                }
            }
        }
    }

    function CercaLotto() {
        if ($("#lotto").attr("readonly") == "readonly") {
            return;
        }
        var lotto = $("#lotto").val().trim().toUpperCase();
        var codicearti = $("#articolo").val().trim().toUpperCase();
        var query = "SELECT codice, codicearti FROM Lotti WHERE allt(codicearti) == allt('" + codicearti + "') AND allt(codice) == allt('" + lotto + "')";
        xhr = jQuery.ajax({
            type: "GET",
            url: "query.php",
            data: {
                query: query
            },
            async: false,
            beforeSend: function() {},
            complete: function() {},
            success: function(obj, textstatus) {
                var myArray = JSON.parse(obj);
                if (myArray["success"].length == 0) {
                    alert("Il lotto non esiste. IMPORTANTE verificare su ARCA!");
                    $("#lotto").val("");
                    $("#lotto").focus();
                    //Il lotto non esiste
                    // if (!confirm("Il lotto non esiste. Confermare lo stesso?")) {
                    //     $("#lotto").val("");
                    //     $("#lotto").focus();
                    // } else {
                    //     $("#lotto").attr("readonly", "readonly");
                    //     $("#btnCercaLotto").hide();

                    //     //il lotto va bene lo stesso
                    //     $("#riga_ubicazione").show();
                    //     if ($("#ubicazObb").val() == "1") {
                    //         $("#ubicazione").focus();
                    //     } else {
                    //         $("#riga_qta").show();
                    //         $("#quantita").focus();
                    //     }
                    // }
                } else {
                    $("#lotto").val(lotto);
                    $("#lotto").attr("readonly", "readonly");
                    $("#btnCercaLotto").hide();

                    //Il lotto l'ho trovato
                    $("#riga_ubicazione").show();
                    //Solo se Ubicaz è Obbligatoria
                    if ($("#ubicazObb").val() == "1") {
                        $("#ubicazione").focus();
                    } else {
                        $("#riga_qta").show();
                        $("#quantita").focus();
                    }
                }
            }
        });
    }

    function CercaUbicazione() {
        if ($("#ubicazione").attr("readonly") == "readonly") {
            return;
        }
        var ubicazione = $("#ubicazione").val().toUpperCase();

        if (ubicazione.trim() == "" && $("#ubicazObb").val() == "1") {
            //l'ubicazione è un campo obbligatorio
            alert("L'ubicazione non può essere vuota.");
            $("#ubicazione").focus();
            return;
        }
        var query = "SELECT codice, descrizion FROM ubicaz WHERE allt(codice)==allt('" + ubicazione + "')";
        xhr = jQuery.ajax({
            type: "GET",
            url: "query.php",
            data: {
                query: query
            },
            async: false,
            beforeSend: function() {},
            complete: function() {},
            success: function(obj, textstatus) {
                var myArray = JSON.parse(obj);
                if (myArray["success"].length == 0) {
                    //L'ubicazione non esiste
                    $("#ubicazione").val("");
                    $("#ubicazione").focus();
                } else {
                    $("#ubicazione").val(ubicazione);
                    $("#ubicazione").attr("readonly", "readonly");
                    $("#btnCercaUbicazione").hide();

                    //L'ubicazione l'ho trovata
                    $("#label_ubicazione").text(myArray["success"][0]["descrizion"]);
                    $("#riga_qta").show();
                    $("#quantita").focus();
                    $("#btnUbicazioni").show();
                }
            }
        });
    }

    function CheckQuantita() {
        if ($("#quantita").attr("readonly") == "readonly") {
            return;
        }
        var qta = $("#quantita").val();
        if (qta < 0) {
            alert("Hai inserito una quantità negativa.");
            $("#quantita").val(0);
            $("#quantita").focus();
            return;
        }

        var umDefTxt = $("#umDefault").val();
        var umSelTxt = $("#unmisura option:selected").text();
        var um = $("#unmisura").val();
        if (um != 1) {
            var qta2 = qta * um;
            var message = umSelTxt + " " + qta + "  ==>  " + umDefTxt + " " + qta2 + "\nPROCEDO?";
        } else {
            var message = umDefTxt + " " + qta + "\nPROCEDO?";
        }

        if (!confirm("ATTENZIONE!!\n" + message)) {
            return;
        }

        $("#btnConferma").show();
        $("#btnConferma").focus();
    }

    function SegnalaErrato() {
        if (!confirm("Vuoi segnalare come errata la sparata di inventario?")) {
            return;
        }

        //aggiorno la sparata come segnalazione errata
        var idcartellino = $("#cartellino").val().trim();
        var queryUpd = "update u_invent set warn = .T. WHERE codcart = '" + idcartellino + "'";
        jQuery.ajax({
            type: "GET",
            url: "query.php",
            data: {
                query: queryUpd
            },
            async: false,
            success: function(obj, textstatus) {
                location.reload();
            }
        });
    }

    function VisualizzaSparate() {
        var ubicazione = $("#ubicazione").val();
        var magazzino = $("#magazzino").val();
        var esercizio = "20" + $("#cartellino").val().substring(2, 4);

        $("#collapsetop").collapse('hide');

        $("#riga_tabellaubicazioni").collapse("show");
        $("#tabella_sparate > tbody").empty();
        var query = "SELECT u_invent.*, magart.descrizion FROM u_invent LEFT JOIN magart ON MagArt.codice == u_invent.codicearti WHERE allt(ubicaz) == allt('" + ubicazione + "') and allt(magazzino) == allt('" + magazzino + "') and esercizio == '" + esercizio + "'";
        xhr = jQuery.ajax({
            type: "GET",
            url: "query.php",
            data: {
                query: query
            },
            async: true,
            success: function(obj, textstatus) {
                var myArray = JSON.parse(obj);
                if (myArray["success"].length == 0) {
                    //non ci sono sparate
                } else {
                    for (i = 0; i < myArray["success"].length; i++) {
                        //aggiungo la riga alla tabella
                        var row = myArray["success"][i];
                        var newrow = "";
                        if (row["warn"] == true) {
                            newrow = "<tr class='bg-danger'><td>" + row["codicearti"] + "</td><td>" + row["descrizion"] + "</td><td>" + row["quantita"] + "</td></tr>";
                        } else {
                            newrow = "<tr><td>" + row["codicearti"] + "</td><td>" + row["descrizion"] + "</td><td>" + row["quantita"] + "</td></tr>";
                        }

                        $('#tabella_sparate tbody:last-child').append(newrow);
                    }
                }
            }
        });
    }

    function ConfermaDati() {
        if (!confirm("Confermare la sparata di inventario?")) {
            return;
        }

        //salvo i dati
        var idcartellino = $("#cartellino").val().trim();
        var qta = $("#quantita").val();
        var lotto = $("#lotto").val();
        var codicearti = $("#articolo").val();
        var um = $("#unmisura").val();
        var ubicazione = $("#ubicazione").val();
        var magazzino = $("#magazzino").val();
        var termid = $("#termid").val();
        var esercizio = "20" + idcartellino.substring(2, 4);

        var query = "SELECT * FROM u_invent WHERE codcart = '" + idcartellino + "'";
        xhr = jQuery.ajax({
            type: "GET",
            url: "query.php",
            data: {
                query: query
            },
            async: false,
            success: function(obj, textstatus) {
                var myArray = JSON.parse(obj);
                if (myArray["success"].length == 0) {
                    //il cartellino non esiste e quindi lo inserisco
                    var queryIns = "INSERT INTO u_invent (codicearti, quantita, magazzino, lotto, id_term, timestamp, codcart, esercizio, ubicaz) ";
                    queryIns += "VALUES('" + codicearti + "', ";
                    queryIns += (qta * um).toString() + ", ";
                    queryIns += "'" + magazzino + "', ";
                    queryIns += "'" + lotto + "', ";
                    queryIns += termid + ", ";
                    queryIns += "datetime(), ";
                    queryIns += "'" + idcartellino + "', ";
                    queryIns += "'" + esercizio + "', ";
                    queryIns += "'" + ubicazione + "' ";
                    queryIns += ")";
                    jQuery.ajax({
                        type: "GET",
                        url: "query.php",
                        data: {
                            query: queryIns
                        },
                        async: false,
                        success: function(obj, textstatus) {
                            location.reload();
                        }
                    });
                } else {
                    //il cartellino esiste già e quindi lo aggiorno
                    var queryUpd = "update u_invent set quantita = " + (qta * um).toString() + ", id_term = " + termid + ", timestamp = datetime() WHERE codcart = '" + idcartellino + "'";
                    jQuery.ajax({
                        type: "GET",
                        url: "query.php",
                        data: {
                            query: queryUpd
                        },
                        async: false,
                        success: function(obj, textstatus) {
                            location.reload();
                        }
                    });
                }
            }
        });
    }
</script>