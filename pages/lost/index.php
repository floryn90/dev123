<?php
/*
 *
 * @page index.php (Lost)
 * @author Vincenzo Luongo
 *
 * @date 20/09/2012
 *
 * Note: Pagina di recupero password
 *
 */

include(CLASSES_DIR . "config.php");
include_once(CLASSES_DIR . "security.class.php");
include_once(CLASSES_DIR ."register.class.php");

$this->sql = new MySQL ($_CONFIG['DB_HOST'], $_CONFIG['DB_USER'], $_CONFIG['DB_PASS'], $_CONFIG['DB_NAME']);

$register = new Register();
$security = new Security();

print "<h1 align=\"center\">Ripristino password</h1>";

if(@$_GET['action'] == 'send_pwd') {
	
	if(empty($_POST['email']))
		die("<script>alert(\"Errore, non hai inserito la mail!\");location.href = './index.php?page=lost';</script>");
	
	$this->email = $register->VarProtect( $_POST['email'] );
	
	if($register->valid_mail($this->email) == FALSE) 
		die("<script>alert(\"Questa email non &egrave; valida.\");location.href = './index.php?page=lost';</script>");

	if($register->check_email_exist($this->email) == FALSE)
		die("<script>alert(\"Questa mail non è registrata!\");location.href = './index.php?page=lost';</script>");
	
	// generazione nuova password
	$this->new_password = $security->random_pass();
	
	  $mail = mail($this->email, "Ripristino Password", 
	  		"Salve utente, ". $this->email ."\n
	  		\n
	  		la sua nuova password &egrave; :". $this->new_password,
             "From: ".$email."\r\n"
            ."Reply-To: ".$email."\r\n"
            ."X-Mailer: PHP/" . phpversion());
    
        if($mail) {
			//aggiornamento con la nuova password solo se l'invio email è andato a buon fine
			$this->sql->sendQuery("UPDATE ".__PREFIX__."users SET password = '".$this->new_password."' WHERE email = '".$this->email."'");
            print "<font color=\"green\">Password resettata ed inviata via email.</font>";
        }else{
			//altrimenti non aggiorno la password e stampo msg di errore
            print "<font color=\"red\">C'&egrave; stato un problema nell'invio email, riprovare in un'altro momento, o contattare l'amministratore.</font>";
		}
	
}else{
	print "<form action=\"?page=lost&action=send_pwd\" method=\"POST\" />"
		. "\n<h4 align=\"center\">Per recuperare la tua password, inserire di sequito la tua email di registrazione</h4>"
		. "\n<br />"
		. "\nTua email: <input value=\"\" type=\"text\" name=\"email\" />"
		. "\n<br />"
		. "\n<input type=\"submit\" value=\"Invia\" />"
		. "\n</form>";
}
?>