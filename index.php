<?php
/*
 *
 * @page index.php
 * @author Vincenzo Luongo
 *
 * @date 24/11/2011 && 16/01/2012
 *
 * Note: Pagine index.php dove prende tutto vita :P
 *
 */
session_start();

define("CLASSES_DIR", "classes/");
 
if(!include(CLASSES_DIR ."loader.class.php")) 
    die("[ERROR] File loader.class.php non incluso!");

//Richiamo la classe template
$Template = new Template();

//stampo il template
$Template->_TPrint();
?>
