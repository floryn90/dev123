<?php
include(CLASSES_DIR ."config.php");
include(CLASSES_DIR ."register.class.php");

$this->sql  = new MySQL ($_CONFIG['DB_HOST'], $_CONFIG['DB_USER'], $_CONFIG['DB_PASS'], $_CONFIG['DB_NAME']);

$register = new Register();

//controllo se è loggato? è stronzo se si vuole registrare
if(!empty($_COOKIE['admin_user']) || !empty($_COOKIE['normal_user']))
    die("<div class=\"error\">[DEBUG] Errore, non puoi registrarti se sei loggato!</div>");

print "<h2 align=\"center\">Registrazione nuovo utente</h2><br /><br />\n";
	
		if(!empty($_POST['nick'])       && 
		   !empty($_POST['pass'])       && 
		   !empty($_POST['pass_check']) && 
		   !empty($_POST['email'])) {
			
			$this->nick       = $register->VarProtect( $_POST['nick']       );
			$this->pass       = $register->VarProtect( $_POST['pass']       );
			$this->pass_check = $register->VarProtect( $_POST['pass_check'] );						
			$this->email      = $register->VarProtect( $_POST['email']      );

			if($register->check_user_exist($this->nick) == TRUE)
				die("<script>alert(\"Questo Username &egrave; gi&agrave; stato utilizzato.\");location.href = './index.php?page=register';</script>");

			if($this->pass != $this->pass_check)
				die("<script>alert(\"Le password non combaciano.\");location.href = './index.php?page=register';</script>");

			if($register->check_email_exist($this->email) == TRUE) 
				die("<script>alert(\"Questa email &egrave; gi&agrave; stata utilizzata per qualche altro account.\");location.href = './index.php?page=register';</script>");

			if($register->valid_mail($this->email) == FALSE)
				die("<script>alert(\"Questa email non &egrave; valida.\");location.href = './index.php?page=register';</script>");
			
			$this->sql->sendQuery("INSERT INTO ".__PREFIX__."users (username, password, email) VALUES ('".$this->nick."', '".md5($this->pass)."', '".$this->email."')");
			
			print "<script>alert('L\'account ".$this->nick." &egrave; stato creato con Successo!'); location.href = './index.php';</script>";
			
			exit;
			
		}else{
				print "\n<br /><br />"
				. "\n<form method=\"POST\" action=\"?page=register\" />"
				. "\n<table style=\"text-align: left;\" border=\"0\"  width=\"100%\" >"
				. "\n<tbody>"
				. "\n<tr>"
				. "\n	<td>Username</td>"
				. "\n	<td><input type=\"text\" name=\"nick\" /></td>"
				. "\n</tr>"
				. "\n<tr>"
				. "\n	<td>Password</td>"
				. "\n	<td><input type=\"password\" name=\"pass\" /></td>"
				. "\n</tr>"
				. "\n<tr>"
				. "\n	<td>Password (Ripetila)</td>"
				. "\n	<td><input type=\"password\" name=\"pass_check\" /></td>"
				. "\n</tr>"				
				. "\n<tr>"
				. "\n	<td>Email:</td>"
				. "\n	<td><input type=\"text\" name=\"email\" /></td>"
				. "\n</tr>"			
				. "\n</tbody>"
				. "\n</table>"
				. "\n<input type=\"submit\" value=\"Invia\" />"
				. "\n</form>"
				."";
		}
	
	
?>
