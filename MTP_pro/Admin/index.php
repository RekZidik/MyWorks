<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8"/>
<link rel="stylesheet" href="style.css"/>
<title>Zone_administrateur</title>
</head>

<body>
<header> 
</header>
<center>
<nav> 
<?php include("interface_connexion.php"); ?>
</nav>
<section>
<?php
include("heure_monde.php");
// connexion a la base de donnée
 include("connexion_bdd.php"); 
//Renvoie le nombre d'entré dans chaque table
$rep = $bdd->query('SELECT COUNT(*) AS nbr_message FROM location ');
$donnees=$rep->fetch();
$rep->closeCursor();
$nbr_location=$donnees['nbr_message'];
$rep = $bdd->query('SELECT COUNT(*) AS nbr_message FROM reclamation ');
$donnees=$rep->fetch();
$rep->closeCursor();
$nbr_reclamation=$donnees['nbr_message'];
$rep = $bdd->query('SELECT COUNT(*) AS nbr_message FROM membres ');
$donnees=$rep->fetch();
$rep->closeCursor();
$nbr_membres=$donnees['nbr_message'];
$rep = $bdd->query('SELECT COUNT(*) AS nbr_message FROM engin ');
$donnees=$rep->fetch();
$rep->closeCursor();
$nbr_engin=$donnees['nbr_message'];
$rep = $bdd->query('SELECT COUNT(*) AS nbr_message FROM news ');
$donnees=$rep->fetch();
$rep->closeCursor();
$nbr_news=$donnees['nbr_message'];
$rep = $bdd->query('SELECT COUNT(*) AS nbr_message FROM mini_chat ');
$donnees=$rep->fetch();
$rep->closeCursor();
$nbr_forum=$donnees['nbr_message'];
//Renvoie le nombre d'entré depuis T0
$compteur_id = fopen('../Modele/compteur_id_membres.txt','r+');
$comp_membres = fgets($compteur_id);
fclose($compteur_id);
$compteur_id = fopen('compteur_id_news.txt','r+');
$comp_news = fgets($compteur_id);
fclose($compteur_id);
$compteur_id = fopen('../Modele/compteur_id_location.txt','r+');
$comp_location = fgets($compteur_id);
fclose($compteur_id);
$compteur_id = fopen('../Modele/compteur_id_reclamation.txt','r+');
$comp_reclamation = fgets($compteur_id);
fclose($compteur_id);
$compteur_id = fopen('../Modele/compteur_id_forum.txt','r+');
$comp_forum = fgets($compteur_id);
fclose($compteur_id);
$compteur_id = fopen('compteur_id_engin.txt','r+');
$comp_engin = fgets($compteur_id);
fclose($compteur_id);
//Renvoie le nombre de visiteurs
$compteur_id = fopen('../Modele/compteur_visiteur.txt','r+');
$comp_visiteur = fgets($compteur_id);
fclose($compteur_id);


echo('
<table width="1200" border="1" cellspacing="2">
  <tr>
    <th scope="col">Table</th>
    <th scope="col">Actuelle</th>
    <th scope="col">T0</th>
  </tr>
  <tr>
    <th scope="row">Forum</th>
    <td>'.$nbr_forum.'</td>
    <td>'.$comp_forum.'</td>
  </tr>
  <tr>
    <th scope="row">Membres</th>
    <td>'.$nbr_membres.'</td>
    <td>'.$comp_membres.'</td>
  </tr>

  <tr>
    <th scope="row">Engin</th>
    <td>'.$nbr_engin.'</td>
    <td>'.$comp_engin.'</td>
  </tr>
  <tr>
    <th scope="row">News</th>
    <td>'.$nbr_news.'</td>
    <td>'.$comp_news.'</td>
  </tr>
  <tr>
    <th scope="row">Reclamation</th>
    <td>'.$nbr_reclamation.'</td>
    <td>'.$comp_reclamation.'</td>
  </tr>
  <tr>
    <th scope="row">Location</th>
    <td>'.$nbr_location.'</td>
    <td>'.$comp_location.'</td>
  </tr>
  <tr>
    <th scope="row">Nbr visiteur</th>
    <td colspan="2">'.$comp_visiteur.'</td>
  </tr>
</table>
');
?>
</section>
<footer></footer>
</center>
</body>
</html>

