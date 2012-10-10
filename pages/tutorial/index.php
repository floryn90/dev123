<?php
include(CLASSES_DIR ."config.php");
include(CLASSES_DIR ."Pager.class.php");

$this->sql  = new MySQL ($_CONFIG['DB_HOST'], $_CONFIG['DB_USER'], $_CONFIG['DB_PASS'], $_CONFIG['DB_NAME']);

if (isset($_GET['pages']) && is_numeric($_GET['pages']) && ((int) $_GET['pages']) > 0 )
    $page = (int) $_GET['pages'];
else
    $page = 1;

$result = $this->sql->sendQuery("SELECT COUNT(*) FROM ".__PREFIX__."tutorial"); 
$total  = mysql_result($result, 0, 0);


$pager_l = new Pager();
$pager   = $pager_l->getPagerData($total, _LIMIT_, $page); 
$offset  = $pager->offset; 
$limit   = $pager->limit; 
$page    = $pager->page;

$this->post = $this->sql->sendQuery("SELECT * FROM ".__PREFIX__."tutorial ORDER BY id DESC LIMIT ".$offset.", ".$limit);

while($this->article = mysql_fetch_array($this->post)) { 		
   	print "\n\t<div id=\"article_top\">"
   	    	. "\n<b> <a href=\"?page=view_article_tutorial&id=".$this->article['id']."\">".$this->article['title']."</a></b>"
   			. "\n<br /><i>Scrito da:<b>".$this->article['author']."</b> il ".$this->article['post_date']."</i></sfondo>"
   			. "\n\t</div>"
   			. "\n\t<div id=\"article\">"
			. "\n<br /><br /><br /><br /><p>".BBCode($this->article['post'])."</p> <br />"
    		. "\n\t</div>";
}

if($pager->numPages > 0) {
    print "\n<p align=\"center\">";
        for ($i = 1; $i <= $pager->numPages; $i++) {
            if ($i < $pager->numPages)
                print " <a href=\"index.php?page=tutorial&pages=".$i."\">[".$i."]</a> -";
            else
                print " <a href=\"index.php?page=tutorial&pages=".$i."\">[".$i."]</a>";
        }
    print "\n</p>";
}
?>
