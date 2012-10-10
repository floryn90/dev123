<?php
/*
 *
 * @page login.class.php
 * @author Vincenzo Luongo
 *
 * @date 25/11/2011 && 16/01/2012 && 18/04/2012
 *
 * Note: Classe per la gestione del login di amministrazione :P
 *
 */

class Login extends Security {

	public function __construct () {
	
	    include(CLASSES_DIR . "config.php");
        include_once(CLASSES_DIR . "mysql.class.php");
			
		$this->sql = new MySQL ($_CONFIG['DB_HOST'], $_CONFIG['DB_USER'], $_CONFIG['DB_PASS'], $_CONFIG['DB_NAME']);
	}
	
	/*
	 * FUNZIONI NORMALI UTENTI
	 */

		 
	public function is_user($user, $pass) {
		
		$this->username = strtolower($this->VarProtect ($user));
		$this->password = $this->VarProtect ($pass);
		
		$query = $this->sql->sendQuery("SELECT * FROM ".__PREFIX__."users WHERE username='".$this->username."'");
		
		while ($ris = mysql_fetch_array ($query))
			if ($this->username == strtolower($ris['username']) && $this->password == $ris['password'])
				return TRUE; //ok è un normale utente
			else
				return FALSE; //no è uno stronzo
	}
	
	public function send_login_normal_user ($username, $password) {
	
		$this->username = strtolower($this->VarProtect($username));
		$this->password = md5($password);
		
		$this->login = $this->sql->sendQuery ("SELECT * FROM ".__PREFIX__."users WHERE username = '".$this->username."' LIMIT 1");
		
		while ($this->user = mysql_fetch_array ($this->login)) {
		
			if ($this->username == strtolower($this->user['username']) && $this->password == $this->user['password']) {			
			
				setcookie ("normal_user", $this->username, time () + (3600 * 24), "/");
				setcookie ("normal_pass", $this->password, time () + (3600 * 24), "/");
				
				$this->token = $this->generate_token();
				
				$_SESSION['token'] = $this->token;	
	
				return TRUE;
			}else{
				return FALSE;
			}
		}
	}
	
	/*
	 * FUNZIONI AMMINISTRATIVE
	 */
	
	public function is_admin($user, $pass) {
		
		$this->username = strtolower($this->VarProtect ($user));
		$this->password = $this->VarProtect ($pass);
		
		$query = $this->sql->sendQuery("SELECT * FROM ".__PREFIX__."administrators WHERE username='".$this->username."'");
		
		while ($ris = mysql_fetch_array ($query))
			if ($this->username == strtolower($ris['username']) && $this->password == $ris['password'])
				return TRUE; //ok è amministratore
			else
				return FALSE; //no è uno stronzo
	}
	
    public function send_login_admin ($username, $password) {
	
		$this->username = strtolower($this->VarProtect($username));
		$this->password = md5($password);
		
		$this->login = $this->sql->sendQuery ("SELECT * FROM ".__PREFIX__."administrators WHERE username = '".$this->username."' LIMIT 1");
		
		while ($this->user = mysql_fetch_array ($this->login)) {
		
			if ($this->username == strtolower($this->user['username']) && $this->password == $this->user['password']) {			
			
				setcookie ("admin_user", $this->username, time () + (3600 * 24), "/");
				setcookie ("admin_pass", $this->password, time () + (3600 * 24), "/");
				
				
				$this->token = $this->generate_token();
				
				$_SESSION['token'] = $this->token;	
	
				return TRUE;
			}else{
				return FALSE;
			}
		}
	}
	
	public function logout($user, $pass, $token) {
		
		$this->security_token($token, $_SESSION['token']);
		
		$this->username = $this->VarProtect($user);
		$this->password = $this->VarProtect($pass);		
		
		if($this->is_admin($this->username, $this->password) == TRUE) {
			setcookie ("admin_user", $this->username, time () - (3600 * 24), "/");
			setcookie ("admin_pass", $this->password, time () - (3600 * 24), "/");
			
			die(header('Location: index.php'));
			
		}elseif($this->is_user($this->username, $this->password) == TRUE) {
		
		    setcookie ("normal_user", $this->username, time () - (3600 * 24), "/");
			setcookie ("normal_pass", $this->password, time () - (3600 * 24), "/");
			
			die(header('Location: index.php'));
		}
	}
	
	public function form_login($user, $pass) {

		if(!empty($user) && !empty($pass)) 
		{	
			if($this->send_login_admin($user, $pass) == TRUE) {
			
				print "<b>Benvenuto ".htmlspecialchars($_COOKIE['admin_user'])."!</b><br />";
				
				die(header('Location: ./'));
				
			}elseif($this->send_login_normal_user($user, $pass) == TRUE) {
			
				print "<script><b>Benvenuto ".htmlspecialchars($_COOKIE['normal_user'])."!</b></script>";
				
				die(header('Location: ./'));
				
			}elseif(($this->send_login_normal_user($user, $pass) == FALSE) || 
			        ($this->send_login_admin($user, $pass) == FALSE)) {
                   
                   print "<div class=\"login_error\">Username o Password ERRATI <a href=\"./\">Back</a></div>";
			}
		}else{
		    $pagina = $_SERVER["SCRIPT_NAME"];
            $tmp    = explode('/', $pagina);
            $pagina = $tmp[count($tmp) - 1]; 
		
		    if(preg_match("/admin/i", $pagina) == TRUE) {
		
    			die(  "\n<fieldset style=\"background-color:#f1f1f1;margin:5px;padding:5px;border:1px solid #A8A8A8;\">"
	       			. "\n <legend>Administrator Login</legend>"
	    			. "\n   <br />"
	    			. "\n   <form action=\"\" method=\"POST\">"
	    			. "\n   Username: <input type=\"text\" name=\"user\">"
	    			. "\n   <br />"
	    			. "\n   Password: <input type=\"password\" name=\"pass\" ><br /><br />"
	    			. "\n   <input type=\"submit\" value=\"Login\"><br /><br />"
           		    . "\n   <a href=\"?page=lost\">Password dimenticata</a>"
	    			. "\n   </form>"
	    			. "\n </fieldset>");
			}else{
			
	    		print "\n<br />"
	    			. "\n <div id=\"hmenu\"><center>Login</center></div>"
	    		    . "\n<fieldset style=\"background-color:#f1f1f1f;margin:5px;padding:5px;border:1px solid #A8A8A8;\">"
	       			. "<br />"
	    			. "\n   <br />"
	    			. "\n   <form action=\"\" method=\"POST\">"
	    			. "\n   Username: <input type=\"text\" name=\"user\" size=\"15\">"
	    			. "\n   <br />"
	    			. "\n   Password: <input type=\"password\" name=\"pass\" size=\"15\"><br /><br />"
	    			. "\n   <input type=\"submit\" value=\"Login\"><br /><br />"
	    	    	. "\n   <a href=\"?page=register\">Registrati</a><br />"
           		    . "\n   <a href=\"?page=lost\">Password dimenticata</a>"
	    			. "\n   </form>"
	    			. "\n </fieldset>";
			
			}
		}
    }
}
?>
