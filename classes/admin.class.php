<?php
/*
 *
 * @page admin.class.php
 * @author Vincenzo Luongo
 *
 * @date 25/11/2011 && 09/01/2012 && 16/01/2012 && 18/04/2012 && 26/04/2012
 *
 * Note: Classe per la gestione dei contenuti amministrativi
 *
 */

class Admin extends Security  {

	public function __construct () {
	
    	include(CLASSES_DIR . "config.php");
        include_once(CLASSES_DIR . "mysql.class.php");
			
		$this->sql = new MySQL ($_CONFIG['DB_HOST'], $_CONFIG['DB_USER'], $_CONFIG['DB_PASS'], $_CONFIG['DB_NAME']);
	}	
	
	public function show_administration() {
		
		print "<h2 align=\"center\">Administration - Home</h2>\n";	

        $this->_DEBUG_MODE();		

	}
	
	public function manage_tutorial() {
	
		print "\n<table style=\"border-collapse: collapse;\" border=\"2\" align=\"center\" cellpadding=\"10\" cellspacing=\"1\">"
			. "<center><strong>Gestisci commenti dei Tutorial</strong></center><br /><br />"
			. "\n<tbody>"
			. "\n	<tr align=\"center\">"
			. "\n	  <td><b>Titolo</b></td>"
			. "\n	  <td><b>Autore</b></td>"
			. "\n	  <td><b>Gestisci Commenti</b></td>"
			. "\n	  <td><b>Data PUB.</b></td>"
			. "\n	  <td><b>[Gestisci]</b></td>"
			. "\n	</tr>";
		
		$this->post = $this->sql->sendQuery("SELECT id, author, title, post, post_date FROM ".__PREFIX__."tutorial ORDER by id DESC");
		
		while($this->article = mysql_fetch_array($this->post)) {
		
			$this->comment  = $this->sql->sendQuery("SELECT tutorial_id FROM ".__PREFIX__."comments_tutorial WHERE tutorial_id = '".$this->article['id']."'");
			$this->comments = mysql_fetch_row($this->comment);
			
			$this->manage = ($this->comments < 1) ? "" : " <p align=\"center\"><a href=\"admin.php?action=manage_comments_tutorial&id=".$this->comments[0]."\">[MOD]</a></p>";
			
			print "\n\t<tr>"
				. "\n	  <td>".$this->article['title']."</td>"
				. "\n	  <td>".$this->article['author']."</td>";
				
				if(mysql_num_rows($this->comment) == 0)
					print "\n<td>Non ci sono commenti!</td>";
				elseif(mysql_num_rows($this->comment) == 1)
    				print "\n	  <td>C'è ".mysql_num_rows($this->comment)." commento!".$this->manage."</td>";
				else
	    			print "\n	  <td>Ci sono ".mysql_num_rows($this->comment)." commenti!".$this->manage."</td>";
				
				print "\n	  <td>".$this->article['post_date']."</td>"
				. "\n	  <td><a href=\"admin.php?action=del_post_tutorial&id=".$this->article['id']."&security=".$_SESSION['token']."\">[X]</a> ~ <a href=\"admin.php?action=edit_post_tutorial&id=".$this->article['id']."\">[MOD]</a></td>"
				. "\n	</tr>";
		}
		print " </tbody>\n"
			. "</table>\n";
    }
    
	public function manage_blog() {
	
		print "\n<table style=\"border-collapse: collapse;\" border=\"2\" align=\"center\" cellpadding=\"10\" cellspacing=\"1\">"
			. "<center><strong>Gestisci commenti del Blog</strong></center><br /><br />"
			. "\n<tbody>"
			. "\n	<tr align=\"center\">"
			. "\n	  <td><b>Titolo</b></td>"
			. "\n	  <td><b>Autore</b></td>"
			. "\n	  <td><b>Gestisci Commenti</b></td>"
			. "\n	  <td><b>Data PUB.</b></td>"
			. "\n	  <td><b>[Gestisci]</b></td>"
			. "\n	</tr>";
		
		$this->post = $this->sql->sendQuery("SELECT id, author, title, post, post_date FROM ".__PREFIX__."blog ORDER by id DESC");
		
		while($this->article = mysql_fetch_array($this->post)) {
		
			$this->comment  = $this->sql->sendQuery("SELECT blog_id FROM ".__PREFIX__."comments_blog WHERE blog_id = '".$this->article['id']."'");
			$this->comments = mysql_fetch_row($this->comment);
			
			$this->manage = ($this->comments < 1) ? "" : " <p align=\"center\"><a href=\"admin.php?action=manage_comments&id=".$this->comments[0]."\">[MOD]</a></p>";
			
			print "\n\t<tr>"
				. "\n	  <td>".$this->article['title']."</td>"
				. "\n	  <td>".$this->article['author']."</td>";
				
				if(mysql_num_rows($this->comment) == 0)
					print "\n<td>Non ci sono commenti!</td>";
				elseif(mysql_num_rows($this->comment) == 1)
    				print "\n	  <td>C'è ".mysql_num_rows($this->comment)." commento!".$this->manage."</td>";
				else
	    			print "\n	  <td>Ci sono ".mysql_num_rows($this->comment)." commenti!".$this->manage."</td>";
				
				print "\n	  <td>".$this->article['post_date']."</td>"
				. "\n	  <td><a href=\"admin.php?action=del_post&id=".$this->article['id']."&security=".$_SESSION['token']."\">[X]</a> ~ <a href=\"admin.php?action=edit_post&id=".$this->article['id']."\">[MOD]</a></td>"
				. "\n	</tr>";
		}
		print " </tbody>\n"
			. "</table>\n";
    }
    
    			
	public function add_post_tutorial() {
	
		print "<h2 align=\"center\">Aggiungere Tutorial</h2><br />\n";
	
		if (!empty($_POST['author']) && !empty($_POST['title']) && !empty($_POST['article'])) {
			
			$this->security_token($_POST['security'], $_SESSION['token']);
			
		    $this->date    = @date('d/m/y');
		    $this->article = $this->VarProtect( $_POST['article']  );
		    $this->title   = $this->VarProtect( $_POST['title']    );
		    $this->author  = $this->VarProtect( $_POST['author']   );
   		    $this->cat_id  = $this->VarProtect( $_POST['category'] );
		
		    $this->sql->sendQuery("INSERT INTO ".__PREFIX__."tutorial (post, title, author, post_date, num_read, cat_id
		        						) VALUES (
		        					'".$this->article."', '".$this->title."', '".$this->author."',  '".$this->date."', 0, '".$this->cat_id."')");
		
		    print "<script>alert(\"Articolo Aggiunto con Successo!\");</script>";
		    header('Location: ./admin.php');
		}else{
			$this->cat = $this->sql->sendQuery("SELECT * FROM ".__PREFIX__."categories_tutorial");
			
		    //Visualizzo la form
			print '<form action="./admin.php?action=add_post_tutorial" method="POST">
			    Autore:<br />
    	      	    <input type="text" name="author" value="'.htmlspecialchars($_COOKIE['admin_user']).'"/><br /><br />
    	      	    Titolo:<br />
    	      	    <input type="text" name="title" /><br /><br />
    	      	    Categoria:<br />
    	      	    <select name="category">';
    	      	    
    	      	    while($this->category = mysql_fetch_array($this->cat))
    	      	    	print "\n<option value=\"".$this->category['cat_id']."\">".$this->category['cat_name']."</option>";
    	      	    
    	    print ' </select>
    	    		<br /><br />
    	    		Smile: :) , :( , :D , ;) , ^_^ .<br /><br />
    	      	    BBcode:<br />
    		        * [img] image_path [/img]<br />
					* [url= url_path ] url_name [/url]<br />
					* [url] url_path [/url]<br />
					* [img] url_img [/img]<br />
					* [youtube] id_code_video [/youtube] ( http://www.youtube.com/watch?v=<b>8UFIYGkROII</b> ) <br />
					* [b] text [/b]<br />
					* [i] text [/i]<br />
					* [u] text [/u]<br />
					* [center] text [/center]<br />
				<br />
    	      	    Corpo dell\'articolo:<br />
    	      	    <textarea name="article" cols="50" rows="10"></textarea><br /><br />
    	      	    <input type="submit" value="Invia" />
    	      	    <input type="hidden" name="security" value="'.$_SESSION['token'].'" />
    	      	    <br /><br /></form>';
		}
	}
	
	public function add_post() {
	
		print "<h2 align=\"center\">Aggiungere Articolo al Blog</h2><br />\n";
	
		if (!empty($_POST['author']) && !empty($_POST['title']) && !empty($_POST['article'])) {
			
			$this->security_token($_POST['security'], $_SESSION['token']);
			
		    $this->date    = @date('d/m/y');
		    $this->article = $this->VarProtect( $_POST['article']  );
		    $this->title   = $this->VarProtect( $_POST['title']    );
		    $this->author  = $this->VarProtect( $_POST['author']   );
   		    $this->cat_id  = $this->VarProtect( $_POST['category'] );
		
		    $this->sql->sendQuery("INSERT INTO ".__PREFIX__."blog (post, title, author, post_date, num_read, cat_id
		        						) VALUES (
		        					'".$this->article."', '".$this->title."', '".$this->author."',  '".$this->date."', 0, '".$this->cat_id."')");
		
		    print "<script>alert(\"Articolo Aggiunto con Successo!\");</script>";
		    header('Location: ./admin.php');
		}else{
			$this->cat = $this->sql->sendQuery("SELECT * FROM ".__PREFIX__."categories_blog");
			
		    //Visualizzo la form
			print '<form action="./admin.php?action=add_post" method="POST">
			    Autore:<br />
    	      	    <input type="text" name="author" value="'.htmlspecialchars($_COOKIE['admin_user']).'"/><br /><br />
    	      	    Titolo:<br />
    	      	    <input type="text" name="title" /><br /><br />
    	      	    Categoria:<br />
    	      	    <select name="category">';
    	      	    
    	      	    while($this->category = mysql_fetch_array($this->cat))
    	      	    	print "\n<option value=\"".$this->category['cat_id']."\">".$this->category['cat_name']."</option>";
    	      	    
    	    print ' </select>
    	    		<br /><br />
    	    		Smile: :) , :( , :D , ;) , ^_^ .<br /><br />
    	      	    BBcode:<br />
    		        * [img] image_path [/img]<br />
					* [url= url_path ] url_name [/url]<br />
					* [url] url_path [/url]<br />
					* [img] url_img [/img]<br />
					* [youtube] id_code_video [/youtube] ( http://www.youtube.com/watch?v=<b>8UFIYGkROII</b> ) <br />
					* [b] text [/b]<br />
					* [i] text [/i]<br />
					* [u] text [/u]<br />
					* [center] text [/center]<br />
				<br />
    	      	    Corpo dell\'articolo:<br />
    	      	    <textarea name="article" cols="50" rows="10"></textarea><br /><br />
    	      	    <input type="submit" value="Invia" />
    	      	    <input type="hidden" name="security" value="'.$_SESSION['token'].'" />
    	      	    <br /><br /></form>';
		}
	}
	
	
	public function manage_comments_tutorial($id) {
		
		$this->id = (int) $id;
		
		$this->my_is_numeric($this->id);
				
		if(empty($this->id))
			die("<div id=\"error\"><h2 align=\"center\">ID Inesistente!</p></div>");
		
		print "<h2 align=\"center\">Gestione Commenti dei Tutorial</h2><br />\n";
		
		$this->comments = $this->sql->sendQuery("SELECT id, tutorial_id, name, comment, ip FROM ".__PREFIX__."comments_tutorial WHERE tutorial_id = '".$this->id."'");
		
		if(mysql_num_rows($this->comments) < 1) {
			print "<p><b>Nessun Commento</b></p>";
		}else{
			print '<table style="border-collapse: collapse;" border="2" align="center" cellpadding="10" cellspacing="1">
			<tbody>
				<tr>
				  <td><center>Nome</center></td>
				  <td><center>Commento</center></td>
				  <td><center>IP</center></td>
				  <td><center>[#]</center></td>
				</tr>';	
				
			while($this->comment = mysql_fetch_array($this->comments)) {
				print "\n<form action='./admin.php?action=del_comment_tutorial' method='POST'>";	
				print "\n<tr>"
					  . "\n<td>".htmlspecialchars($this->comment['name'])."</td>"
					  . "\n<td>".htmlspecialchars($this->comment['comment'])."</td>"
					  . "\n<td>".$this->comment['ip']."</td>"
					  . "\n<td><input type='submit' value='Cancella'/></td>"
					. "\n</tr>";
				print "\n<input type='hidden' name='id' value='".(int) $this->comment['id']."'>";
				print "\n<input type=\"hidden\" name=\"security\" value=\"".$_SESSION['token']."\" />";
				print "\n</form>";
			}
			echo "\n</tbody>\n</table>\n";
		}
	}
	
	public function manage_comments($id) {
		
		$this->id = (int) $id;
		
		$this->my_is_numeric($this->id);
				
		if(empty($this->id))
			die("<div id=\"error\"><h2 align=\"center\">ID Inesistente!</p></div>");
		
		print "<h2 align=\"center\">Gestione Commenti del blog</h2><br />\n";
		
		$this->comments = $this->sql->sendQuery("SELECT id, blog_id, name, comment, ip FROM ".__PREFIX__."comments_blog WHERE blog_id = '".$this->id."'");
		
		if(mysql_num_rows($this->comments) < 1) {
			print "<p><b>Nessun Commento</b></p>";
		}else{
			print '<table style="border-collapse: collapse;" border="2" align="center" cellpadding="10" cellspacing="1">
			<tbody>
				<tr>
				  <td><center>Nome</center></td>
				  <td><center>Commento</center></td>
				  <td><center>IP</center></td>
				  <td><center>[#]</center></td>
				</tr>';	
				
			while($this->comment = mysql_fetch_array($this->comments)) {
				print "\n<form action='./admin.php?action=del_comment' method='POST'>";	
				print "\n<tr>"
					  . "\n<td>".htmlspecialchars($this->comment['name'])."</td>"
					  . "\n<td>".htmlspecialchars($this->comment['comment'])."</td>"
					  . "\n<td>".$this->comment['ip']."</td>"
					  . "\n<td><input type='submit' value='Cancella'/></td>"
					. "\n</tr>";
				print "\n<input type='hidden' name='id' value='".(int) $this->comment['id']."'>";
				print "\n<input type=\"hidden\" name=\"security\" value=\"".$_SESSION['token']."\" />";
				print "\n</form>";
			}
			echo "\n</tbody>\n</table>\n";
		}
	}

	public function del_comment_tutorial($id) {
			
		$this->id = (int) $id;
		
		if(empty($this->id))
			die("<div id=\"error\"><h2 align=\"center\">ID Inesistente</p></div>");
			
		$this->security_token($_POST['security'], $_SESSION['token']);
		
		$this->sql->sendQuery("DELETE FROM ".__PREFIX__."comments_tutorial WHERE id = '".$this->id."'");
		
		print '<script>window.location="./admin.php?action=manage_comment_tutorial";</script>';
	}
	
	public function del_comment($id) {
			
		$this->id = (int) $id;
		
		if(empty($this->id))
			die("<div id=\"error\"><h2 align=\"center\">ID Inesistente</p></div>");
			
		$this->security_token($_POST['security'], $_SESSION['token']);
		
		$this->sql->sendQuery("DELETE FROM ".__PREFIX__."comments_blog WHERE id = '".$this->id."'");
		
		print '<script>window.location="./admin.php?action=manage_comment";</script>';
	}
	
	public function del_post_tutorial($id) {
	
		$this->id = (int) $id;
		
		print "<h2 align=\"center\">Cancellare Articoli del Sito</h2><br />\n";
		
		if(empty($this->id)) {
			print "\n<br /><br /><form method=\"POST\" action=\"./admin.php?action=del_post_tutorial\" />"
			    . "\nInserire ID Articolo: <input type=\"text\" name=\"id\" />\n"
				. "<br /><input type=\"submit\" value=\"Cancella Articolo\" />\n"
				. "\n<input type=\"hidden\" name=\"security\" value=\"".$_SESSION['token']."\" />"
				. "</form>";
		}else{
			$this->security_token($_REQUEST['security'], $_SESSION['token']);
			
			$this->sql->sendQuery("DELETE FROM ".__PREFIX__."tutorial WHERE id = '".$this->id."'");
			$this->sql->sendQuery("DELETE FROM ".__PREFIX__."comments_tutorial WHERE tutorial_id = '".$this->id."'");

			die(header('Location: ./admin.php'));
		}
	}
	
	public function del_post($id) {
	
		$this->id = (int) $id;
		
		print "<h2 align=\"center\">Cancellare Articoli del Blog</h2><br />\n";
		
		if(empty($this->id)) {
			print "\n<br /><br /><form method=\"POST\" action=\"./admin.php?action=del_post\" />"
			    . "\nInserire ID Articolo: <input type=\"text\" name=\"id\" />\n"
				. "<br /><input type=\"submit\" value=\"Cancella Articolo\" />\n"
				. "\n<input type=\"hidden\" name=\"security\" value=\"".$_SESSION['token']."\" />"
				. "</form>";
		}else{
			$this->security_token($_REQUEST['security'], $_SESSION['token']);
			
			$this->sql->sendQuery("DELETE FROM ".__PREFIX__."blog WHERE id = '".$this->id."'");
			$this->sql->sendQuery("DELETE FROM ".__PREFIX__."comments_blog WHERE blog_id = '".$this->id."'");

			die(header('Location: ./admin.php'));
		}
	}
	
	public function check_user_exist($user) {
		
		$this->user = $this->VarProtect( $user );
		
		$this->check = $this->sql->sendQuery("SELECT * FROM ".__PREFIX__."administrators WHERE username = '".$this->user."' limit 1;");
		
		if(mysql_num_rows($this->check) == 1)
			return TRUE;
		else
			return FALSE;
	}
	
	public function check_email_exist($email) {
		
		$this->email = $this->VarProtect( $email );
		
		$this->check = $this->sql->sendQuery("SELECT * FROM ".__PREFIX__."administrators WHERE email = '".$this->email."' limit 1;");
		
		if(mysql_num_rows($this->check) == 1)
			return TRUE;
		else
			return FALSE;
	}
	
	public function add_admin() {
	
		print "<h2 align=\"center\">Aggiungere Admministratori</h2><br />\n";
	
		if(!empty($_POST['nick']) && !empty($_POST['pass']) && !empty($_POST['pass_check']) && !empty($_POST['email'])) {
		
			$this->security_token($_POST['security'], $_SESSION['token']);
			
			$this->nick       = $this->VarProtect( $_POST['nick']       );
			$this->pass       = $this->VarProtect( $_POST['pass']       );
			$this->pass_check = $this->VarProtect( $_POST['pass_check'] );						
			$this->email      = $this->VarProtect( $_POST['email']      );

			if($this->check_user_exist($this->nick) == TRUE)
				die("<script>alert(\"Questo Username &egrave; gi&agrave; stato utilizzato.\");location.href = './admin.php?action=add_admin';</script>");

			if($this->pass != $this->pass_check)
				die("<script>alert(\"Le password non combaciano.\");location.href = './admin.php?action=add_admin';</script>");

			if($this->check_email_exist($this->email) == TRUE) 
				die("<script>alert(\"Questa email &egrave; gi&agrave; stata utilizzata per qualche altro account.\");location.href = './admin.php?action=add_admin';</script>");

			if($this->valid_mail($this->email) == FALSE)
				die("<script>alert(\"Questa email non &egrave; valida.\");location.href = './admin.php?action=add_admin';</script>");
			
			$this->sql->sendQuery("INSERT INTO ".__PREFIX__."administrators (username, password, email) VALUES ('".$this->nick."', '".md5($this->pass)."', '".$this->email."')");
			
			print "<script>alert('Account ".$this->nick." Account creato con Successo!'); location.href = './admin.php';</script>";
			
			exit;
			
		}else{
				print "\n<br /><br />"
				. "\n<form method=\"POST\" action=\"./admin.php?action=add_admin\" />"
				. "\n<table style=\"text-align: left;\" border=\"0\" cellpadding=\"2\" width=\"100%\" cellspacing=\"2\">"
				. "\n<tbody>"
				. "\n<tr>"
				. "\n	<td>Username</td>"
				. "\n	<td><input type=\"text\" name=\"nick\" /></td>"
				. "\n</tr>"
				. "\n<tr>"
				. "\n	<td>Password</td>"
				. "\n	<td><input type=\"password\" name=\"pass\" /></td>"
				. "\n</tr>"
				. "\n<tr>"
				. "\n	<td>Password (Ripetila)</td>"
				. "\n	<td><input type=\"password\" name=\"pass_check\" /></td>"
				. "\n</tr>"				
				. "\n<tr>"
				. "\n	<td>Email:</td>"
				. "\n	<td><input type=\"text\" name=\"email\" /></td>"
				. "\n</tr>"			
				. "\n</tbody>"
				. "\n</table>"
				. "\n<input type=\"submit\" value=\"Invia\" />"
				. "\n<input type=\"hidden\" name=\"security\" value=\"".$_SESSION['token']."\" />"
				. "\n</form>"
				."";
		}
		}
public function add_utente() {
	
		print "<h2 align=\"center\">Registrazione nuovo utente</h2><br />\n";
	
		if(!empty($_POST['nome'])&& !empty($_POST['cognome'])&& !empty($_POST['nick']) && !empty($_POST['pass']) && !empty($_POST['pass_check']) && !empty($_POST['email'])) {
		
			$this->security_token($_POST['security'], $_SESSION['token']);
			
			$this->cognome	  = $this->VarProtect( $_PSOT['cognome']	);
			$this->nome		  = $this->VarProtect( $_PSOT['nome']		);
			$this->nick       = $this->VarProtect( $_POST['nick']       );
			$this->pass       = $this->VarProtect( $_POST['pass']       );
			$this->pass_check = $this->VarProtect( $_POST['pass_check'] );						
			$this->email      = $this->VarProtect( $_POST['email']      );

			if($this->check_user_exist($this->nick) == TRUE)
				die("<script>alert(\"Questo Username &egrave; gi&agrave; stato utilizzato.\");location.href = './admin.php?action=add_user';</script>");

			if($this->pass != $this->pass_check)
				die("<script>alert(\"Le password non combaciano.\");location.href = './admin.php?action=add_user';</script>");

			if($this->check_email_exist($this->email) == TRUE) 
				die("<script>alert(\"Questa email &egrave; gi&agrave; stata utilizzata per qualche altro account.\");location.href = './admin.php?action=add_user';</script>");

			if($this->valid_mail($this->email) == FALSE)
				die("<script>alert(\"Questa email non &egrave; valida.\");location.href = './admin.php?action=add_user';</script>");
			
			$this->sql->sendQuery("INSERT INTO ".__PREFIX__."users (username, password, email) VALUES ('".$this->nick."', '".md5($this->pass)."', '".$this->email."')");
			
			print "<script>alert('L\'account ".$this->nick." &egrave; stato creato con Successo!'); location.href = './index.php';</script>";
			
			exit;
			
		}else{
				print "\n<br /><br />"
				. "\n<form method=\"POST\" action=\"./admin.php?action=add_user\" />"
				. "\n<table style=\"text-align: left;\" border=\"0\" cellpadding=\"2\" width=\"100%\" cellspacing=\"2\">"
				. "\n<tbody>"
				. "\n<tr>"
				. "\n	<td>Nome</td>"
				. "\n	<td><input type=\"text\" name=\"nome\" /></td>"
				. "\n</tr>"
				. "\n<tr>"
				. "\n	<td>Cognome</td>"
				. "\n	<td><input type=\"text\" name=\"cognome\" /></td>"
				. "\n</tr>"
				. "\n<tr>"
				. "\n	<td>Username</td>"
				. "\n	<td><input type=\"text\" name=\"nick\" /></td>"
				. "\n</tr>"
				. "\n<tr>"
				. "\n	<td>Password</td>"
				. "\n	<td><input type=\"password\" name=\"pass\" /></td>"
				. "\n</tr>"
				. "\n<tr>"
				. "\n	<td>Password (Ripetila)</td>"
				. "\n	<td><input type=\"password\" name=\"pass_check\" /></td>"
				. "\n</tr>"				
				. "\n<tr>"
				. "\n	<td>Email:</td>"
				. "\n	<td><input type=\"text\" name=\"email\" /></td>"
				. "\n</tr>"			
				. "\n</tbody>"
				. "\n</table>"
				. "\n<input type=\"submit\" value=\"Invia\" />"
				. "\n<input type=\"hidden\" name=\"security\" value=\"".$_SESSION['token']."\" />"
				. "\n</form>"
				."";
		}
	}
	
	public function del_utente($id) {
		
		$this->id = intval($id);
		
		print "<h2 align=\"center\">Eliminare Utente</h2><br />\n";
		
		if(empty($this->id)) {
		
			print "\n<form method = \"POST\" action=\"./admin.php?action=del_utente\" />\n"
				. "\n<b>Lista Utenti: </b><br />"
				. "\n<select name = \"a_id\">\n";
					
			$this->query = $this->sql->sendQuery("SELECT * FROM ".__PREFIX__."users");
			
			while ($this->users = mysql_fetch_array ($this->query , MYSQL_ASSOC)) {
			
				$this->a_id   = $this->users['id'];
				$this->a_user = $this->users['username'];
				
				if($_COOKIE['admin_user'] != $this->a_user)
					print "\n<option value = \"".$this->a_id."\">".$this->a_user."</option>";
			}
			print "\n</select>"
				. "\n<input type = \"submit\" value = \"Cancella\">"
				. "\n<input type=\"hidden\" name=\"security\" value=\"".$_SESSION['token']."\" />"
				. "\n</form>";
		}else{
			$this->security_token($_POST['security'], $_SESSION['token']);
			
			$this->sql->sendQuery("DELETE FROM ".__PREFIX__."users WHERE id = '".$this->id."'");		
			print "<script>alert('Account ".$this->a_user." Cancellato!'); location.href = './admin.php?action=del_utente';</script>";
		}
	}
public function del_admin($id) {
		
		$this->id = intval($id);
		
		print "<h2 align=\"center\">Eliminare Amministratore</h2><br />\n";
		
		if(empty($this->id)) {
		
			print "\n<form method = \"POST\" action=\"./admin.php?action=del_admin\" />\n"
				. "\n<b>Lista Amministratori: </b><br />"
				. "\n<select name = \"a_id\">\n";
					
			$this->query = $this->sql->sendQuery("SELECT * FROM ".__PREFIX__."administrators");
			
			while ($this->users = mysql_fetch_array ($this->query , MYSQL_ASSOC)) {
			
				$this->a_id   = $this->users['id'];
				$this->a_user = $this->users['username'];
				
				if($_COOKIE['admin_user'] != $this->a_user)
					print "\n<option value = \"".$this->a_id."\">".$this->a_user."</option>";
			}
			print "\n</select>"
				. "\n<input type = \"submit\" value = \"Cancella\">"
				. "\n<input type=\"hidden\" name=\"security\" value=\"".$_SESSION['token']."\" />"
				. "\n</form>";
		}else{
			$this->security_token($_POST['security'], $_SESSION['token']);
			
			$this->sql->sendQuery("DELETE FROM ".__PREFIX__."administrators WHERE id = '".$this->id."'");		
			print "<script>alert('Account ".$this->a_user." Cancellato!'); location.href = './admin.php?action=del_admin';</script>";
		}
	}
	
	public function change_pass_admin($id) {
			
		$this->id = (int) $id;
		
		print "<h2 align=\"center\">Cambio Password Admministratori</h2><br />\n";
		
		if(empty($this->id)) {
		
			print "\n<form method = \"POST\" action=\"./admin.php?action=change_pass_admin\" />\n"
				. "\n<b>Lista Amministratori: </b><br />"
				. "\n<select name = \"a_id\">\n";
					
			$this->query = $this->sql->sendQuery("SELECT * FROM ".__PREFIX__."administrators");
			
			while ($this->users = mysql_fetch_array ($this->query , MYSQL_ASSOC)) {
			
				$this->a_id   = $this->users['id'];
				$this->a_user = $this->users['username'];
				
				print "\n<option value = \"".$this->a_id."\">".$this->a_user."</option>";
			}
			print "\n</select>"
				. "\n<input type = \"submit\" value = \"Seleziona\">"
				. "\n</form>";
		}else{
			$this->admin = mysql_fetch_array($this->sql->sendQuery("SELECT * FROM ".__PREFIX__."administrators WHERE id = '".$this->id."'"));
			
			print "\n<form method = \"POST\" action=\"./admin.php?action=change_pass_admin\" />\n"
				. "\nAdmin: <b>".$this->admin['username']."</b><br />"
				. "\nPassword: <input type=\"password\" name=\"new_pass\" /><br />"
				. "\n<input type=\"hidden\" name=\"a_id\" value=\"".$this->admin['id']."\" />"
				. "\n<input type=\"hidden\" name=\"a_user\" value=\"".$this->admin['username']."\" />"
				. "\n<input type=\"submit\" value=\"Cambia Password\" />"
				. "\n<input type=\"hidden\" name=\"security\" value=\"".$_SESSION['token']."\" />"
				. "\n</form>";
			
			if(!empty($_POST['new_pass'])) {
				$this->security_token($_POST['security'], $_SESSION['token']);
				
				$this->sql->sendQuery("UPDATE ".__PREFIX__."administrators SET password = '".md5($_POST['new_pass'])."' WHERE id = '".$this->id."'");		
				print "<script>alert('Account ".$this->VarProtect($_POST['a_user'])." Password cambiata con successo!'); location.href = './admin.php?action=change_pass_admin';</script>";
			}
		}
	}
	
	public function change_pass_utente($id) {
			
		$this->id = (int) $id;
		
		print "<h2 align=\"center\">Cambio Password Utenti</h2><br />\n";
		
		if(empty($this->id)) {
		
			print "\n<form method = \"POST\" action=\"./admin.php?action=change_pass_utente\" />\n"
				. "\n<b>Lista Utenti: </b><br />"
				. "\n<select name = \"a_id\">\n";
					
			$this->query = $this->sql->sendQuery("SELECT * FROM ".__PREFIX__."users");
			
			while ($this->users = mysql_fetch_array ($this->query , MYSQL_ASSOC)) {
			
				$this->a_id   = $this->users['id'];
				$this->a_user = $this->users['username'];
				
				print "\n<option value = \"".$this->a_id."\">".$this->a_user."</option>";
			}
			print "\n</select>"
				. "\n<input type = \"submit\" value = \"Seleziona\">"
				. "\n</form>";
		}else{
			$this->admin = mysql_fetch_array($this->sql->sendQuery("SELECT * FROM ".__PREFIX__."users WHERE id = '".$this->id."'"));
			
			print "\n<form method = \"POST\" action=\"./admin.php?action=change_pass_utente\" />\n"
				. "\nAdmin: <b>".$this->admin['username']."</b><br />"
				. "\nPassword: <input type=\"password\" name=\"new_pass\" /><br />"
				. "\n<input type=\"hidden\" name=\"a_id\" value=\"".$this->admin['id']."\" />"
				. "\n<input type=\"hidden\" name=\"a_user\" value=\"".$this->admin['username']."\" />"
				. "\n<input type=\"submit\" value=\"Cambia Password\" />"
				. "\n<input type=\"hidden\" name=\"security\" value=\"".$_SESSION['token']."\" />"
				. "\n</form>";
			
			if(!empty($_POST['new_pass'])) {
				$this->security_token($_POST['security'], $_SESSION['token']);
				
				$this->sql->sendQuery("UPDATE ".__PREFIX__."users SET password = '".md5($_POST['new_pass'])."' WHERE id = '".$this->id."'");		
				print "<script>alert('Account ".$this->VarProtect($_POST['a_user'])." Password cambiata con successo!'); location.href = './admin.php?action=change_pass_utente';</script>";
			}
		}
	}
	
	public function edit_post_tutorial($id) {
		
		$this->id = intval($id);
	
		print "<h2 align=\"center\">Modificare Articoli del Sito</h2><br />\n";
		
		if(empty($this->id)) {
			print "\n<form method = \"POST\" action=\"./admin.php?action=edit_post_tutorial\" />\n"
				. "\nID Articolo da editare: <input type=\"text\" name=\"id\" /><br />"
				. "\n<input type=\"submit\" value=\"Invia\" /></form>";
		}else{
		
	    	if(mysql_num_rows($this->sql->sendQuery("SELECT * FROM ".__PREFIX__."tutorial WHERE id = '".$this->id."'")) < 1)
				die("<script>alert(\"Articolo Inesistente!\");location.href = './admin.php?action=edit_post_tutorial';</script>");
	    		
			if (!empty($_POST['author']) && !empty($_POST['title']) && !empty($_POST['article'])) {
					
					$this->security_token($_POST['security'], $_SESSION['token']);
					
			        $this->date    = @date('d/m/y');
			        $this->article = $this->VarProtect( $_POST['article']);
			        $this->title   = $this->VarProtect( $_POST['title']  );
			        $this->author  = $this->VarProtect( $_POST['author'] );
			        $this->cat_id  = (int) $_POST['category'];
			
			        $this->sql->sendQuery("UPDATE ".__PREFIX__."tutorial SET post = '".$this->article."', title = '".$this->title."', author = '".$this->author."', cat_id = '".$this->cat_id."' WHERE id = '".$this->id."'");
			
			        print "<script>alert(\"Editato con Successo!\");</script>";
			        print '<script>window.location="./admin.php";</script>';
			    }else{
			    	$this->data_article = mysql_fetch_array($this->sql->sendQuery("SELECT * FROM ".__PREFIX__."tutorial WHERE id = '".$this->id."'"));
			    	
    				$this->cat = $this->sql->sendQuery("SELECT * FROM ".__PREFIX__."categories_tutorial");
    				
					print '<form action="./admin.php?action=edit_post_tutorial&id='.$this->id.'" method="POST">
						    Autore:<br />
    			            <input type="text" name="author" value="'.$this->data_article['author'].'"/><br /><br />
    			            Titolo:<br />
    			            <input type="text" name="title" value="'.$this->data_article['title'].'" /><br />
    			            <br />
    			      	    Categoria Associata<br />
    			      	    <select name="category">';
    			      	    
    			      	    $this->cat_name = mysql_fetch_array($this->sql->sendQuery("SELECT cat_name FROM ".__PREFIX__."categories_tutorial WHERE cat_id = ".$this->data_article['cat_id'].""));
    			      	    
		      	   print "\n<option value=\"".$this->data_article['cat_id']."\">".$this->cat_name['cat_name']."</option>";
    		      	    
    			      	    while($this->category = mysql_fetch_array($this->cat))
    			      	    	print "\n<option value=\"".$this->category['cat_id']."\">".$this->category['cat_name']."</option>";
    	      	    
		    	    print ' </select><br />
    			            Smile: :) , :( , :D , ;) , ^_^ .<br /><br />
    			            BBcode:<br />
    			            * [img] image_path [/img]<br />
							* [url= url_path ] url_name [/url]<br />
							* [url] url_path [/url]<br />
							* [b] text [/b]<br />
							* [i] text [/i]<br />
							* [u] text [/u]<br />
							<br />
    			            Contenuto Articolo:<br />
    			            <textarea name="article" cols="50" rows="10">'.$this->data_article['post'].'</textarea><br /><br />
    			            <input type="submit" value="Edita" />
    			            <br /><br />
							<input type="hidden" name="security" value="'.$_SESSION['token'].'" />
    			            </form>';
			}
		}
	}
	
	public function edit_post($id) {
		
		$this->id = intval($id);
	
		print "<h2 align=\"center\">Modificare Articoli del Blog</h2><br />\n";
		
		if(empty($this->id)) {
			print "\n<form method = \"POST\" action=\"./admin.php?action=edit_post\" />\n"
				. "\nID Articolo da editare: <input type=\"text\" name=\"id\" /><br />"
				. "\n<input type=\"submit\" value=\"Invia\" /></form>";
		}else{
		
	    	if(mysql_num_rows($this->sql->sendQuery("SELECT * FROM ".__PREFIX__."blog WHERE id = '".$this->id."'")) < 1)
				die("<script>alert(\"Articolo Inesistente!\");location.href = './admin.php?action=edit_post';</script>");
	    		
			if (!empty($_POST['author']) && !empty($_POST['title']) && !empty($_POST['article'])) {
					
					$this->security_token($_POST['security'], $_SESSION['token']);
					
			        $this->date    = @date('d/m/y');
			        $this->article = $this->VarProtect( $_POST['article']);
			        $this->title   = $this->VarProtect( $_POST['title']  );
			        $this->author  = $this->VarProtect( $_POST['author'] );
			        $this->cat_id  = (int) $_POST['category'];
			
			        $this->sql->sendQuery("UPDATE ".__PREFIX__."blog SET post = '".$this->article."', title = '".$this->title."', author = '".$this->author."', cat_id = '".$this->cat_id."' WHERE id = '".$this->id."'");
			
			        print "<script>alert(\"Editato con Successo!\");</script>";
			        print '<script>window.location="./admin.php";</script>';
			    }else{
			    	$this->data_article = mysql_fetch_array($this->sql->sendQuery("SELECT * FROM ".__PREFIX__."blog WHERE id = '".$this->id."'"));
			    	
    				$this->cat = $this->sql->sendQuery("SELECT * FROM ".__PREFIX__."categories_blog");
    				
					print '<form action="./admin.php?action=edit_post&id='.$this->id.'" method="POST">
						    Autore:<br />
    			            <input type="text" name="author" value="'.$this->data_article['author'].'"/><br /><br />
    			            Titolo:<br />
    			            <input type="text" name="title" value="'.$this->data_article['title'].'" /><br />
    			            <br />
    			      	    Categoria Associata<br />
    			      	    <select name="category">';
    			      	    
    			      	    $this->cat_name = mysql_fetch_array($this->sql->sendQuery("SELECT cat_name FROM ".__PREFIX__."categories_blog WHERE cat_id = ".$this->data_article['cat_id'].""));
    			      	    
		      	   print "\n<option value=\"".$this->data_article['cat_id']."\">".$this->cat_name['cat_name']."</option>";
    		      	    
    			      	    while($this->category = mysql_fetch_array($this->cat))
    			      	    	print "\n<option value=\"".$this->category['cat_id']."\">".$this->category['cat_name']."</option>";
    	      	    
		    	    print ' </select><br />
    			            Smile: :) , :( , :D , ;) , ^_^ .<br /><br />
    			            BBcode:<br />
    			            * [img] image_path [/img]<br />
							* [url= url_path ] url_name [/url]<br />
							* [url] url_path [/url]<br />
							* [b] text [/b]<br />
							* [i] text [/i]<br />
							* [u] text [/u]<br />
							<br />
    			            Contenuto Articolo:<br />
    			            <textarea name="article" cols="50" rows="10">'.$this->data_article['post'].'</textarea><br /><br />
    			            <input type="submit" value="Edita" />
    			            <br /><br />
							<input type="hidden" name="security" value="'.$_SESSION['token'].'" />
    			            </form>';
			}
		}
	}

	public function add_category_tutorial() {
	
		print "<h2 align=\"center\">Aggiungere Categorie al Sito</h2><br />\n";
	
		if(!empty($_POST['cat_name'])) {
	
			$this->security_token($_POST['security'], $_SESSION['token']);
		
			$this->cat_name = $this->VarProtect( $_POST['cat_name'] );
			
			$this->sql->sendQuery("INSERT INTO ".__PREFIX__."categories_tutorial (`cat_name`) VALUES ('".$this->cat_name."')");
			
			print "<script>alert(\"Categoria aggiunta con Successo!\");</script>";
			
			header('Location: ./admin.php');
		
		}else{
	
			print "\n<br /><br />"
				. "\n<form method=\"POST\" action=\"./admin.php?action=add_category_tutorial\" />"
				. "\n<table style=\"text-align: left;\" border=\"0\" cellpadding=\"2\" width=\"100%\" cellspacing=\"2\">"
				. "\n<tbody>"
				. "\n<tr>"
				. "\n	<td>Nome Categoria:</td>"
				. "\n	<td><input type=\"text\" name=\"cat_name\" /></td>"
				. "\n</tr>"
				. "\n</tbody>"
				. "\n</table>"
				. "\n<input type=\"submit\" value=\"Invia\" />"
				. "\n<input type=\"hidden\" name=\"security\" value=\"".$_SESSION['token']."\" />"
				. "\n</form>"
				."";
	
		}
	}
	
	public function add_category() {
	
		print "<h2 align=\"center\">Aggiungere Categorie al Blog</h2><br />\n";
	
		if(!empty($_POST['cat_name'])) {
	
			$this->security_token($_POST['security'], $_SESSION['token']);
		
			$this->cat_name = $this->VarProtect( $_POST['cat_name'] );
			
			$this->sql->sendQuery("INSERT INTO ".__PREFIX__."categories_blog (`cat_name`) VALUES ('".$this->cat_name."')");
			
			print "<script>alert(\"Categoria aggiunta con Successo!\");</script>";
			
			header('Location: ./admin.php');
		
		}else{
	
			print "\n<br /><br />"
				. "\n<form method=\"POST\" action=\"./admin.php?action=add_category\" />"
				. "\n<table style=\"text-align: left;\" border=\"0\" cellpadding=\"2\" width=\"100%\" cellspacing=\"2\">"
				. "\n<tbody>"
				. "\n<tr>"
				. "\n	<td>Nome Categoria:</td>"
				. "\n	<td><input type=\"text\" name=\"cat_name\" /></td>"
				. "\n</tr>"
				. "\n</tbody>"
				. "\n</table>"
				. "\n<input type=\"submit\" value=\"Invia\" />"
				. "\n<input type=\"hidden\" name=\"security\" value=\"".$_SESSION['token']."\" />"
				. "\n</form>"
				."";
	
		}
	}
	
	public function edit_category_tutorial($id) {
			
		$this->id = (int) $id;
		
		print "<h2 align=\"center\">Modificare Categorie al Sito</h2><br />\n";
		
		if(empty($this->id)) {
		
			print "\n<form method = \"POST\" action=\"./admin.php?action=edit_category_tutorial\" />\n"
				. "\n<b>Lista Categorie: </b><br />"
				. "\n<select name = \"cat_id\">\n";
					
			$this->query = $this->sql->sendQuery("SELECT * FROM ".__PREFIX__."categories_tutorial");
			
			while ($this->cat = mysql_fetch_array ($this->query , MYSQL_ASSOC)) {
			
				$this->cat_id   = $this->cat['cat_id'];
				$this->cat_name = $this->cat['cat_name'];

				print "\n<option value = \"".$this->cat_id."\">".$this->cat_name."</option>";
			}
			print "\n</select>"
				. "\n<input type = \"submit\" value = \"Seleziona\">"
				. "\n</form>";
		}else{
			$this->cat = mysql_fetch_array($this->sql->sendQuery("SELECT * FROM ".__PREFIX__."categories_tutorial WHERE cat_id = '".$this->id."'"));
			
			print "\n<form method = \"POST\" action=\"./admin.php?action=edit_category_tutorial\" />\n"
				. "\nCategory: <input type=\"text\" name=\"new_cat\" value=\"".$this->cat['cat_name']."\" /><br />"
				. "\n<input type=\"hidden\" name=\"cat_id\" value=\"".$this->id."\" />"
				. "\n<input type=\"submit\" value=\"Edita\" />"
				. "\n<input type=\"hidden\" name=\"security\" value=\"".$_SESSION['token']."\" />"
				. "\n</form>";
			
			if(!empty($_POST['new_cat'])) {
				$this->security_token($_POST['security'], $_SESSION['token']);
				
				$this->sql->sendQuery("UPDATE ".__PREFIX__."categories_tutorial SET cat_name = '".$this->VarProtect($_POST['new_cat'])."' WHERE cat_id = '".$this->id."'");		
				print "<script>alert('Categoria editata con Successo!'); location.href = './admin.php?action=edit_category_tutorial';</script>";
			}
		}
	}
	
public function edit_category($id) {
			
		$this->id = (int) $id;
		
		print "<h2 align=\"center\">Modificare Categorie al Blog</h2><br />\n";
		
		if(empty($this->id)) {
		
			print "\n<form method = \"POST\" action=\"./admin.php?action=edit_category\" />\n"
				. "\n<b>Lista Categorie: </b><br />"
				. "\n<select name = \"cat_id\">\n";
					
			$this->query = $this->sql->sendQuery("SELECT * FROM ".__PREFIX__."categories_blog");
			
			while ($this->cat = mysql_fetch_array ($this->query , MYSQL_ASSOC)) {
			
				$this->cat_id   = $this->cat['cat_id'];
				$this->cat_name = $this->cat['cat_name'];

				print "\n<option value = \"".$this->cat_id."\">".$this->cat_name."</option>";
			}
			print "\n</select>"
				. "\n<input type = \"submit\" value = \"Seleziona\">"
				. "\n</form>";
		}else{
			$this->cat = mysql_fetch_array($this->sql->sendQuery("SELECT * FROM ".__PREFIX__."categories_blog WHERE cat_id = '".$this->id."'"));
			
			print "\n<form method = \"POST\" action=\"./admin.php?action=edit_category\" />\n"
				. "\nCategory: <input type=\"text\" name=\"new_cat\" value=\"".$this->cat['cat_name']."\" /><br />"
				. "\n<input type=\"hidden\" name=\"cat_id\" value=\"".$this->id."\" />"
				. "\n<input type=\"submit\" value=\"Edita\" />"
				. "\n<input type=\"hidden\" name=\"security\" value=\"".$_SESSION['token']."\" />"
				. "\n</form>";
			
			if(!empty($_POST['new_cat'])) {
				$this->security_token($_POST['security'], $_SESSION['token']);
				
				$this->sql->sendQuery("UPDATE ".__PREFIX__."categories_blog SET cat_name = '".$this->VarProtect($_POST['new_cat'])."' WHERE cat_id = '".$this->id."'");		
				print "<script>alert('Categoria editata con Successo!'); location.href = './admin.php?action=edit_category';</script>";
			}
		}
	}
	
	public function del_category_tutorial($id) {
	
		$this->id = (int) $id;
		
		print "<h2 align=\"center\">Eliminare Categorie al Sito</h2><br />\n";
	
		if(empty($this->id)) {
		
			print "\n<form method = \"POST\" action=\"./admin.php?action=del_category\" />"
				. "\n<b>Lista Categorie: </b><br />"
				. "\n<select name = \"cat_id\">";
					
			$this->query = $this->sql->sendQuery("SELECT * FROM ".__PREFIX__."categories_tutorial");
			
			while ($this->cat = mysql_fetch_array ($this->query , MYSQL_ASSOC)) {
			
				$this->cat_id   = $this->cat['cat_id'];
				$this->cat_name = $this->cat['cat_name'];
				
				$this->num_art_for_cat = mysql_num_rows($this->sql->sendQuery("SELECT * FROM ".__PREFIX__."tutorial WHERE cat_id = '".$this->cat_id."'"));
				
				print "\n<option value = \"".$this->cat_id."\">".$this->cat_name." (".$this->num_art_for_cat.")</option>";
			}
			
			print "\n</select>"
				. "\n<input type = \"submit\" value = \"Cancella\">"
				. "\n<input type=\"hidden\" name=\"security\" value=\"".$_SESSION['token']."\" />"
				. "\n</form>";
		}else{
			$this->security_token($_POST['security'], $_SESSION['token']);
			
			$this->sql->sendQuery("DELETE FROM ".__PREFIX__."categories_tutorial WHERE cat_id = '".$this->id."'");		
			print "<script>alert('Categoria Cancellata con Successo!'); location.href = './admin.php?action=del_category_tutorial';</script>";
		}
	}
	
	public function del_category($id) {
	
		$this->id = (int) $id;
		
		print "<h2 align=\"center\">Eliminare Categorie al Blog</h2><br />\n";
	
		if(empty($this->id)) {
		
			print "\n<form method = \"POST\" action=\"./admin.php?action=del_category\" />"
				. "\n<b>Lista Categorie: </b><br />"
				. "\n<select name = \"cat_id\">";
					
			$this->query = $this->sql->sendQuery("SELECT * FROM ".__PREFIX__."categories_blog");
			
			while ($this->cat = mysql_fetch_array ($this->query , MYSQL_ASSOC)) {
			
				$this->cat_id   = $this->cat['cat_id'];
				$this->cat_name = $this->cat['cat_name'];
				
				$this->num_art_for_cat = mysql_num_rows($this->sql->sendQuery("SELECT * FROM ".__PREFIX__."blog WHERE cat_id = '".$this->cat_id."'"));
				
				print "\n<option value = \"".$this->cat_id."\">".$this->cat_name." (".$this->num_art_for_cat.")</option>";
			}
			
			print "\n</select>"
				. "\n<input type = \"submit\" value = \"Cancella\">"
				. "\n<input type=\"hidden\" name=\"security\" value=\"".$_SESSION['token']."\" />"
				. "\n</form>";
		}else{
			$this->security_token($_POST['security'], $_SESSION['token']);
			
			$this->sql->sendQuery("DELETE FROM ".__PREFIX__."categories_blog WHERE cat_id = '".$this->id."'");		
			print "<script>alert('Categoria Cancellata con Successo!'); location.href = './admin.php?action=del_category';</script>";
		}
	}
	
}	
?>		

