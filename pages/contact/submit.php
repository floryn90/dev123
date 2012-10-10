<?php
session_start();

function validEmail($email) {

    $regex = '/([a-z0-9_.-]+)@([a-z0-9.-]+){2,255}.([a-z]+){2,10}/i';
    
    if($email == '')
    	return false;
    else
        $eregi = preg_replace($regex, '', $email);

    return empty($eregi) ? true : false;
}

$emails = "king-infet@autistici.org, florin90@tiscali.it";

$post = (!empty($_POST)) ? true : false;

if($post) {

    $captcha = (int) $_POST['captcha'];
    $email   = $_POST['email'];
    $cognome = stripslashes($_POST['cognome']);
    $name    = stripslashes($_POST['nome']);
    $oggetto = empty($_POST['subject']) ? "FeedBack" : htmlspecialchars($_POST['subject']);
    $message = htmlentities("Il Signor: ".$name." ".$cognome.stripslashes($_POST['commento']));

    $error = '';
    
    
    if($captcha != $_SESSION['expect'])
        $error .= '[ERROR] Captcha errato!<br />';

    if(!$name)
        $error .= '[ERROR] Inserire il nome!<br />';
        
    if(!$cognome)
        $error .= '[ERROR] Inserire il cognome!<br />';
        
    if(validEmail($email) == false)
        $error .= '[ERROR] Inserire una email valida!<br />';

    if(!$message || strlen($message) < 15)
        $error .= "[ERROR] Prego inserire il messaggio, esso deve essere maggiore di 15 caratteri.<br />";


    if(!$error) {
        $mail = mail($emails, $oggetto, $message,
             "From: ".$email."\r\n"
            ."Reply-To: ".$email."\r\n"
            ."X-Mailer: PHP/" . phpversion());
    
        if($mail)
            print 'OK';
        else
            print 'ERROR';
    
    }else
        print '<div class="error">'.$error.'</div>';
    
}
?>
