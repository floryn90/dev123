<?php
/*
 *
 * @class Boot Loader
 * @author Vincenzo Luongo
 *
 * @date 18/04/2012
 *
 * Note: Classe per la gestione del boot dei file class.
 *
 */

if(!require_once(CLASSES_DIR ."config.php")) 
    die("[ERROR] File config.php non incluso!");

if(!require_once(CLASSES_DIR ."security.class.php")) 
    die("[ERROR] File security.class.php non incluso!");
    
if(!require_once(CLASSES_DIR ."mysql.class.php")) 
    die("[ERROR] File mysql.class.php non incluso!");

if(!require_once(CLASSES_DIR ."BBCode.class.php")) 
    die("[ERROR] File BBCode.class.php non incluso!");

if(!require_once(CLASSES_DIR ."admin.class.php")) 
    die("[ERROR] File admin.class.php non incluso!");
    
if(!require_once(CLASSES_DIR ."login.class.php")) 
    die("[ERROR] File login.class.php non incluso!");
            
if(!require_once(CLASSES_DIR ."Template.class.php")) 
    die("[ERROR] File template.class.php non incluso!");
?>
