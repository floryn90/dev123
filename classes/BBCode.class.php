<?php
   
	/*
	 * BBCODES:
	 * [img]<image_path>[/img]
	 * [url=<url_path>]<url_name>[/url]
	 * [url]<url_path>[/url]
	 * [img]<link image>[/img]
	 * [youtube]<id_code_video>[/youtube]
	 * [b]<text>[/b]
	 * [i]<text>[/i]
	 * [u]<text>[/u]
	 * [center]<text>[/center]
	 */
	
	function BBCode($text) {
	
		//$text = nl2br($text);
		$text = str_replace("\n","<br />",$text);
		
		
		//escape
		$text = str_replace("&egrave;","è",$text);
		$text = str_replace("&agrave;","à",$text);
		$text = str_replace("&quot;","\"",$text);
		$text = str_replace("&ugrave;","ù",$text);
		$text = str_replace("&Igrave;","ì",$text);
		$text = str_replace("&nbsp;"," ",$text);
		$text = str_replace("&euro;","€",$text);				
	
		/* Smile */
		$text = str_replace(":)", "<img alt=\":)\" src=\"img/01.jpg\">", $text);
		$text = str_replace(":D", "<img alt=\":D\" src=\"img/02.jpg\">", $text);
		$text = str_replace(";)", "<img alt=\";)\" src=\"img/03.jpg\" >", $text);
		$text = str_replace("^_^", "<img alt=\"^_^\" src=\"img/04.gif\">", $text);
		$text = str_replace(":(", "<img alt=\":(\" src=\"img/06.gif\">", $text);
		$text = str_replace("<<bira>>", "<img alt=\"bira\" src=\"img/bira.gif\">", $text);
		$text = str_replace("<<king>>", "<img alt=\"king\" src=\"img/king.gif\">", $text);
		$text = str_replace("<<figo>>", "<img alt=\"figo\" src=\"img/figo.gif\">", $text);
		
		/* BBcode */
		$text = str_replace("[img]", "<img src=\"", $text);
		$text = str_replace("[/img]", "\"><!-- immagine -->", $text);
		$text = str_replace("[b]", "<b>", $text);
		$text = str_replace("[/b]", "</b>", $text);
		$text = str_replace("[i]", "<i>", $text);
		$text = str_replace("[/i]", "</i>", $text);
		$text = str_replace("[u]", "<u>", $text);
		$text = str_replace("[/u]", "</u>", $text);
		$text = str_replace("[center]", "<center>", $text);
		$text = str_replace("[/center]", "</center>", $text);
		
		//Link BBcode
 		$search  = array(
 					"/\\[url\\](.*?)\\[\\/url\\]/is", 
 					"/\\[url\\=(.*?)\\](.*?)\\[\\/url\\]/is", 
 					"/\\[youtube\\](.*?)\\[\\/youtube\\]/is"
 				);
 				
    	$replace = array(
    				"<a target=\"_blank\" href=\"$1\">$1</a>", 
    				"<a target=\"_blank\" href=\"$1\">$2</a>", 
    				"<br /><iframe title=\"YouTube video player\" width=\"480\" height=\"390\" src=\"http://www.youtube.com/embed/$1\" frameborder=\"0\" allowfullscreen></iframe>"
				);
				
    	//if(preg_match("#(?:http://)?(?:www.)?youtube.(?:com|it)/(?:watch?v=|v/)(.{11})#i", $text, $parte)) {
    	//	$id_code_yt = $parte[1];
    	//}
    	
 		$text = preg_replace ($search, $replace, $text);

		return $text;
	}
?>
