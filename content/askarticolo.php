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
</div>

<script>
    $( document ).ready(function() {
        $("#articolo").text("");
        $("#articolo").focus();
    });

    function FindArticolo(codicearti){
        codicearti = codicearti.toUpperCase().trim()    ;
        var arrArt = CercaArticolo(codicearti);
        if (arrArt==null){
            //articolo vuoto
            $("#articolo").text("");
            $("#articolo").focus();
            return ;
        }

        if(arrArt["success"].length == 0){
            //non ho trovato l'articolo
            alert("L'articolo non esiste.");
            $("#articolo").val("");
            $("#articolo").focus();
            return ;
        }
        else {
            codicearti = arrArt["success"][0]["codice"];
            $("#articolo").val(codicearti);
            location.href = "disponibilita_art.php?codicearti=" + codicearti;
        }
    }
</script>

