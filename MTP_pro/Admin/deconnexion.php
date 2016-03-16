<?php
session_start();
// Suppression des variables de session et de la session
$_SESSION = array();
session_destroy();
// Suppression des cookies de connexion automatique
setcookie('Login', '');
setcookie('pass_hache', '');
header('Location:index.php');
?>



   