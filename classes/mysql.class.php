<?php
/*
 *
 * @page admin.class.php
 * @author Vincenzo Luongo
 *
 * @date 25/11/2011
 *
 * Note: Classe per la gestione del database MySQL
 *
 */

class MySQL extends Security {
	private $result = NULL;
	private $conn   = NULL;
	
	public function __construct ($db_host, $db_user, $db_pass, $db_name) {
	
		if (!$this -> conn = @mysql_connect ($db_host, $db_user, $db_pass)) {
			die ("<div class=\"error\">".mysql_error()."</div>");
		}
		
		if (!@mysql_select_db ($db_name, $this -> conn)) {
			die ("<div class=\"error\">".mysql_error()."</div>");
		}
	}
	
	public function sendQuery ($query) {
		if (!$this -> result = @mysql_query ($query, $this -> conn)) {
			die ("<div class=\"error\">SQL Error: ".mysql_error()."</div>");
		}else {
			return $this -> result;
		}
	}
	
	public function __destruct () {
		@mysql_close ($this -> _conn);
	}
}

