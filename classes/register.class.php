<?php
/*
 *
 * @page register.class.php
 * @author Vincenzo Luongo
 *
 * @date 18/01/2012
 *
 * Note: Classe per la gestione delle registrazioni
 *
 */

class Register extends Security  {

	public function __construct () {
	
    	include(CLASSES_DIR . "config.php");
        include_once(CLASSES_DIR . "mysql.class.php");
			
		$this->sql = new MySQL ($_CONFIG['DB_HOST'], $_CONFIG['DB_USER'], $_CONFIG['DB_PASS'], $_CONFIG['DB_NAME']);
	}	
	
	public function check_user_exist($user) {
		
		$this->user = $this->VarProtect( $user );
		
		$this->check = $this->sql->sendQuery("SELECT * FROM ".__PREFIX__."users WHERE username = '".$this->user."' limit 1;");
		
		if(mysql_num_rows($this->check) == 1)
			return TRUE;
		else
			return FALSE;
	}
	
	public function check_email_exist($email) {
		
		$this->email = $this->VarProtect( $email );
		
		$this->check = $this->sql->sendQuery("SELECT * FROM ".__PREFIX__."users WHERE email = '".$this->email."' limit 1;");
		
		if(mysql_num_rows($this->check) == 1)
			return TRUE;
		else
			return FALSE;
	}
}
?>
