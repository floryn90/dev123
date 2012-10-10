<?php
/*
 *
 * @page index.php (Gestione User)
 * @author Vincenzo Luongo && Florin Lungu
 *
 * @date 25/11/2011 && 09/01/2012 && 16/01/2012 && 18/04/2012 && 26/04/2012
 *
 * Note: Pagina di gestione profili utenti
 *
 */

include(CLASSES_DIR . "config.php");
include_once(CLASSES_DIR . "security.class.php");

$this->sql = new MySQL ($_CONFIG['DB_HOST'], $_CONFIG['DB_USER'], $_CONFIG['DB_PASS'], $_CONFIG['DB_NAME']);

//Aggiornamento email
if(@$_GET['action'] == 'update_email') {

	$this->sql->security_token($_POST['security'], $_SESSION['token']);
	
	if($this->valid_mail($_POST['email'])) {
	
        if($_COOKIE['normal_user']) {
        
            $this->sql->sendQuery("UPDATE ".__PREFIX__."users SET email = '".mysql_real_escape_string($_POST['email'])."' WHERE id = ".(int) $_POST['id_user']);
                    
            print "<script>alert(\"Email aggiornata con successo!\");</script>";
            
        }elseif($_COOKIE['admin_user']) {
        
            $this->sql->sendQuery("UPDATE ".__PREFIX__."administrators SET email = '".mysql_real_escape_string($_POST['email'])."' WHERE id = ".(int) $_POST['id_user']);
            
            print "<script>alert(\"Email aggiornata con successo!\"); window.location=\"./index.php?page=gestione_user\";</script>";
        }
        
	}else{
        print "<script>alert(\"Email non valida!\"); window.location=\"./index.php?page=gestione_user\";</script>";

	}
}//end update_email
elseif(@$_GET['action'] == 'update_password') {

		$this->sql->security_token($_POST['security'], $_SESSION['token']);
		
	    if(@$_COOKIE['normal_user']) {
		
			if($_POST['nuova_password'] == $_POST['nuova_password_2']) {
				die("<script>alert(\"Le nuove password non coincidono!\n Riprova, facendo pi&ugrave; attenzione!\"); window.location=\"index.php?page=gestione_user\";</script>");
			}
        
            $this->password = $this->sql->sendQuery("SELECT password FROM ".__PREFIX__."users  WHERE username = ".mysql_real_escape_string($_COOKIE['normal_user']));
			
            $query = mysql_fetch_array($this->password);
				
			if($query['password'] == MD5($_POST['vecchia_password'])) {
			
				$this->sql->sendQuery("UPDATE ".__PREFIX__."users SET password = ".MD5($_POST['nuova_password'])." WHERE id = ".(int) $_POST['id_user']);
				print "<script>alert(\"Password aggiornata con successo!\");</script>";
				
			}else
				die("<script>alert(\"La password che ti ricordavi tu non sembra la stessa che ci ricordiamo noi!\n Riprova!\"); window.location=\"index.php?page=gestione_user\";</script>");
			
		}elseif(@$_COOKIE['admin_user']){
		
			if($_POST['nuova_password'] == $_POST['nuova_password_2']) {
				die("<script>alert(\"Le nuove password non coincidono!\n Riprova, facendo pi&ugrave; attenzione!\"); window.location=\"index.php?page=gestione_user\";</script>");
			}
        
            $this->password = $this->sql->sendQuery("SELECT password FROM ".__PREFIX__."administrators  WHERE username = ".mysql_real_escape_string($_COOKIE['normal_user']));
			
            $query = mysql_fetch_array($this->password);
				
			if($query['password'] == MD5($_POST['vecchia_password'])) {
			
				$this->sql->sendQuery("UPDATE ".__PREFIX__."administrators SET password = ".MD5($_POST['nuova_password'])." WHERE id = ".(int) $_POST['id_user']);
				print "<script>alert(\"Password aggiornata con successo!\");</script>";
				
			}else
				die("<script>alert(\"La password che ti ricordavi tu non sembra la stessa che ci ricordiamo noi!\n Riprova!\"); window.location=\"index.php?page=gestione_user\";</script>");
		}
	}// end update_password
	
print "\n<div id=\"article\"><table style=\"border-collapse: collapse;\" border=\"0\" align=\"center\" cellpadding=\"10\" cellspacing=\"1\">"
	. "<center><strong>Gestisci il tuo Profilo</strong></center><br /><br />"
	. "\n<p align=\"center\"><a href=\"javascript:location.reload()\">Click per ricaricare la pagina</a></p>"
	. "\n<tbody>"
	. "\n	<tr align=\"center\">"
	. "\n	  <td><b>La tua Email: </b></td>"
	. "\n<form method=\"POST\" action=\"./index.php?page=gestione_user&token=".$_SESSION['token']."&action=update_email\" />"
    . "\n<input type=\"hidden\" name=\"security\" value=\"".$_SESSION['token']."\" />";
			
if(@$_COOKIE['normal_user']) {
	
    $this->utente = $this->sql->sendQuery ("SELECT id, username, email FROM ".__PREFIX__."users WHERE username = '".mysql_real_escape_string($_COOKIE['normal_user'])."' LIMIT 1");
	$this->user   = mysql_fetch_array($this->utente);
			
	print "\n<td><input type=\"text\" required name=\"email\" value=\"".htmlspecialchars($this->user['email'])."\"></td>"
	    . "\n<td><input type=\"hidden\" name=\"id_user\" value=\"".(int) $this->user['id']."\" /></td>"
		. "\n</tr>"
		. "\n<tr><td></td><td><input type=\"submit\" value=\"Aggiorna email\"></td></tr>";
				
}elseif(@$_COOKIE['admin_user']) {
		
	$this->admin = $this->sql->sendQuery ("SELECT id, username, email FROM ".__PREFIX__."administrators WHERE username = '".mysql_real_escape_string($_COOKIE['admin_user'])."' LIMIT 1");
	$this->admin = mysql_fetch_array($this->admin);
			
	print "\n<td><input type=\"text\" required name=\"email\" value=\"".htmlspecialchars($this->admin['email'])."\"></td>"
	    . "\n<input type=\"hidden\" name=\"id_user\" value=\"".(int) $this->admin['id']."\" />"
		. "\n </tr>"
		. "\n<tr><td></td><td><input type=\"submit\" value=\"Aggiorna email\"></td></tr>";
}
		print "\n</form>"
			. "<form method=\"POST\" action=\"./index.php?page=gestione_user&token=".$_SESSION['token']."&action=update_password\" />";


		print "\n<tr align=\"center\">"
			. "\n	<td><b>Resetta la tua password: </b></td>"
			. "\n<form method=\"POST\" action=\"./index.php?page=gestione_user&token=".$_SESSION['token']."&action=update\" />"
			. "\n<input type=\"hidden\" name=\"security\" value=\"".$_SESSION['token']."\" />";
			
if(@$_COOKIE['normal_user']) {
	
    $this->utente = $this->sql->sendQuery ("SELECT id, username, password FROM ".__PREFIX__."users WHERE username = '".mysql_real_escape_string($_COOKIE['normal_user'])."' LIMIT 1");
	$this->user   = mysql_fetch_array($this->utente);
			
	print "\n<td>Vecchia password<br /><input type=\"text\" required name=\"vecchia_password\" ></td>"
		. "\n<td>Nuova password<br /><input type=\"text\" required name=\"nuova_password\" ></td>"
		. "\n<td>Ripetti nuova password<br /><input type=\"text\" required name=\"nuova_password_2\" ></td>"
	    . "\n<td><input type=\"hidden\" name=\"id_user\" value=\"".(int) $this->user['id']."\" /></td>"
		. "\n</tr>"
		. "\n<tr><td></td><td><input type=\"submit\" value=\"Aggiorna password\"></td></tr>";
				
}elseif(@$_COOKIE['admin_user']) {
		
	$this->admin = $this->sql->sendQuery ("SELECT id, username, password FROM ".__PREFIX__."administrators WHERE username = '".mysql_real_escape_string($_COOKIE['admin_user'])."' LIMIT 1");
	$this->admin = mysql_fetch_array($this->admin);
			
	print "\n<td>Vecchia password<br /><input type=\"text\" required name=\"vecchia_password\" ></td>"
		. "\n<td>Nuova password<br /><input type=\"text\" required name=\"nuova_password\" ></td>"
		. "\n<td>Ripetti nuova password<br /><input type=\"text\" required name=\"nuova_password_2\" ></td>"
	    . "\n<td><input type=\"hidden\" name=\"id_user\" value=\"".(int) $this->user['id']."\" /></td>"
		. "\n</tr>"
		. "\n<tr><td></td><td><input type=\"submit\" value=\"Aggiorna password\"></td></tr>";
}
		
print "\n</form>"
    . "\n</tbody>"
	. "\n</table>" 
	. "\n</div>";
?>
