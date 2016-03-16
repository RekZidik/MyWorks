<?php
session_start();
if (isset($_SERVER['REMOTE_ADDR']) and  !isset($_SESSION['adresse_ip'])) 
{ 

     $_SESSION['adresse_ip']=$_SERVER['REMOTE_ADDR'];
     $monfichier = fopen('Modele/compteur_visiteur.txt', 'r+');
     $pages_vues = fgets($monfichier); // On lit la première ligne(nombre de pages vues)
     $pages_vues++; // On augmente de 1 ce nombre de pages vues
     fseek($monfichier, 0); // On remet le curseur au début du fichier
     fputs($monfichier, $pages_vues); // On écrit le nouveau nombre de pages vues
     fclose($monfichier);
	 $_SESSION['num_visitor']=$pages_vues;   
}  
?>