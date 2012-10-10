<?php
class Cache {

	
	
	function start(){
		$cache_dir="cache/";
		$cache_time=1200;
		$cache_file='cache/'.md5($_GET['page']).'.html';
		if(file_exists($cache_file) && (time() - $cache_time < filemtime($cache_file))){
			include($cache_file);
			exit;
		}
		ob_start();
	}
	function fine(){
		$cache_dir="/cache/";
		//definisco il percorso e il nome del file cache
		$cache_file='cache/'.md5($_GET['page']).'.html';
		//apro il file cache per scriverci dentro il contenuto della pagina
		$file = fopen($cache_file, 'w');
		//scrivo il contenuto della pagina generata dallo script php in file cache
		fwrite($file, ob_get_contents());
		//chiudo il file cache
		fclose($file);
		//mando l'output al browser
		ob_end_flush();
	}
}
?>