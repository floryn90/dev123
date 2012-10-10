<?php

include(CLASSES_DIR . "loader.class.php");

$login = new Login();

$user = empty($_COOKIE['admin_user']) ? $_COOKIE['normal_user'] : $_COOKIE['admin_user'];

$pass = empty($_COOKIE['admin_pass']) ? $_COOKIE['normal_pass'] : $_COOKIE['admin_pass'];

$login->logout($user, $pass, $_GET['token']);

?>
