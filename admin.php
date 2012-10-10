<?php
/*
 *
 * @page index.php (admin.php)
 * @author Vincenzo Luongo
 *
 * @date 26/11/2011 && 16/01/2012 && 18/04/2012
 *
 * Note: Pagina di amministrazione
 *
 */

ob_start();
session_start();

define("CLASSES_DIR", "classes/");

include(CLASSES_DIR . "security.class.php");
include(CLASSES_DIR . "admin.class.php");
include(CLASSES_DIR . "login.class.php");
include(CLASSES_DIR . "AdminTemplate.class.php");

$template = new AdminTemplate();
$admin    = new Admin();
$login    = new Login();

$template->_TPrint_open();

if(empty($_COOKIE['admin_user']) || empty($_COOKIE['admin_pass']))

    $login->form_login(@$_REQUEST['user'], @$_REQUEST['pass']);
    
elseif($login->is_admin($_COOKIE['admin_user'], $_COOKIE['admin_pass']) == FALSE)

    die(header("Location: ./index.php"));
    
    
switch(@$_GET['action']) {

	/* Manager blog */
	case 'add_post':
		$admin->add_post();
	break;
	
    case 'manage_blog':
		$admin->manage_blog();
	break;

	case 'edit_post';
		$admin->edit_post(@$_REQUEST['id']);
	break;
	
	case 'del_post':
		$admin->del_post(@$_REQUEST['id']);
	break;
	
	/* Manager site */
	case 'add_post_tutorial':
		$admin->add_post_tutorial();
	break;
	
    case 'manage_tutorial':
		$admin->manage_tutorial();
	break;

	case 'edit_post_tutorial';
		$admin->edit_post_tutorial(@$_REQUEST['id']);
	break;
	
	case 'del_post_tutorial':
		$admin->del_post_tutorial(@$_REQUEST['id']);
	break;
	
	//manage comments blog
	case 'manage_comments':
		$admin->manage_comments(@$_GET['id']);
	break;
	
	case 'del_comment':
		$admin->del_comment(@$_POST['id']);
	break;
	
	//manage comments site
	case 'manage_comments_tutorial':
		$admin->manage_comments_tutorial(@$_GET['id']);
	break;
	
	case 'del_comment_tutorial':
		$admin->del_comment_tutorial(@$_POST['id']);
	break;


	/* Manage Categories of Blog*/
	case 'add_category':
		$admin->add_category();
	break;
	
	case 'edit_category';
		$admin->edit_category(@$_REQUEST['cat_id']);
	break;
	
	case 'del_category':
		$admin->del_category(@$_REQUEST['cat_id']);
	break;
		
	/* Manage Categories of Site*/
	case 'add_category_tutorial':
		$admin->add_category_tutorial();
	break;
	
	case 'edit_category_tutorial';
		$admin->edit_category_tutorial(@$_REQUEST['cat_id']);
	break;
	
	case 'del_category_tutorial':
		$admin->del_category_tutorial(@$_REQUEST['cat_id']);
	break;
		
	
    /* Manage Tutorial */
	case 'add_tutorial':
		$tutorial->add_tutorial();
	break;

	case 'edit_tutorial';
		$tutorial->edit_tutorial(@$_REQUEST['id']);
	break;
	
	case 'del_tutorial':
		$tutorial->del_tutorial(@$_REQUEST['id']);
	break;
	/*
	//registrazione utente
	case 'add_user':
		$admin->add_user();
		*/
	/* Admin struments */
	case 'add_admin':
		$admin->add_admin();
	break;
	
	case 'del_admin':
		$admin->del_admin(@$_POST['a_id']);
	break;
	
	case 'change_pass_admin':
		$admin->change_pass_admin(@$_POST['a_id']);
	break;
	
	case 'add_utente':
		$admin->add_utente();
	break;
	
	case 'del_utente':
		$admin->del_utente(@$_REQUEST['a_id']);
	break;
	
	case 'change_pass_utente':
		$admin->change_pass_utente(@$_POST['a_id']);
	break;
	
	case 'logout':
		$login->logout(@$_COOKIE['Username'], @$_COOKIE['Password'], @$_GET['token']);
	break;

	default:
		$admin->show_administration();
	break;
}

$template->_TPrint_close();
?>
