<?php
/*
 *
 * @page admin.class.php
 * @author Vincenzo Luongo
 *
 * @date 25/11/2011
 *
 * Note: Classe per la gestione della sicurezza e dei magic token anti CSRF
 *
 */
 
class Security {

	public function VarProtect ($content) {
		if (is_array ($content)) {
			foreach ($content as $key => $val)
				$content[$key] = mysql_real_escape_string (htmlspecialchars (stripslashes ($content[$key])));
		}else{
			$content = mysql_real_escape_string (htmlspecialchars ($content));
		}
	
		return (get_magic_quotes_gpc () ? stripslashes ($content) : $content);
	}
	
	public function _DEBUG_MODE() {
	    
	    print "DEBUG MODE: <br><br>"
	        . "SESSION: ";
	        
	    print "<pre><font size=3>";
	    print_r($_SESSION);
		print "</font></pre>";
		
	    print "<br><br>"
	        . "COOKIE: <br>";
		
		print "<pre><font size=3>";
		print_r($_COOKIE);
		print "</font></pre>";
	
	}

	public function generate_token () {
	
		$this->token = md5(rand(1,999999));
		
		return $this->token;
	}
	
	public function security_token($security, $token) {
		
		$this->security = $security;
		$this->token    = $token;
	
		if($this->security != $this->token)
			die("<div class=\"error\">CSRF Attack Attemp!</div>");
	
	}
	
	public function my_is_numeric($text) {
		
		if(preg_match("/^[0-9]+$/",$text) == FALSE)
			die("<div class=\"error\">Hacking Attemp!</div>");
		
	}

	public function valid_mail($mail) {
		$this->mail = trim($mail);
		
		if(!$this->mail)
			return FALSE;
			
		$this->num_at = count(explode( '@', $this->mail )) - 1;
		
		if($this->num_at != 1)
			return FALSE;
		
		if(strpos($this->mail,';') || strpos($this->mail,',') || strpos($this->mail,' '))
			return FALSE;
		
		if(!preg_match( '/^[\w\.\-]+@\w+[\w\.\-]*?\.\w{1,4}$/', $this->mail))
			return FALSE;
		
		return TRUE;
	}
	
	public function random_pass() {
		$lettere = explode(" ",
			"A B C D E F G H I J K L M N O P Q R S T U V W X Y Z "
			. "a b c d e f g h i j k l m n o p q r s t u v w x y z "
			. "0 1 2 3 4 5 6 7 8 9"
		);

		for($i = 0; $i < 6; $i++) {
			srand((double) microtime() * 8622342);
			$foo = rand(0, 61);
			$pass = $pass. $lettere[$foo];
		}

		return $pass;
	}
}
?>

