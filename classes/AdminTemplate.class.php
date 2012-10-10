<?php
/*
 *
 * @class Template
 * @author Vincenzo Luongo
 *
 * @date 25/11/2011 && 09/01/2012 && 26/04/2012
 *
 * Note: Classe per la gestione del Template/Layout dell'amministrazione
 *
 */
 
class AdminTemplate extends Security {

	public function __construct () {
	
    	include(CLASSES_DIR . "config.php");
        include_once(CLASSES_DIR . "mysql.class.php");
			
		$this->sql = new MySQL ($_CONFIG['DB_HOST'], $_CONFIG['DB_USER'], $_CONFIG['DB_PASS'], $_CONFIG['DB_NAME']);
	}	

    public function _TPrint_open() {
    
        $this->_header();
        $this->_title();
        $this->_content_open();
    }
    
    public function _TPrint_close() {
    
        $this->_content_close();
        $this->_menu();
        $this->_footer();
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
            . "\n<body style = \"display: none\" onLoad = \"$('body').fadeIn(2500);\">"
            . "\n<div id=\"container\">";
    
    }
    
    public function _title() {
    
        print "\n<div id=\"header\">"
            . "\n\t<h1><a href=\"index.php\">"._TITLE_SITE_."</a></h1>"
            . "\n</div>";
    
    }
    
    public function _content_open() {
    
        print "\n<div id=\"wrapper\">"
            . "\n\t<div id=\"content\">";
    }
    
    public function _content_close() {
    
        print "\n\t</div>"
            . "\n</div>";
    }
    
    public function _menu() {
    
        print "\n<div id=\"navigation\">"
            . "\n\t<p><strong>Administration Menu</strong></p>"
           // . "\n\t<ul>"
            . "\n\t\t<a href=\"index.php\"><li><center>Home Site</center></li></a>"
            . "\n\t\t<a href=\"admin.php\"><li><center>Home Admin</center></li></a>"
            . "\n\t\t<a href=\"?action=logout&token=".$_SESSION['token']."\"><li><center>Logout</center></li></a>"
           // . "\n\t</ul>"
            . "\n<fieldset style=\"background:#E4E4E4;\"><legend><b>Gestione Tutorial</b></legend>"
            . "\n<fieldset style=\"background:#999999;\"><legend>Articoli</legend>"
           // . "\n\t<ul>"
            . "\n\t\t<a href=\"?action=add_post_tutorial\"><li><center>Aggiungi Tutorial</center></li></a>"
            . "\n\t\t<a href=\"?action=manage_tutorial\"><li><center>Gestisci Tutorial</center></li></a>"
            . "\n</fieldset>"
           // . "\n\t</ul>"
            . "\n<fieldset style=\"background:#999999;\"><legend>Categorie Tutorial</legend>"
           // . "\n\t<ul>"
            . "\n\t\t<a href=\"?action=add_category_tutorial\"><li><center>Aggiungi Categoria</center></li></a>"
            . "\n\t\t<a href=\"?action=edit_category_tutorial\"><li><center>Gestisci Categorie</center></li></a>"
            . "\n\t\t<a href=\"?action=del_category_tutorial\"><li><center>Elimina Categorie</center></li></a>"
            . "\n</fieldset>"
           // . "\n\t</ul>"
            . "\n</fieldset>"
            . "\n<fieldset style=\"background:#E4E4E4;\"><legend><b>Gestione Blog</b></legend>"
            . "\n<fieldset style=\"background:#999999;\"><legend>Articoli</legend>"
           //. "\n\t<ul>"
            . "\n\t\t<a href=\"?action=add_post\"><li><center>Aggiungi Articolo</center></li></a>"
            . "\n\t\t<a href=\"?action=manage_blog\"><li><center>Gestisci Articoli</center></li></a>"
            . "</fieldset>"
           // . "\n\t</ul>"
            . "\n<fieldset style=\"background:#999999;\"><legend>Gestisci Categorie </legend>"
           // . "\n\t<ul>"
            . "\n\t\t<a href=\"?action=add_category\"><li><center>Aggiungi Categoria</center></li></a>"
            . "\n\t\t<a href=\"?action=edit_category\"><li><center>Gestisci Categorie</center></li></a>"
            . "\n\t\t<a href=\"?action=del_category\"><li><center>Elimina Categorie</center></li></a>"
            . "\n</fieldset>"
           // . "\n\t</ul>"
            . "\n</fieldset>"
            . "\n<fieldset><legend>Amministrazione DB</legend>"
           // . "\n<ul>"
            . "\n\t<a target=\"_blank\" href=\"./adminer/\"><li><center>Gestisci DB</center></li></a>"
           // . "\n\t</ul>"
			. "\n\t</fieldset>"
            . "\n<fieldset><legend>Gestione Administrator</legend>"
           // . "\n\t<ul>"
            . "\n\t\t<a href=\"?action=add_admin\"><li><center>Aggiungi Admin</center></li></a>"
            . "\n\t\t<a href=\"?action=change_pass_admin\"><li><center>Cambia Password Admin</center></li></a>"
            . "\n\t\t<a href=\"?action=del_admin\"><li><center>Elimina Admin</center></li></a>"
           // . "\n\t</ul>"
            . "\n</fieldset>"
            . "\n<fieldset><legend>Gestione Utenti</legend>"
           // . "\n\t<ul>"
            . "\n\t\t<a href=\"?action=add_utente\"><li><center>Aggiungi Utente</center></li></a>"
            . "\n\t\t<a href=\"?action=change_pass_utente\"><li><center>Cambia Password Utente</center></li></a>"
            . "\n\t\t<a href=\"?action=del_utente\"><li><center>Elimina Utente</center></li></a>"
           // . "\n\t</ul>"
            . "\n</fieldset>"
            . "\n</div>";
    
    }
    
    public function _extra() {
 
    	
        print "\n<div id=\"extra\">"
          	. "\n </div>";
		  
    }      
    public function _footer() {
    
        print "\n\t<div id=\"footer\">"
            . "\n\t\t<br /><a rel=\"license\" href=\"http://creativecommons.org/licenses/by-nc-sa/3.0/\"><img alt=\"Licenza Creative Commons\" style=\"border-width:0\" src=\"http://i.creativecommons.org/l/by-nc-sa/3.0/88x31.png\" /></a><br />"
           // . "\n\t\t<a href=\"admin\">[-Administration-]</a><br />"
            . "\n\t&copy; 2012"
            . "\n\t</div>"
            . "\n</div>"
            . "\n</body>"
            . "\n</html>";
    
    }
    
} //end class
?>
