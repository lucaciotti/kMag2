function CercaArticolo(codicearti){
    if (codicearti.trim() == ""){
        return null;
    }

    var query = "SELECT * FROM Magart WHERE codice = '" + codicearti + "'";
    var arrArticolo = null;
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
            var myArray = JSON.parse(obj);
            if (myArray["success"].length == 0){
                //l'articolo non esiste
                arrArticolo = CercaBarcodeArt(codicearti);
            }
            else {
                //l'articolo l'ho trovato
                arrArticolo = myArray;
            }
        }
    });

    return arrArticolo;
}

function CercaBarcodeArt(barcode){
    var arrArticolo = null;
    var query = "\
                SELECT \
                codice, descrizion, magart.unmisura, unmisura1, unmisura2, unmisura3, fatt1, fatt2, fatt3, lotti \
                magalias.unmisura as um \
                FROM \
                MagArt INNER JOIN MagAlias ON allt(magalias.codicearti)==allt(magart.codice) \
                WHERE \
                allt(magalias.alias) == '" + barcode.toUpperCase() + "'";
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
            var myArray = JSON.parse(obj);
            arrArticolo = myArray;
        }
    });
    return arrArticolo;
}

var httpXml = false;

function makeHttpXml() {
    httpXml = false;
    if (window.XMLHttpRequest) { // Mozilla, Safari,...
        httpXml = new XMLHttpRequest();
    } else if (window.ActiveXObject) { // IE
        try {
            httpXml = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (e) {
            try {
                httpXml = new ActiveXObject("Microsoft.XMLHTTP");
            } catch (e) {}
        }
    }
    if (!httpXml) {
        alert('Cannot create XMLHTTP instance');
        return false;
    }
}

function sendUrl(url) {
    makeHttpXml();
    httpXml.open("GET", url, true);
    httpXml.send(null);
}

function senduser(id_testa) {
    var user = document.getElementById("user" + id_testa).value;
    var url = "writeuser.php?id=" + id_testa + "&user=" + user;
    sendUrl(url);
}

function sendpriorita(id_testa) {
    var priorita = document.getElementById("prior" + id_testa).value;
    var url = "writepriorita.php?id=" + id_testa + "&prior=" + priorita;
    sendUrl(url);
}

function sendpref(id_riga) {
    var pref = document.getElementById("pref" + id_riga).value;
    var url = "writepref.php?id=" + id_riga + "&pref=" + pref;
    sendUrl(url);
}

function checkGlobale() {
    var reqcodice = "";
    var currentfield;
    var riga;
    var trovato = false;
    var chkcodice = $("#controlloglobale").val().toUpperCase();
    var num = 1;

    $("#lista > tbody > tr").each(function() {
        var codart = $(this).find("td")[0].innerText;
        if (codart == chkcodice) {
            if ($(this).hasClass('bg-success')) {
                //l'articolo è già stato sparato quindi segno che l'ho trovato ma vado avanti
                trovato = true;
            } else {
                //l'articolo l'ho trovato ==> evidenzio la riga ed esco
                $(this).addClass('bg-success');
                trovato = true;
                return false;
            }
        }
    });

    if (!trovato) {
        alert("Articolo non trovato");
    }

    $("#controlloglobale").val("");
    document.lettura.casella.focus();
}

function checkLista() {
    var trovato = true;

    //scandisco di nuovo la lista per verificare se ho sparato tutto
    $("#lista > tbody > tr").each(function() {
        if (!$(this).hasClass('bg-success')) {
            trovato = false;
            return false;
        }
    });

    if (trovato) {
        if ($("#btn_inscolli").length) {
            $("#btn_inscolli").removeClass("disabled");
        }
        $("#checkcompleto").removeClass('invisible');
        if ($("#btn_controllook").length) {
            $("#btn_controllook").removeClass('disabled');
        }
    }
}

function countSparati(recCount) {
    var picked = 0;

    //scandisco la lista 
    $("#lista > tbody > tr").each(function() {
        if ($(this).hasClass('bg-success')) {
            picked++;
        }
    });
    var txtSparate = picked.toString() + " su " + recCount.toString();
    $("#countSparate").text(txtSparate);
}

function riordinaRighe() {
    //la funzione serve per spostare tutte le righe 
}