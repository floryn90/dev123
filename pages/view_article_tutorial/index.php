<?php

include(CLASSES_DIR ."config.php");

$this->sql = new MySQL ($_CONFIG['DB_HOST'], $_CONFIG['DB_USER'], $_CONFIG['DB_PASS'], $_CONFIG['DB_NAME']);

$this->id = (int) $_GET['id'];

$this->post = $this->sql->sendQuery("SELECT * FROM ".__PREFIX__."tutorial WHERE id = ".$this->id);
	
while($this->article = mysql_fetch_array($this->post)) {
    	print "\n\t<div id=\"article_top\">"    			
    	    	. "\n<b> <a href=\"?page=view_article_blog&id=".$this->article['id']."\">".$this->article['title']."</a></b>"
    			. "\n<br /><i>Scrito da:".$this->article['author']." il ".$this->article['post_date']."</i></sfondo>"
    			. "\n\t</div>"
    			."\n\t<div id=\"article\">"
    				. "\n<br /><br /><br /><br /><p>".BBCode($this->article['post'])."</p> <br />"
    		. "\n\t</div>";
    		
}
	
$this->comments = $this->sql->sendQuery("SELECT * FROM ".__PREFIX__."comments_tutorial WHERE tutorial_id = ".$this->id);

//cascata di commenti per il post
print "<div id=\"comments\">"
	. "\n<center>.::Commenti::.</center>";
	
//variabile per la stampa del id ordinato
$count = 1;

if(mysql_num_rows($this->comments) == 0) {
	print "<div id=\"commento\">"
    	. "\n\n<em>Non ci sono ancora Commenti</em><br />\n"
    	. "\n</div>";
}else{
    while($row = mysql_fetch_array($this->comments)) {
        print "<div id=\"commento\">"
        	. "\n<i>Comento nr. ".$count." sscrito il ".$row['data']."<br /><b>Scritto da:</b>".$row['name']."</i><br />"
            . "\n<p>".$row['comment']."</p>"
			. "</div>";
			$count++;
    }
}

if(($this->is_user($_COOKIE['normal_user'], $_COOKIE['normal_pass']) == TRUE) || ($this->is_admin($_COOKIE['admin_user'], $_COOKIE['admin_pass']) == TRUE)) {

    $user = (isset($_COOKIE['normal_user'])) ? $_COOKIE['normal_user'] : $_COOKIE['admin_user'];
	
    print "\n<div id=\"commento\">"
        . "\n<form name=\"addcomment\" action=\"?page=view_article_tutorial&id=".$this->id."&action=send_comment\" method=\"POST\">"
        . "\n<b><i>Lasciaci un tuo commento riguardante l'articolo che hai appena letto!</i></b><br /><br />"
        . "\n<b>Nome:</b><br /><input type=\"text\" name=\"name\" value=\"".htmlspecialchars($user)."\" disabled=\"disabled\"/><br /><br />"
        . "\n<input type=\"hidden\" name=\"nome\" value=\"".htmlspecialchars($user)."\" />"
        . "\n<b>Commento:</b><br /><textarea name=\"comment\" cols=\"30\" rows=\"5\"></textarea><br /><br />"
        . "\n<input type=\"submit\" value=\"Invia\" />"
        . "\n</form>"
        . "\n</div>"
        . "\n</div>";


    if(@$_GET['action'] == 'send_comment') {//aggiunta reale del commento

        if(empty($_POST['nome']) || empty($_POST['comment'])) //Controllo se i campi sono riempiti oppure no
            die( "<script>alert(\"Riempire tutti i campi!\");</script>");
    
        if (strlen($_POST['comment']) > 500)
            die( "<script>alert(\"Commento troppo lungo\");</script>");
    
        $commento = mysql_real_escape_string( htmlspecialchars( stripslashes( $_POST['comment'] )));
        $name     = mysql_real_escape_string( htmlspecialchars( stripslashes( $_POST['nome'] )));
        $ip       = $_SERVER['REMOTE_ADDR'];
    	$data	  = date(DATE_RFC822);
        //eseguo query di isnerimento
        $this->sql->sendQuery("INSERT INTO ".__PREFIX__."comments_tutorial (tutorial_id, name, comment, ip, data) VALUES ('".$this->id."', '{$name}', '{$commento}', '{$ip}', '{$data}')");
        
        header('Location: index.php?page=view_article_tutorial&id='.$this->id);
    }//end if send commit
    
}else{//end if controll user else info message

    print "\n<div class=\"error\">"
        . "\n<b><i>Devi effettuare l'accesso al portale per poter commentare!</i></b>"
        . "\n</div>";
}


?>
