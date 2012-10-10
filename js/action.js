$(function(){ // Eseguo il contenuto quando il caricamento della pagina è stato completato
    $("#form").submit(function(){ // Eseguo la funzione quando viene eseguito il submit del form con id form
        var username = $("#username").val(); // Creo una variabile con il valore del campo username
        var password = $("#password").val(); // Creo una variabile con il valore del campo password
        $("#form").fadeOut(); // Faccio scomparire il form con effetto dissolvenza
        $("#loading").fadeIn(); // Facciamo comparire il caricamento con effetto dissolvenza
        $.ajax({ // Inizio una richiesta AJAX
            method: "POST", url: "login.class.php", data: "username="+username+"&password"+password, // Assegno i parametri AJAX
            complete: function(data){ // Eseguo la funzione quando la richiesta AJAX è stata completata
                $("#loading").fadeOut(); // Faccio scomparire il caricamento con effetto dissolvenza
                $("#dataReponse").html(data.responseText+" - <a href=\"#\" onClick=\"$("#dataResponse").fadeOut();$("#form").fadeIn();\">Torna Indietro</a>"); // Inserisco del codice HTML dentro il div dei dati ricevuti
                $("#dataResponse").fadeIn(); // Faccio comparire il div dei dati ricevuti
            }
        });
        return false;
    });
});