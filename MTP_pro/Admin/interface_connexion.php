<ul>
<li> <a href="index.php" > Acceuil </a> </li>
<li> <a href="gestion_engin.php" > Gerer_engins </a> </li>
<li> <a href="gestion_membres.php" > Gerer_membres </a> </li>
<li> <a href="gestion_forum.php" > Gerer_forum </a> </li>
<li> <a href="gestion_news.php" > Gerer_news </a> </li>
<li> <a href="gestion_location.php" > Gerer_location </a> </li>
<li> <a href="gestion_reclamation.php" > Gerer_reclamation </a> </li>
<li> <a href="modif_info.php" > Modifier_compte </a> </li>
</ul>
<?php
if (isset($_SESSION['pseudo'] ))
{
 echo('<map>bienvenue Monssieur :<strong>'.$_SESSION['pseudo'].'</strong> <a href="../deconnexion.php"> Deconnexion </a>  </map> ');
 }else 
  {
   header('Location:../index.php');
  }
?>