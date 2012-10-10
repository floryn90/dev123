<?php
/*
 *
 * @page index.php (contatti)
 * @author Florin Lungu && Luongo Vincenzo
 *
 * @date 04/01/2012 && 09/01/2012 && 17/01/2012
 *
 * Note: Pagina di contatti
 *
 */

$_SESSION['n1'] = rand(1,20);
$_SESSION['n2'] = rand(1,20);
$_SESSION['expect'] = $_SESSION['n1'] + $_SESSION['n2'];

?>
<script type="text/javascript">
$(document).ready(function(){
    $("#ajax-contact-form").submit(function(){

        var str = $(this).serialize();

        $.ajax({
            type: "POST",
            url: "pages/contact/submit.php",
            data: str,
            success: function(msg){
        
                $("#note").ajaxComplete(function(event, request, settings){
        
                    if(msg == 'OK') {
                        result = '<div class="notification_ok">Il tuo messaggio &egrave; stato inviato correttamente</div>';
                        $("#fields").hide();
                    }else if(msg == 'ERROR'){
                        result = '<div class="notification_error">[ERROR] Il messaggio non &egrave; stato inviato correttamente, riprovare!</div>';
                        $("#fields").hide();
                    }else{
                        result = msg;
                    }
                    
                    $(this).html(result);
                });
            } 
        });        
        return false;
    });
});
</script>
<?php
    print "\n\t\t <strong>Contattaci!</strong><br /><br />"    
    			."<form id=\"ajax-contact-form\" method=\"POST\" action=\"\" />"
				. "\n Nome: *<br />"
				. "\n<input type=\"text\" required name=\"nome\" />"
				. "\n <br />"
				. "\n Cognome: *<br />"
				. "\n <input type=\"text\" required name=\"cognome\" />"
				. "\n <br />"
				. "\nEmail: *<br />"
				. "\n<input type=\"text\" required name=\"email\" />"
				. "\n <br />"
				. "\nCommento *<br/>"
				. "\n <textarea rows=\"10\" cols=\"40\" required name=\"commento\" /></textarea><br />"
				. "\n<label>".$_SESSION['n1'] . " + " . $_SESSION['n2']." = </label><input class=\"textbox\" required type=\"text\" size=\"5\" name=\"captcha\" value=\"\"> *<br />"
				. "\n N.B. I campi contrasegnati dal * sono obbligatori!<br />"
				. "\n<input type=\"submit\" value=\"Invia\" />"
    			. "\n</form>";



?>

