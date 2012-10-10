<?php
/*
 *
 * @class Template
 * @author Vincenzo Luongo
 *
 * @date 24/11/2011 && 09/01/2012 && 16/01/2012 && 18/04/2012 && 26/04/2012
 *
 * Note: Classe per la gestione del Template/Layout
 *
 */
 
class Template extends Login {

	public function __construct () {
	
    	include(CLASSES_DIR . "config.php");
        include_once(CLASSES_DIR . "mysql.class.php");
		include_once(CLASSES_DIR . "login.class.php");
		require(CLASSES_DIR."cache.class.php");
			
		$this->sql = new MySQL ($_CONFIG['DB_HOST'], $_CONFIG['DB_USER'], $_CONFIG['DB_PASS'], $_CONFIG['DB_NAME']);
	}

    public function _TPrint() {
    	$cache=new Cache();
		$cache->start();		
		
        $this->_header();
        $this->_title();
        $this->_content();
        $this->_leftbar(); 
        $this->_extra();
        $this->_footer();
    	
		$cache->fine();
 }
    public function _header() {
    
        print "<!DOCTYPE HTML>"
            . "\n<html xmlns=\"http://www.w3.org/1999/xhtml\">"
            . "\n<head>"
            . "\n<title>"._TITLE_SITE_."</title>"
            . "\n<meta http-equiv=\"content-type\" content=\"text/html; charset=UTF-8\" />"
            . "\n<meta name=\"KEYWORDS\" content=\""._KEYWORDS_."\" />"
            . "\n<meta name=\"DESCRIPTION\" content=\""._DESCRIPTION_."\" />"
            . "\n<meta name=\"ROBOTS\" content=\"INDEX, FOLLOW\" />"
            . "\n<meta name=\"REVISIT-AFTER\" content=\"1 DAYS\" />"
            . "\n<meta name=\"RATING\" content=\"GENERAL\" />"
            . "\n<meta name=\"RESOURCE-TYPE\" content=\"DOCUMENT\" />"
            . "\n<meta name=\"DISTRIBUTION\" content=\"GLOBAL\" />"
            . "\n<meta name=\"GENERATOR\" content=\""._GENERATOR_."\" />"
            . "\n<meta name=\"AUTHOR\" content=\""._AUTHOR_."\" />"
            . "\n<meta name=\"COPYRIGHT\" content=\""._COPYRIGHT_."\" />"
            . "\n"
            . "\n<!-- js Loader -->"
            . "\n<script type=\"text/javascript\" src=\"js/jquery-1.7.1.js\"></script>"
            . "\n<script type=\"text/javascript\" src=\"js/jquery-ui-1.8.16.js\"></script>"
            . "\n"
            . "\n<!-- CSS Loader -->"
            . "\n<link rel=\"stylesheet\" type=\"text/css\" href=\"css/styles.css\">"
            . "\n"
            . "\n<link rel=\"icon\" href=\"img/favicon.ico\" type=\"image/png\" />"
            . "\n</head>"
            . "\n<body  >"
            . "\n<div id=\"container\">";
    
    }
    
    public function _title() {
    
        print "\n<div id=\"header\">"
           // . "<img src=\"img/Home_Computer.png\" style=\"float:right;\">"
            . "\n\t<h1><a href=\"index.php\">"._TITLE_SITE_."</a></h1>"
            . "\n</div>";
    
    }
	
    public function _content() {
    
        print "\n<div id=\"wrapper\">"
            . "\n\t<div id=\"content\">";
            
        include("PageLoader.class.php");
        
        $PLoad = new PageLoader();
            
        $PLoad->Loader(@$_GET['page']);
                
	       print "\n\t</div>"
            . "\n</div>";
    
    }
    
    public function _leftbar() {
    
    	//codice per la creazione della leftbar
    	print "\n<div id=\"leftbar\">"
    		. "<div id=\"hmenu\">"        	
            . "\n<center><strong>Men&ugrave; Principale</strong></center>"
            . "</div>";
    	//codice per la generazione del menu
        print "\n<div id=\"navigation\">"
			. "<br /><br />"
           // . "\n\t<ul>"
            . "\n<a href=\"index.php\"><li><center>Home</center></li></a>"
            . "\n<a href=\"?page=blog\"><li><center>Blog</center></li></a>"
            . "\n<a href=\"?page=tutorial\"><li><center>Tutorial</center></li></a>"
            . "\n<a href=\"?page=contact\"><li><center>Contattaci</center></li></a>"
           // . "\n\t</ul>"
            . "\n</div>";
            
        @$user = empty($_COOKIE['admin_user']) ? $_COOKIE['normal_user'] : $_COOKIE['admin_user'];
		@$pass = empty($_COOKIE['admin_pass']) ? $_COOKIE['normal_pass'] : $_COOKIE['admin_pass'];
        
        if(@$_COOKIE['admin_user'] || @$_COOKIE['normal_user']){
            print "\n <div id=\"hmenu\"><center>Logged</center></div>"
            	. "\n<fieldset style=\"margin:5px;padding:5px;background-color:#f1f1f1; border:1px solid #A8A8A8;\">"
	    		. "\n   <br /><br /><center>&hearts; Benvenuto, ".htmlspecialchars($user)."!</center><br />";
	    		
			if(@$_COOKIE['admin_user']) {
				print "\n<br /><a href=\"./admin.php\">&rsaquo;&rsaquo; Pannello amministrazione</a>";
			}
			
				print "\n<br /><a href=\"./index.php?page=gestione_user&token=".$_SESSION['token']."\">&rsaquo;&rsaquo; Modifica profilo</a>"
	    		. "\n<br /><a href=\"./index.php?page=logout&token=".$_SESSION['token']."\">&rsaquo;&rsaquo; Logout</a>"
	    		. "\n </fieldset>";
		}
	    else
            $this->form_login(@$_REQUEST['user'], @$_REQUEST['pass']);
			
	    //chiusura della leftbar
    	print "\n</div>"
    		. "\n</div>";

}
 
    public function _extra() {
 
    	
        print "\n<div id=\"extra\">"
            . "\n   <div id=\"twitter\">"
            . "\n   <p><strong>7 last twitter</strong></p>"
            . "\n       <ul>"
            . "\n           <li><a href=\"#\">Other</a></li>"
            . "\n             <li><a href=\"#\">Other</a></li>"
            . "\n             <li><a href=\"#\">Other</a></li>"
            . "\n             <li><a href=\"#\">Other</a></li>"
            . "\n             <li><a href=\"#\">Other</a></li>"
            . "\n             <li><a href=\"#\">Other</a></li>"
            . "\n             <li><a href=\"#\">Other</a></li>"
            . "\n   </ul>"
            . "\n   </div>"
	        . "\n   "
            . "\n   <div id=\"last_topic_forum\">"
            . "\n   <p><strong>Ultimi 7 articoli del blog</strong></p>"
	        . "\n       <ul>";
	        
	        $this->post = $this->sql->sendQuery("SELECT * FROM ".__PREFIX__."blog ORDER BY id DESC");
			$i = 0;
			
            while(($this->article = mysql_fetch_array($this->post)) && $i < 7) {     
    	     	print "\n<li><a href=\"?page=view_article_blog&id=".$this->article['id']."\"><b>".$this->article['title']."</b></a></li>";	            
	            $i++;
			}
			
            print "\n   </ul>"
                . "\n   </div>"
	            . "\n   "
    	        . "\n   <div id=\"last_news\">"
            	. "\n   <p><strong>Ultimi 7 articoli del sito</strong></p>"
	            . "\n       <ul>";
	            
	        $this->post = $this->sql->sendQuery("SELECT * FROM ".__PREFIX__."tutorial ORDER BY id DESC");
	        $j = 0;
	        
            while(($this->article = mysql_fetch_array($this->post)) && $j < 7) {
    	     	print "\n<li text-align=\"left\"><a href=\"?page=view_article_tutorial&id=".$this->article['id']."\"><b>".$this->article['title']."</b></a></li>";
				$j++;
			}
			
            print "\n   </ul>"
            	. "\n   </div>"
            	. "\n </div>";
		  
    }
      
    public function _footer() {
    
        print "\n\t<div id=\"footer\">"
            . "\n\t\t<br /><a rel=\"license\" href=\"http://creativecommons.org/licenses/by-nc-sa/3.0/\"><img alt=\"Licenza Creative Commons\" style=\"border-width:0\" src=\"http://i.creativecommons.org/l/by-nc-sa/3.0/88x31.png\" /></a><br />"
            //. "\n\t\t<a href=\"./admin.php\">[-Administration-]</a><br />"
            . "\n\t&copy; ".date("Y")
            . "\n<br />"
            . "\n\t</div>"
            . "\n</body>"
            . "\n</html>";
    
    }
    
} //end class
?>
