<?php
/*
 *
 * @class BootLoader
 * @author Vincenzo Luongo
 *
 * @date 24/11/2011
 *
 * Note: Classe per il loader delle pagine
 *
 */
 
class PageLoader extends Login{
    
    public function _construct() {}
    
    function Loader($page) {
    
        //aggiungere controllo NullByte
        $this->page = $page;
    
        if(empty($this->page)) {
            include("pages/home/index.php");
        } else {    
            if(!file_exists("pages/".$this->page."/index.php"))
                print "<div class=\"error\">[ERRORE] Pagina non trovata!</div>";
            else
                include("pages/".$this->page."/index.php");
        }
    }
}
?>
