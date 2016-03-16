<?php
session_start();
// Suppression des variables de session et de la session
$_SESSION = array();
session_destroy();
// Suppression des cookies de connexion automatique
setcookie('pseudo','',0); 
setcookie('pass_hache','',0);
header('Location:index.php');
?>



   